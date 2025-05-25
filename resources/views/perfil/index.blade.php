@extends('layouts.app')

@section('titulo')
    {{-- Título traducido y personalizado con el nombre de usuario --}}
    @lang('index.editar_perfil', ['username' => auth()->user()->username])
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        {{-- Contenedor del formulario con modo claro/oscuro --}}
        <div class="md:w-1/2 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 shadow p-6">
            <form method="POST" action="{{ route('perfil.store') }}" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @csrf

                {{-- Campo USERNAME --}}
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        @lang('index.username')
                    </label>
                    <input 
                        id="username" 
                        name="username" 
                        type="text" 
                        placeholder="@lang('index.placeholder_username')" 
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

                {{-- Campo IMAGEN con input personalizado y traducible --}}
                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        @lang('index.imagen')
                    </label>
                    <div x-data="{ fileName: '@lang('index.ninguno')' }">
                        <label for="imagen"
                            class="flex items-center cursor-pointer border p-3 w-full rounded-lg dark:bg-gray-700 dark:text-gray-100 bg-white shadow hover:bg-sky-50 dark:hover:bg-gray-600 transition">
                            {{-- Icono de archivo --}}
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 16V8a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            </svg>
                            {{-- Nombre del archivo seleccionado o texto traducido si no hay archivo --}}
                            <span x-text="fileName" class="flex-1 truncate"></span>
                            {{-- Botón traducido --}}
                            <span class="ml-auto bg-sky-600 text-white px-4 py-1 rounded-md font-semibold text-sm">
                                @lang('index.seleccionar')
                            </span>
                        </label>
                        {{-- Input file oculto, captura el nombre del archivo seleccionado y lo muestra --}}
                        <input 
                            id="imagen"
                            name="imagen"
                            type="file"
                            accept=".jpg, .jpeg, .png"
                            class="hidden"
                            @change="fileName = $event.target.files.length ? $event.target.files[0].name : '@lang('index.ninguno')'"
                        />
                    </div>
                </div>

                {{-- Botón de envío --}}
                <input 
                    type="submit" 
                    value="@lang('index.guardar')" 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" 
                />
            </form>
        </div>
    </div>
@endsection
