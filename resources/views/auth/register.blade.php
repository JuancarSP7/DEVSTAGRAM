@extends('layouts.app')

@section('titulo')
    {{ __('register.title') }}
@endsection

@section('contenido') 
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/registrar.jpg') }}" alt="{{ __('register.image_alt') }}" class="rounded-lg shadow-xl">
        </div>

        {{-- Contenedor principal con soporte para modo claro/oscuro --}}
        <div class="md:w-4/12 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 p-6 rounded-lg shadow-xl">
            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf   {{-- Token CSRF para seguridad --}}

                <div class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        {{ __('register.name_label') }}
                    </label>
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        placeholder="{{ __('register.name_placeholder') }}" 
                        class="border p-3 w-full rounded-lg 
                               @error('name') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100" 
                        value="{{ old('name') }}" 
                    />
                    @error('name')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        {{ __('register.username_label') }}
                    </label>
                    <input 
                        id="username" 
                        name="username" 
                        type="text" 
                        placeholder="{{ __('register.username_placeholder') }}" 
                        class="border p-3 w-full rounded-lg 
                               @error('username') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100" 
                        value="{{ old('username') }}" 
                    />
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        {{ __('register.email_label') }}
                    </label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        placeholder="{{ __('register.email_placeholder') }}" 
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
                    <label for="password" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        {{ __('register.password_label') }}
                    </label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="{{ __('register.password_placeholder') }}" 
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
                    <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        {{ __('register.password_confirmation_label') }}
                    </label>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        placeholder="{{ __('register.password_confirmation_placeholder') }}" 
                        class="border p-3 w-full rounded-lg 
                               dark:bg-gray-700 dark:text-gray-100" 
                    />
                </div>

                {{-- Botón de envío --}}
                <input 
                    type="submit" 
                    value="{{ __('register.button') }}" 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" 
                />
            </form>
        </div>
    </div>
@endsection
