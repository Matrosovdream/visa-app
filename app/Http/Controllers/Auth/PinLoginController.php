<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class PinLoginController extends Controller
{
    /**
     * Authenticate an admin/manager by PIN only.
     *
     * The pin is stored as a bcrypt hash (same mechanism as password), so we
     * have to iterate candidate users and Hash::check each. That's acceptable
     * here because the pin is a staff-only convenience login and the set of
     * users with a pin assigned is small.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pin' => ['required', 'string', 'min:3', 'max:20'],
        ]);

        // Coarse rate-limit by IP so someone can't brute-force 3-digit pins.
        $key = 'pin-login:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 8)) {
            throw ValidationException::withMessages([
                'pin' => 'Too many attempts. Please wait a minute and try again.',
            ]);
        }
        RateLimiter::hit($key, 60);

        $pin = (string) $request->input('pin');

        $user = User::whereNotNull('pin')
            ->where('is_active', true)
            ->get()
            ->first(fn ($u) => Hash::check($pin, $u->pin));

        if (!$user) {
            throw ValidationException::withMessages([
                'pin' => 'Invalid PIN.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        RateLimiter::clear($key);

        return redirect()->intended(route('dashboard.home', absolute: false));
    }
}
