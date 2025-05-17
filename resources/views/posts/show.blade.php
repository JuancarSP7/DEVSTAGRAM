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
        <div class="shadow bg-white dark:bg-gray-800 p-5 mb-5">
            @auth
                <p class="text-xl font-bold text-center mb-4 dark:text-gray-100">
                    Agrega un Nuevo Comentario
                </p>

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

                {{-- LISTADO DE COMENTARIOS DE ESTE POST --}}
                @if($post->comentarios->count())
                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-3 dark:text-gray-100">Comentarios</h3>
                        <ul>
                            @foreach ($post->comentarios()->latest()->get() as $comentario)
                                <li class="mb-3 border-b border-gray-200 dark:border-gray-600 pb-2">
                                    {{-- Usuario y fecha en una sola línea, sin margen inferior --}}
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-blue-700 dark:text-blue-400">{{ $comentario->user->username }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comentario->created_at->diffForHumans() }}</span>
                                    </div>
                                    {{-- Comentario pegado justo debajo, sin márgenes y con texto ajustado --}}
                                    <div class="comentario-html break-words whitespace-pre-line leading-tight p-0 m-0">
                                        {!! formatear_urls($comentario->comentario) !!}
                                    </div>
                                    {{-- Botón eliminar comentario solo para el autor --}}
                                    @if(auth()->id() === $comentario->user_id)
                                        <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" class="mt-1">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded">
                                                Eliminar Comentario
                                            </button>
                                        </form>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Sé el primero en comentar.</p>
                @endif

                <hr class="border-gray-200 dark:border-gray-600 my-6">

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

                <hr class="border-gray-200 dark:border-gray-600 my-6">

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
