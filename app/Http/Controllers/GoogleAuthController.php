<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Office;
use App\Models\User;
use App\Models\WhitelistedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $email = strtolower($googleUser->getEmail());

        if (! str_ends_with($email, '@deped.gov.ph')) {
            return view('auth.account-not-authorized', [
                'message' => 'Only official DepEd Google accounts may log in to this system.',
            ]);
        }

        $whitelisted = WhitelistedUser::active()->where('email', $email)->first();
        $existingUser = User::where('email', $email)->first();

        $officeName = $whitelisted?->office ?? $existingUser?->office;
        $office = filled($officeName)
            ? Office::query()->firstOrCreate(['name' => $officeName])
            : null;

        if (! $whitelisted && ! $existingUser) {
            return view('auth.account-not-authorized', [
                'message' => 'Your account is not yet authorized. Please contact the system administrator.',
            ]);
        }

        $user = $existingUser ?? User::create([
            'name' => $googleUser->getName(),
            'email' => $email,
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'office' => $office?->name ?? $whitelisted?->office,
            'office_id' => $office?->id,
            'role' => UserRole::USER->value,
            'email_verified_at' => now(),
        ]);

        $user->update([
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'office' => $office?->name ?? $user->office,
            'office_id' => $office?->id ?? $user->office_id,
            'email_verified_at' => $user->email_verified_at ?? now(),
        ]);

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
