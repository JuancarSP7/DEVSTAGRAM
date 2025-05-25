@extends('layouts.app')

@section('titulo')
    {{ __('login.title') }}
@endsection

@section('contenido') 
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/login.jpg') }}" alt="Imagen login de usuario" class="rounded-lg shadow-xl">
        </div>

        {{-- Contenedor principal con background claro/oscuro --}}
        <div class="md:w-4/12 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 p-6 rounded-lg shadow-xl">
            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                @if(session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ session('mensaje') }}
                    </p>
                @endif

                <div class="mb-5">
                    {{-- Label internacionalizada --}}
                    <label for="email" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        {{ __('login.email_label') }}
                    </label>
                    {{-- Input internacionalizado --}}
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        placeholder="{{ __('login.email_placeholder') }}" 
                        class="border p-3 w-full rounded-lg 
                               @error('email') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100" 
                        value="{{ old('email') }}" 
                    />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    {{-- Label internacionalizada --}}
                    <label for="password" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        {{ __('login.password_label') }}
                    </label>
                    {{-- Input internacionalizado --}}
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="{{ __('login.password_placeholder') }}" 
                        class="border p-3 w-full rounded-lg 
                               @error('password') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100" 
                    />
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    {{-- Checkbox estilizado e internacionalizado --}}
                    <input type="checkbox" name="remember" class="accent-sky-600" />
                    <label for="recordar" class="text-gray-500 dark:text-gray-300 text-sm">
                        {{ __('login.remember_me') }}
                    </label>
                </div>

                {{-- Botón de envío internacionalizado --}}
                <input 
                    type="submit" 
                    value="{{ __('login.login_button') }}" 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" 
                />
            </form>

            {{-- Links alternativos (opcional) --}}
            <div class="mt-6 text-center">
                <a href="#" class="text-sky-600 hover:underline text-sm">
                    {{ __('login.forgot_password') }}
                </a>
                <br>
                <span class="text-gray-500 dark:text-gray-300 text-sm">
                    {{ __('login.no_account') }}
                </span>
                <a href="{{ route('register') }}" class="ml-1 text-sky-600 hover:underline text-sm font-bold">
                    {{ __('login.signup') }}
                </a>
            </div>
        </div>
    </div>
@endsection
