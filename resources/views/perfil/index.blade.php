@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{ auth()->user()->username }}
@endsection

@section('contenido')

    <div class="md:flex md:justify-center">
        {{-- Contenedor del formulario con soporte para modo claro/oscuro --}}
        <div class="md:w-1/2 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 shadow p-6">
            <form method="POST" action="{{ route('perfil.store') }}" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @csrf

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
                        placeholder="Tu nombre de Usuario" 
                        class="border p-3 w-full rounded-lg 
                               @error('username') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100" 
                        value="{{ auth()->user()->username }}" 
                    />
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    {{-- Label adaptado a modo oscuro --}}
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Imagen Perfil
                    </label>
                    {{-- File input con fondo y texto para modo oscuro --}}
                    <input 
                        id="imagen" 
                        name="imagen" 
                        type="file" 
                        accept=".jpg, .jpeg, .png"
                        class="border p-3 w-full rounded-lg dark:bg-gray-700 dark:text-gray-100"
                    />
                </div>

                {{-- Botón de envío mantiene buen contraste en oscuro --}}
                <input 
                    type="submit" 
                    value="Guardar Cambios" 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" 
                />
            </form>
        </div>
    </div>

@endsection
