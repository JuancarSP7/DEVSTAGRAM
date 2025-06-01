@extends('layouts.app')

@section('titulo')
    {{-- Título traducible --}}
    @lang('reset.titulo')
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 shadow p-6 rounded-lg mt-10">

            {{-- Encabezado principal traducido --}}
            <h2 class="text-2xl font-bold mb-6 text-center text-sky-700 dark:text-sky-400">
                @lang('reset.nueva_contrasena')
            </h2>

            {{-- Mensaje de éxito (opcionalmente traducible) --}}
            @if (session('status'))
                <div class="bg-green-500 text-white text-center py-2 rounded mb-4 font-semibold">
                    {{-- Si quieres traducir el mensaje, pásalo así desde el controlador --}}
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                {{-- Campo oculto para el token --}}
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- EMAIL --}}
                <div class="mb-5">
                    <label for="email" class="block mb-2 uppercase text-gray-500 dark:text-gray-300 font-bold">
                        @lang('reset.email')
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="border p-3 w-full rounded-lg
                               @error('email') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100"
                        value="{{ old('email', $email ?? '') }}"
                        autocomplete="email"
                        autofocus
                        placeholder="@lang('reset.placeholder_email')"
                    />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- NUEVA CONTRASEÑA --}}
                <div class="mb-5">
                    <label for="password" class="block mb-2 uppercase text-gray-500 dark:text-gray-300 font-bold">
                        @lang('reset.password')
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="border p-3 w-full rounded-lg
                               @error('password') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100"
                        autocomplete="new-password"
                        placeholder="@lang('reset.placeholder_password')"
                    />
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- CONFIRMAR CONTRASEÑA --}}
                <div class="mb-5">
                    <label for="password_confirmation" class="block mb-2 uppercase text-gray-500 dark:text-gray-300 font-bold">
                        @lang('reset.confirmar_password')
                    </label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="border p-3 w-full rounded-lg
                               @error('password_confirmation') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100"
                        autocomplete="new-password"
                        placeholder="@lang('reset.placeholder_confirmar')"
                    />
                    @error('password_confirmation')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- BOTÓN SUBMIT --}}
                <input
                    type="submit"
                    value="@lang('reset.restablecer')"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
        </div>
    </div>
@endsection
