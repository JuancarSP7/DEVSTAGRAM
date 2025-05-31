@extends('layouts.app')

@section('titulo')
    Establece una nueva contraseña
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 shadow p-6 rounded-lg mt-10">

            <h2 class="text-2xl font-bold mb-6 text-center text-sky-700 dark:text-sky-400">
                Nueva contraseña
            </h2>

            {{-- Mensaje de error general --}}
            @if (session('status'))
                <div class="bg-green-500 text-white text-center py-2 rounded mb-4 font-semibold">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                {{-- Campo oculto: token de seguridad --}}
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email del usuario --}}
                <div class="mb-5">
                    <label for="email" class="block mb-2 uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Correo electrónico
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="border p-3 w-full rounded-lg
                               @error('email') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100"
                        value="{{ old('email', $email ?? '') }}"
                        required
                        autofocus
                    />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Nueva contraseña --}}
                <div class="mb-5">
                    <label for="password" class="block mb-2 uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Nueva contraseña
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="border p-3 w-full rounded-lg
                               @error('password') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100"
                        required
                        autocomplete="new-password"
                        placeholder="Tu nueva contraseña"
                    />
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Confirmar nueva contraseña --}}
                <div class="mb-5">
                    <label for="password_confirmation" class="block mb-2 uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Confirmar contraseña
                    </label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="border p-3 w-full rounded-lg
                               dark:bg-gray-700 dark:text-gray-100"
                        required
                        autocomplete="new-password"
                        placeholder="Confirma tu contraseña"
                    />
                </div>

                <input
                    type="submit"
                    value="Restablecer contraseña"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
        </div>
    </div>
@endsection
