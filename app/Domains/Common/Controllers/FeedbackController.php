<?php

namespace App\Domains\Common\Controllers;

use App\Domains\Common\Models\Feedback;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    /**
     * In-app feedback form (authenticated).
     */
    public function create(): View
    {
        return view('contents.feedback.create', [
            'types' => $this->types(),
        ]);
    }

    /**
     * Store feedback from inside the app (authenticated user/tenant).
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateFeedback($request);

        $user = auth()->user();

        Feedback::create([
            'tenant_id' => $user?->tenant_id,
            'user_id'   => $user?->id,
            'name'      => $data['name'] ?? $user?->name,
            'phone'     => $data['phone'] ?? $user?->phone,
            'email'     => $data['email'] ?? $user?->email,
            'type'      => $data['type'],
            'rating'    => $data['rating'] ?? null,
            'message'   => $data['message'],
            'source'    => 'app',
            'status'    => 'new',
        ]);

        return redirect()->route('feedback.create')
            ->with('success', t('msg.feedback_thanks'));
    }

    /**
     * Store feedback from the public landing page (guest — no tenant/user).
     */
    public function storePublic(Request $request): RedirectResponse
    {
        $data = $this->validateFeedback($request, public: true);

        Feedback::create([
            'tenant_id' => null,
            'user_id'   => null,
            'name'      => $data['name'] ?? null,
            'phone'     => $data['phone'] ?? null,
            'email'     => $data['email'] ?? null,
            'type'      => $data['type'] ?? 'other',
            'rating'    => $data['rating'] ?? null,
            'message'   => $data['message'],
            'source'    => 'landing',
            'status'    => 'new',
        ]);

        return back()->with('feedback_success', t('msg.feedback_thanks'));
    }

    /**
     * @return array<string, mixed>
     */
    protected function validateFeedback(Request $request, bool $public = false): array
    {
        return $request->validate([
            'name'    => [$public ? 'nullable' : 'nullable', 'string', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'email'   => ['nullable', 'email', 'max:150'],
            'type'    => ['required', 'in:suggestion,bug,complaint,praise,other'],
            'rating'  => ['nullable', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'type.required'    => t('valid.feedback_type_required'),
            'message.required' => t('valid.feedback_message_required'),
        ]);
    }

    /**
     * @return array<string, string>
     */
    protected function types(): array
    {
        return [
            'suggestion' => t('feedback.type_suggestion'),
            'bug'        => t('feedback.type_bug'),
            'complaint'  => t('feedback.type_complaint'),
            'praise'     => t('feedback.type_praise'),
            'other'      => t('feedback.type_other'),
        ];
    }
}
