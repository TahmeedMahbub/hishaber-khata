<?php

namespace Tests\Feature;

use App\Domains\Category\Models\Category;
use App\Domains\Tenant\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use DatabaseTransactions;

    protected function mockGoogle(?SocialiteUser $user = null, ?\Throwable $throw = null): void
    {
        $provider = Mockery::mock(Provider::class);
        $expectation = $provider->shouldReceive('user');
        $throw ? $expectation->andThrow($throw) : $expectation->andReturn($user);

        $factory = Mockery::mock(SocialiteFactory::class);
        $factory->shouldReceive('driver')->with('google')->andReturn($provider);
        $this->app->instance(SocialiteFactory::class, $factory);
    }

    protected function googleUser(string $email, string $id = 'g-123', bool $verified = true): SocialiteUser
    {
        $u = new SocialiteUser();
        $u->id = $id;
        $u->name = 'Google Person';
        $u->email = $email;
        $u->user = ['sub' => $id, 'email' => $email, 'email_verified' => $verified];

        return $u;
    }

    protected function makeOwner(string $email, array $extra = []): User
    {
        $tenant = Tenant::create([
            'name' => 'Existing Shop', 'owner_name' => 'Owner', 'phone' => '019' . random_int(10000000, 99999999),
            'business_type' => 'grocery', 'status' => 'active',
        ]);

        return User::create(array_merge([
            'tenant_id' => $tenant->id, 'name' => 'Owner', 'phone' => $tenant->phone, 'email' => $email,
            'password' => 'secret123', 'role' => 'owner', 'status' => 'active',
        ], $extra));
    }

    public function test_login_and_register_pages_show_google_button(): void
    {
        $this->get('/login')->assertOk()->assertSee(route('auth.google'), false);
        $this->get('/register')->assertOk()->assertSee(route('auth.google'), false);
    }

    public function test_redirects_to_google_with_state_and_exact_callback_uri(): void
    {
        config([
            'services.google.client_id' => 'cid',
            'services.google.client_secret' => 'test-secret-value',
            'services.google.redirect' => 'https://hishabiz.com/auth/google/callback',
        ]);

        $response = $this->get('/auth/google');
        $response->assertRedirect();
        $location = $response->headers->get('Location');
        $this->assertStringStartsWith('https://accounts.google.com/', $location);
        parse_str(parse_url($location, PHP_URL_QUERY), $q);
        $this->assertSame('https://hishabiz.com/auth/google/callback', $q['redirect_uri']);
        $this->assertNotEmpty($q['state']);
        $this->assertStringNotContainsString('test-secret-value', $location);
    }

    public function test_existing_password_account_is_not_linked_silently(): void
    {
        $user = $this->makeOwner('existing@example.com');
        $hash = $user->password;
        $this->mockGoogle($this->googleUser('Existing@Example.com'));

        $this->get('/auth/google/callback?code=abc&state=xyz')->assertRedirect(route('auth.google.link'));

        $this->assertGuest();
        $this->assertNull($user->fresh()->google_id);
        $this->assertSame(1, User::where('email', 'existing@example.com')->count());
        $this->assertDatabaseMissing('google_registrations', ['google_id' => 'g-123']);

        // Wrong password: still guest, not linked.
        $this->post('/auth/google/link', ['password' => 'wrong'])->assertSessionHasErrors('password');
        $this->assertGuest();
        $this->assertNull($user->fresh()->google_id);

        // Correct password: linked and logged in; password and tenant unchanged.
        $this->post('/auth/google/link', ['password' => 'secret123'])->assertRedirect('/dashboard');
        $fresh = $user->fresh();
        $this->assertAuthenticatedAs($fresh);
        $this->assertSame('g-123', $fresh->google_id);
        $this->assertSame($hash, $fresh->password);
        $this->assertSame($user->tenant_id, $fresh->tenant_id);
        $this->assertNotNull($fresh->email_verified_at);
    }

    public function test_linked_user_logs_in_directly_next_time(): void
    {
        $user = $this->makeOwner('linked-ok@example.com', ['google_id' => 'g-123']);
        $this->mockGoogle($this->googleUser('linked-ok@example.com'));

        $this->get('/auth/google/callback?code=abc&state=xyz')->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user->fresh());
    }

    public function test_link_form_requires_prior_google_step(): void
    {
        $this->get('/auth/google/link')->assertRedirect('/login');
        $this->post('/auth/google/link', ['password' => 'secret123'])->assertRedirect('/login');
    }

    public function test_incomplete_registration_can_be_resumed_without_duplicates(): void
    {
        $this->mockGoogle($this->googleUser('resume@example.com', 'g-resume'));
        $this->get('/auth/google/callback?code=abc&state=xyz')->assertRedirect(route('auth.google.complete'));
        $this->assertDatabaseHas('google_registrations', ['google_id' => 'g-resume', 'email' => 'resume@example.com']);
        $this->assertDatabaseMissing('users', ['email' => 'resume@example.com']);

        // User leaves (fresh session), comes back via Google later.
        $this->flushSession();
        $this->get('/auth/google/complete')->assertRedirect('/login');
        $this->get('/auth/google/callback?code=def&state=xyz2')->assertRedirect(route('auth.google.complete'));
        $this->assertSame(1, \App\Domains\Auth\Models\GoogleRegistration::where('google_id', 'g-resume')->count());

        $this->post('/auth/google/complete', [
            'business_name' => 'Resumed Shop', 'owner_name' => 'R', 'phone' => '015' . random_int(10000000, 99999999),
            'business_type' => array_key_first(config('business_types.types')),
        ])->assertRedirect(route('dashboard'));

        $this->assertSame(1, User::where('email', 'resume@example.com')->count());
        $this->assertDatabaseMissing('google_registrations', ['google_id' => 'g-resume']);
    }

    public function test_expired_pending_registration_is_not_usable(): void
    {
        $this->mockGoogle($this->googleUser('old@example.com', 'g-old'));
        $this->get('/auth/google/callback?code=abc&state=xyz');
        \App\Domains\Auth\Models\GoogleRegistration::where('google_id', 'g-old')->update(['expires_at' => now()->subDay()]);

        $this->get('/auth/google/complete')->assertRedirect('/login');
    }

    public function test_form_prefills_defaults_and_email_cannot_be_overridden(): void
    {
        $this->mockGoogle($this->googleUser('first@example.com', 'g-first'));
        $this->get('/auth/google/callback?code=abc&state=xyz');

        $this->get('/auth/google/complete')->assertOk()
            ->assertSee("Google's Business")->assertDontSee('name="password"', false);

        $this->post('/auth/google/complete', [
            'business_name' => 'B', 'owner_name' => 'O', 'phone' => '014' . random_int(10000000, 99999999),
            'business_type' => array_key_first(config('business_types.types')),
            'email' => 'attacker@example.com',
        ]);
        $this->assertDatabaseHas('users', ['email' => 'first@example.com']);
        $this->assertDatabaseMissing('users', ['email' => 'attacker@example.com']);
    }

    public function test_google_registered_user_cannot_see_other_tenant_data(): void
    {
        $other = $this->makeOwner('other-tenant@example.com');
        Category::withoutGlobalScopes()->create(['tenant_id' => $other->tenant_id, 'name' => 'SecretOtherCategory', 'status' => 'active']);

        $this->mockGoogle($this->googleUser('isolated@example.com', 'g-iso'));
        $this->get('/auth/google/callback?code=abc&state=xyz');
        $this->post('/auth/google/complete', [
            'business_name' => 'Iso Shop', 'owner_name' => 'I', 'phone' => '013' . random_int(10000000, 99999999),
            'business_type' => array_key_first(config('business_types.types')),
        ])->assertRedirect(route('dashboard'));

        $user = User::where('email', 'isolated@example.com')->firstOrFail();
        $this->assertNotSame($other->tenant_id, $user->tenant_id);
        $this->get('/categories')->assertOk()->assertDontSee('SecretOtherCategory');
    }

    public function test_user_linked_to_different_google_account_is_refused(): void
    {
        $this->makeOwner('linked@example.com', ['google_id' => 'other-sub']);
        $this->mockGoogle($this->googleUser('linked@example.com', 'g-999'));

        $this->get('/auth/google/callback?code=abc&state=xyz')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login_with_google(): void
    {
        $this->makeOwner('inactive@example.com', ['status' => 'inactive']);
        $this->mockGoogle($this->googleUser('inactive@example.com'));

        $this->get('/auth/google/callback?code=abc&state=xyz')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_new_google_user_goes_through_onboarding_and_gets_own_tenant(): void
    {
        $this->mockGoogle($this->googleUser('brandnew@example.com', 'g-new'));

        $this->get('/auth/google/callback?code=abc&state=xyz')->assertRedirect(route('auth.google.complete'));
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'brandnew@example.com']);

        $this->get('/auth/google/complete')->assertOk()->assertSee('brandnew@example.com');

        $phone = '016' . random_int(10000000, 99999999);
        $this->post('/auth/google/complete', [
            'business_name' => 'New Shop', 'owner_name' => 'New Owner', 'phone' => $phone,
            'business_type' => array_key_first(config('business_types.types')),
        ])->assertRedirect(route('dashboard'));

        $user = User::where('email', 'brandnew@example.com')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertSame('owner', $user->role);
        $this->assertSame('g-new', $user->google_id);
        $this->assertNotNull($user->email_verified_at);
        $this->assertSame('New Shop', $user->tenant->name);
        $this->assertSame(1, Tenant::where('name', 'New Shop')->count());
    }

    public function test_onboarding_rejects_duplicate_phone_and_missing_session(): void
    {
        $existing = $this->makeOwner('dupe-phone@example.com');
        $this->post('/auth/google/complete', [])->assertRedirect('/login');

        $this->mockGoogle($this->googleUser('another@example.com', 'g-2'));
        $this->get('/auth/google/callback?code=abc&state=xyz');
        $this->post('/auth/google/complete', [
            'business_name' => 'X', 'owner_name' => 'Y', 'phone' => $existing->phone,
            'business_type' => array_key_first(config('business_types.types')),
        ])->assertSessionHasErrors('phone');
        $this->assertDatabaseMissing('users', ['email' => 'another@example.com']);
    }

    public function test_cancelled_google_login(): void
    {
        $this->get('/auth/google/callback?error=access_denied')
            ->assertRedirect('/login')->assertSessionHasErrors('google');
        $this->assertGuest();
    }

    public function test_invalid_state_or_missing_code_is_rejected(): void
    {
        $this->mockGoogle(null, new InvalidStateException());
        $this->get('/auth/google/callback?code=abc&state=forged')
            ->assertRedirect('/login')->assertSessionHasErrors('google');
        $this->assertGuest();

        $this->get('/auth/google/callback')->assertRedirect('/login')->assertSessionHasErrors('google');
    }

    public function test_unverified_or_missing_email_is_rejected(): void
    {
        $this->mockGoogle($this->googleUser('unverified@example.com', 'g-u', false));
        $this->get('/auth/google/callback?code=abc&state=xyz')->assertRedirect('/login');
        $this->assertDatabaseMissing('users', ['email' => 'unverified@example.com']);

        $this->mockGoogle($this->googleUser('', 'g-e'));
        $this->get('/auth/google/callback?code=abc&state=xyz')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_password_login_still_works(): void
    {
        $user = $this->makeOwner('pw@example.com');

        $this->post('/login', ['phone' => 'pw@example.com', 'password' => 'secret123'])
            ->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('secret123', $user->fresh()->password));
    }
}
