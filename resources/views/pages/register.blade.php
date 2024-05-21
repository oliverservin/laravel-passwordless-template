<?php

use App\Models\User;
use App\Notifications\CompleteRegister;
use Illuminate\Support\Facades\URL;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

middleware(['guest', 'throttle:5,1']);

name('register');

state([
    'email' => '',
    'loginLinkSent' => false,
]);

rules([
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
])->messages([
    'email.required' => 'El email es requerido.',
    'email.email' => 'El email debe ser válido.',
    'email.unique' => 'El email ya está en uso.',
    'email.max' => 'El email debe tener máximo 255 caracteres.',
    'email.lowercase' => 'El email debe estar en minsculas.',
    'email.string' => 'El email debe ser una cadena de texto.',
]);

$register = function () {
    $validated = $this->validate();

    $user = User::create($validated);

    $loginUrl = URL::temporarySignedRoute('complete-login', now()->addHours(24), ['user' => $user]);

    $user->notify(new CompleteRegister($loginUrl));

    $this->loginLinkSent = true;
};

?>

<x-layouts.app title="Registrarse">
    @volt
        <div class="flex min-h-screen items-start bg-zinc-50 p-3 sm:items-center sm:justify-center">
            <div
                class="w-full max-w-md rounded-lg bg-white shadow-[0px_0px_0px_1px_rgba(9,9,11,0.07),0px_2px_2px_0px_rgba(9,9,11,0.05)]"
            >
                @unless ($loginLinkSent)
                    <form wire:submit="register">
                        <div class="p-6">
                            <h1 class="text-2xl font-semibold tracking-tight">Registrarse</h1>
                        </div>
                        <div class="grid gap-4 p-6 pt-0">
                            <div class="space-y-2">
                                <label class="text-sm font-medium leading-none" for="email">Email</label>
                                <input
                                    wire:model="email"
                                    type="email"
                                    class="flex h-9 w-full rounded-md border border-zinc-950/10 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-zinc-500 focus-visible:outline-none focus-visible:ring-1 disabled:cursor-not-allowed disabled:opacity-50"
                                    placeholder="oliver@example.com"
                                />
                                @error('email')
                                    <p class="text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center p-6 pt-0">
                            <button
                                type="submit"
                                class="w-full rounded-lg bg-zinc-900 p-2.5 text-sm font-medium text-zinc-50 shadow-sm hover:bg-zinc-700"
                            >
                                Registrar
                            </button>
                        </div>
                        <div class="p-6 pt-0">
                            <p class="text-sm text-zinc-500">
                                ¿Ya tienes una cuenta?
                                <a href="/login" class="text-zinc-900">Inicia sesión</a>
                            </p>
                        </div>
                    </form>
                @else
                    <div>
                        <div class="p-6">
                            <h1 class="text-2xl font-semibold tracking-tight">¡Ahora revisa tu correo electrónico!</h1>
                        </div>
                        <div class="p-6 pt-0">
                            <p class="text-sm text-zinc-500">
                                Para completar el registro, haz clic en el enlace de confirmación en tu bandeja de
                                entrada. Si no llega en 3 minutos, revisa tu carpeta de spam.
                            </p>
                        </div>
                    </div>
                @endunless
            </div>
        </div>
    @endvolt
</x-layouts.app>
