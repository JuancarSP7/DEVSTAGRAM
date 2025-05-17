@extends('layouts.app')

@section('titulo')
    Regístrate en DevStagram
@endsection

@section('contenido') 
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/registrar.jpg') }}" alt="Imagen de registro de usuario" class="rounded-lg shadow-xl">
        </div>

        {{-- Contenedor principal con soporte para modo claro/oscuro --}}
        <div class="md:w-4/12 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 p-6 rounded-lg shadow-xl">
            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf   {{-- Token CSRF para seguridad --}}

                <div class="mb-5">
                    {{-- Label adaptado a modo oscuro --}}
                    <label for="name" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Nombre
                    </label>
                    {{-- Input con fondo y texto para modo oscuro; borde rojo en errores --}}
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        placeholder="Tu nombre" 
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
                    {{-- Label adaptado a modo oscuro --}}
                    <label for="username" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Username
                    </label>
                    {{-- Input con fondo y texto para modo oscuro; borde rojo en errores --}}
                    <input 
                        id="username" 
                        name="username" 
                        type="text" 
                        placeholder="Tu Nombre de Usuario" 
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
                    {{-- Label adaptado a modo oscuro --}}
                    <label for="email" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Email
                    </label>
                    {{-- Input con fondo y texto para modo oscuro; borde rojo en errores --}}
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        placeholder="Tu Email de Registro" 
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
                    {{-- Label adaptado a modo oscuro --}}
                    <label for="password" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Password
                    </label>
                    {{-- Input con fondo y texto para modo oscuro; borde rojo en errores --}}
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="Password de Registro" 
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
                    {{-- Label adaptado a modo oscuro --}}
                    <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Repetir Password
                    </label>
                    {{-- Input con fondo y texto para modo oscuro --}}
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        placeholder="Repite tu Password" 
                        class="border p-3 w-full rounded-lg 
                               dark:bg-gray-700 dark:text-gray-100" 
                    />
                </div>

                {{-- Botón de envío: ya tiene buen contraste en modo oscuro --}}
                <input 
                    type="submit" 
                    value="Crear Cuenta" 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" 
                />
            </form>
        </div>
    </div>
@endsection
