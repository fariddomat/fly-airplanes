<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * التعامل مع طلب التسجيل الوارد.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));
        $user->addRole('user');

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>
    <h2>التسجيل ✈️</h2>
    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('الاسم')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" dir="rtl" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 error" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" dir="ltr" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 error" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('كلمة المرور')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" dir="ltr" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 error" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('تأكيد كلمة المرور')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" dir="ltr" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 error" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between mt-4">
            <a class="underline" href="{{ route('login') }}" wire:navigate>
                {{ __('هل لديك حساب بالفعل؟') }}
            </a>

            <x-primary-button>
                {{ __('التسجيل') }}
            </x-primary-button>
        </div>
    </form>
</div>
