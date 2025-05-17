@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
<div class="container mx-auto md:flex items-start">
    {{-- Columna izquierda: imagen y post --}}
    <div class="md:w-1/2 flex-shrink-0">
        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
        <div class="p-3 flex items-center gap-4">
            @auth
                <livewire:like-post :post="$post" />
            @endauth
        </div>
        <div>
            <p class="font-bold dark:text-gray-100">{{ $post->user->username }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
            <p class="mt-5 dark:text-gray-200">{{ $post->descripcion }}</p>
        </div>
        @auth
            @if ($post->user_id === auth()->user()->id)
                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                    @csrf
                    @method('DELETE')
                    <input 
                        type="submit" 
                        value="Eliminar Publicación"
                        class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer" 
                    />
                </form>
            @endif
        @endauth
    </div>

    {{-- Columna derecha: comentarios, compartir y códigos compartidos --}}
    <div class="md:w-1/2 px-5">
        {{-- Contenedor unificado para comentario + compartir código + lista de códigos --}}
        <div class="shadow bg-white dark:bg-gray-800 p-5 mb-5">
            @auth
                {{-- Título Nuevo Comentario --}}
                <p class="text-xl font-bold text-center mb-4 dark:text-gray-100">
                    Agrega un Nuevo Comentario
                </p>

                {{-- Mensaje de éxito --}}
                @if (session('mensaje'))
                    <div id="mensaje-temporal" class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                        {{ session('mensaje') }}
                    </div>
                @endif
                <script>
                    setTimeout(() => {
                        const m = document.getElementById('mensaje-temporal');
                        if (m) m.style.display = 'none';
                    }, 2000);
                </script>

                {{-- Formulario Comentario --}}
                <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="comentario" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                            Añade un Comentario
                        </label>
                        <textarea
                            id="comentario"
                            name="comentario"
                            placeholder="Agrega un Comentario"
                            class="border p-3 w-full rounded-lg 
                                   @error('comentario') border-red-500 dark:border-red-500 @enderror
                                   dark:bg-gray-700 dark:text-gray-100"
                        ></textarea>
                        @error('comentario')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <input 
                        type="submit"
                        value="Comentar"
                        class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                    />
                </form>

                {{-- Línea separadora antes de Compartir Código --}}
                <hr class="border-gray-200 dark:border-gray-600 my-6">

                {{-- Título Compartir Código --}}
                <p class="text-xl font-bold text-center mb-4 dark:text-gray-100">
                    Comparte tu Código
                </p>

                {{-- Formulario Compartir Código --}}
                <form action="{{ route('codigos.store', $post) }}" method="POST">
                    @csrf
                    <label for="lenguaje" class="block uppercase text-gray-500 dark:text-gray-300 font-bold mb-2">
                        Indica tu Lenguaje
                    </label>
                    <select
                        name="lenguaje"
                        id="lenguaje"
                        class="mb-4 w-full border rounded p-2
                               dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
                    >
                        <option value="Java">Java</option>
                        <option value="Python">Python</option>
                        <option value="Kotlin">Kotlin</option>
                        <option value="HTML">HTML</option>
                        <option value="JavaScript">JavaScript</option>
                        <option value="PHP">PHP</option>
                        <option value="C">C</option>
                        <option value="Cobol">Cobol</option>
                        <option value="Otros">Otros</option>
                    </select>
                    <label for="codigo" class="block uppercase text-gray-500 dark:text-gray-300 font-bold mb-2">
                        Código
                    </label>
                    <textarea
                        id="codigo"
                        name="codigo"
                        maxlength="1000"
                        rows="6"
                        class="w-full bg-black text-white font-mono text-xs p-3 rounded resize-none
                               @error('codigo') border-red-500 @enderror"
                        placeholder="Escribe tu código aquí..."
                    ></textarea>
                    @error('codigo')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                    <button
                        type="submit"
                        class="bg-sky-600 hover:bg-sky-700 mt-4 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                    >
                        Compartir Código
                    </button>
                </form>

                {{-- Línea separadora antes de la lista de códigos compartidos --}}
                <hr class="border-gray-200 dark:border-gray-600 my-6">

                {{-- Lista de Códigos Compartidos --}}
                <h3 class="text-xl font-bold text-center mb-4 dark:text-gray-100">
                    Códigos Compartidos
                </h3>
                @foreach ($post->codigos as $codigo)
                    <div class="bg-gray-100 dark:bg-gray-700 px-4 py-2 mb-2 text-sm flex justify-between items-center rounded dark:text-gray-100">
                        <span class="uppercase font-bold">Lenguaje: {{ $codigo->lenguaje }}</span>
                        <div class="flex gap-2 items-center">
                            <button
                                onclick="document.getElementById('codigo-{{ $codigo->id }}').classList.toggle('hidden')"
                                class="bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs px-3 py-1 rounded"
                            >
                                Ver Código
                            </button>
                            @if (auth()->check() && auth()->id() === $codigo->user_id)
                                <form method="POST" action="{{ route('codigos.destroy', $codigo) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold text-xs px-3 py-1 rounded"
                                    >
                                        Eliminar Código
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div
                        id="codigo-{{ $codigo->id }}"
                        class="hidden bg-black text-white font-mono text-xs p-4 rounded mb-4 overflow-x-auto whitespace-pre-wrap"
                    >
                        <pre><code>{{ $codigo->codigo }}</code></pre>
                    </div>
                @endforeach
            @endauth
        </div>
    </div>
</div>
@endsection
