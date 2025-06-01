@extends('layouts.app')

@section('titulo')
    {{ __('auth.recover_password_page_title') }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 shadow p-6 rounded-lg mt-10">

            {{-- Título principal de la página --}}
            <h2 class="text-2xl font-bold mb-6 text-center text-sky-700 dark:text-sky-400">
                {{ __('auth.recover_password_title') }}
            </h2>

            {{-- Toast de éxito si se ha enviado el correo --}}
            @if (session('status'))
                <div class="bg-green-500 text-white text-center py-2 rounded mb-4 font-semibold">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Campo para el correo electrónico --}}
                <div class="mb-5">
                    <label for="email" class="block mb-2 uppercase text-gray-500 dark:text-gray-300 font-bold">
                        {{ __('auth.email') }}
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="{{ __('auth.email_placeholder') }}"
                        class="border p-3 w-full rounded-lg
                               @error('email') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Botón para enviar el formulario --}}
                <input
                    type="submit"
                    value="{{ __('auth.send_reset_link') }}"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
        </div>
    </div>
@endsection
