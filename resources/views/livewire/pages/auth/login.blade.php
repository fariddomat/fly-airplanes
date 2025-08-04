<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * التعامل مع طلب تسجيل الدخول الوارد.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div >
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 error" :status="session('status')" />

    <h2>تسجيل الدخول ✈️</h2>
    <form wire:submit="login" class="space-y-6">
        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" dir="ltr" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 error" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('كلمة المرور')" />
            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" dir="ltr" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 error" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="checkbox-label">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember" style="width: 10px;">
                <span>{{ __('تذكرني') }}</span>
            </label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('نسيت كلمة المرور؟') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('تسجيل الدخول') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        @if (Route::has('register'))
            <p class="note mt-4">
                {{ __('ليس لديك حساب؟') }}
                <a href="{{ route('register') }}" wire:navigate>{{ __('سجّل الآن') }}</a>
            </p>
        @endif
    </form>
</div>
