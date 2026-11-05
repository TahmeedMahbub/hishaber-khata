<?php

namespace Tests\Feature;

use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_privacy_policy_is_public_with_seo_metadata(): void
    {
        $this->get('/privacy-policy')->assertOk()
            ->assertSee('<title>Privacy Policy | Hishabiz</title>', false)
            ->assertSee('<link rel="canonical" href="' . url('/privacy-policy') . '">', false)
            ->assertSee('name="description"', false)
            ->assertSee('Google Login')
            ->assertSee('hishabiz.support@gmail.com');
    }

    public function test_terms_of_service_is_public_with_seo_metadata(): void
    {
        $this->get('/terms-of-service')->assertOk()
            ->assertSee('<title>Terms of Service | Hishabiz</title>', false)
            ->assertSee('<link rel="canonical" href="' . url('/terms-of-service') . '">', false)
            ->assertSee('Bangladesh');
    }

    public function test_landing_footer_and_register_page_link_to_legal_pages(): void
    {
        foreach (['/', '/register'] as $path) {
            $this->get($path)->assertOk()
                ->assertSee(route('legal.privacy'), false)
                ->assertSee(route('legal.terms'), false);
        }
    }

    public function test_sitemap_lists_legal_pages_and_auth_pages_still_work(): void
    {
        $this->get('/sitemap.xml')->assertOk()
            ->assertSee('/privacy-policy', false)->assertSee('/terms-of-service', false);
        $this->get('/login')->assertOk();
    }
}
