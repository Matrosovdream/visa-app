<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
        <div class="text-gray-500 fw-semibold fs-6">Choose a sign-in method</div>
    </div>

    @php
        // When validation fails on the pin form we want to show the PIN tab
        // on reload, otherwise default to the email tab.
        $activeTab = $errors->hasAny(['pin']) ? 'pin' : 'email';
    @endphp

    <ul class="nav nav-tabs nav-fill mb-6 w-100" id="loginTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'email' ? 'active' : '' }}"
                id="email-tab" data-login-tab="email-pane"
                type="button" role="tab" aria-controls="email-pane"
                aria-selected="{{ $activeTab === 'email' ? 'true' : 'false' }}">
                {{ __('Email') }}
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'pin' ? 'active' : '' }}"
                id="pin-tab" data-login-tab="pin-pane"
                type="button" role="tab" aria-controls="pin-pane"
                aria-selected="{{ $activeTab === 'pin' ? 'true' : 'false' }}">
                {{ __('PIN') }}
            </button>
        </li>
    </ul>

    <div class="tab-content w-100" id="loginTabsContent">
    <div class="tab-pane fade {{ $activeTab === 'email' ? 'show active' : '' }}"
        id="email-pane" role="tabpanel" aria-labelledby="email-tab">

    <form class="form w-100" id="kt_sign_in_form"
        method="POST" action="{{ route('login') }}">

        @csrf

        <!--
        <div class="row g-3 mb-9">
            <div class="col-md-6">
                <a href="#"
                    class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                    <img alt="Logo" src="{{ asset('assets/admin/media/svg/brand-logos/google-icon.svg') }}"
                        class="h-15px me-3" />Sign in with Google</a>
            </div>
            <div class="col-md-6">
                <a href="#"
                    class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                    <img alt="Logo" src="{{ asset('assets/admin/media/svg/brand-logos/apple-black.svg') }}"
                        class="theme-light-show h-15px me-3" />
                    <img alt="Logo" src="{{ asset('assets/admin/media/svg/brand-logos/apple-black-dark.svg') }}"
                        class="theme-dark-show h-15px me-3" />Sign in with Apple</a>
            </div>
        </div>
        
        <div class="separator separator-content my-14">
            <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
        </div>
        -->

        <!-- Email Address -->
        <div class="fv-row mb-8">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control bg-transparent" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="fv-row mb-8">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="form-control bg-transparent" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        @if (Route::has('password.request'))
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <div></div>
                <a 
                    href="{{ route('password.request') }}" 
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Forgot Password ?
                </a>
            </div>
        @endif

        <div class="d-grid mb-10">

            <x-primary-button id="kt_sign_in_submit" class="btn btn-primary">
                {{ __('Log in') }}
            </x-primary-button>

        </div>
        <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
            <a href="{{ route('register') }}" class="link-primary">Sign up</a>
        </div>
    </form>

    </div>{{-- /email-pane --}}

    <div class="tab-pane fade {{ $activeTab === 'pin' ? 'show active' : '' }}"
        id="pin-pane" role="tabpanel" aria-labelledby="pin-tab">

        <form class="form w-100" method="POST" action="{{ route('backend.login.pin') }}">
            @csrf

            <div class="fv-row mb-8">
                <x-input-label for="pin" :value="__('PIN')" />
                <x-text-input id="pin" class="form-control bg-transparent text-center"
                    type="password" name="pin" required autofocus autocomplete="off"
                    inputmode="numeric" pattern="[0-9]*"
                    style="letter-spacing: 0.5em; font-size: 1.2rem;" />
                <x-input-error :messages="$errors->get('pin')" class="mt-2" />
                <div class="form-text small text-muted mt-2">
                    Enter your staff PIN.
                </div>
            </div>

            <div class="d-grid mb-6">
                <x-primary-button class="btn btn-primary">
                    {{ __('Sign in with PIN') }}
                </x-primary-button>
            </div>

            <div class="text-gray-500 text-center fw-semibold fs-7">
                Your PIN is set by an administrator.
            </div>
        </form>

    </div>{{-- /pin-pane --}}
    </div>{{-- /tab-content --}}

    {{-- Minimal tab switcher. The guest layout doesn't load Bootstrap JS, so
         we swap active classes ourselves instead of pulling the whole
         bootstrap.bundle.js into the auth page. --}}
    <script>
        (function () {
            var triggers = document.querySelectorAll('[data-login-tab]');
            var panes = document.querySelectorAll('#loginTabsContent .tab-pane');
            triggers.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var target = btn.getAttribute('data-login-tab');
                    triggers.forEach(function (t) {
                        var on = t === btn;
                        t.classList.toggle('active', on);
                        t.setAttribute('aria-selected', on ? 'true' : 'false');
                    });
                    panes.forEach(function (p) {
                        var on = p.id === target;
                        p.classList.toggle('show', on);
                        p.classList.toggle('active', on);
                    });
                    // Move focus into the first input of the active pane.
                    var pane = document.getElementById(target);
                    var input = pane && pane.querySelector('input:not([type=hidden])');
                    if (input) setTimeout(function () { input.focus(); }, 50);
                });
            });
        })();
    </script>

    <?php /*
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
    */ ?>

</x-guest-layout>