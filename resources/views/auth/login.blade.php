@extends('layouts.app')

@section('titulo')
    Inicia sesion en DevStagram
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
                    {{-- Label con texto adaptado a modo oscuro --}}
                    <label for="email" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Email
                    </label>
                    {{-- Input con fondo y texto adaptados a modo oscuro; mantiene borde rojo en errores --}}
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
                    {{-- Label con texto adaptado a modo oscuro --}}
                    <label for="password" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Password
                    </label>
                    {{-- Input con fondo y texto adaptados a modo oscuro; mantiene borde rojo en errores --}}
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
                    {{-- Checkbox estilizado para modo oscuro --}}
                    <input type="checkbox" name="remember" class="accent-sky-600" />
                    <label for="recordar" class="text-gray-500 dark:text-gray-300 text-sm">
                        Mantener mi sesión abierta
                    </label>
                </div>

                {{-- Botón de envío (queda igual pues ya contraste bien en oscuro) --}}
                <input 
                    type="submit" 
                    value="Iniciar sesión" 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" 
                />
            </form>
        </div>
    </div>
@endsection
