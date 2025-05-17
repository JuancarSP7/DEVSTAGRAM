@extends('layouts.app')

@section('titulo')
    Crea una nueva Publicación
@endsection

@push('styles')
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('contenido')
    <div class="md:flex md:items-center">
        {{-- Zona de Dropzone: adaptamos bordes en modo oscuro --}}
        <div class="md:w-1/2 px-10">
            <form 
                action="{{ route('imagenes.store') }}" 
                method="POST" 
                enctype="multipart/form-data" 
                id="dropzone" 
                class="dropzone border-dashed border-2 border-gray-300 dark:border-gray-600 w-full h-96 rounded flex flex-col justify-center items-center dark:bg-gray-800"
            >
                @csrf
            </form>
        </div>
        
        {{-- Contenedor del formulario de publicación con modo claro/oscuro --}}
        <div class="md:w-1/2 p-10 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{ route('posts.store') }}" method="POST" novalidate>
                @csrf   {{-- Token CSRF para seguridad --}}

                <div class="mb-5">
                    {{-- Label adaptado a modo oscuro --}}
                    <label for="titulo" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Título
                    </label>
                    {{-- Input con fondo y texto para modo oscuro; bordes en errores --}}
                    <input 
                        id="titulo" 
                        name="titulo" 
                        type="text" 
                        placeholder="Título de la Publicación" 
                        class="border p-3 w-full rounded-lg 
                               @error('titulo') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100" 
                        value="{{ old('titulo') }}" 
                    />
                    @error('titulo')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    {{-- Label adaptado a modo oscuro --}}
                    <label for="descripcion" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        Descripción
                    </label>
                    {{-- Textarea con fondo y texto para modo oscuro; bordes en errores --}}
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        placeholder="Descripción de la Publicación" 
                        class="border p-3 w-full rounded-lg 
                               @error('descripcion') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100"
                    >{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <div class="mb-5">
                    <input name="imagen" type="hidden" value="{{ old('imagen') }}" />
                    @error('imagen')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Botón de envío mantiene buen contraste --}}
                <input 
                    type="submit" 
                    value="Crear Publicación" 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" 
                />
            </form>
        </div>  

    </div>
@endsection
