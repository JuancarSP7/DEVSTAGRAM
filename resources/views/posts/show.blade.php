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
            <p class="font-bold">{{ $post->user->username }}</p>
            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
            <p class="mt-5">{{ $post->descripcion }}</p>
        </div>
        @auth
            @if ($post->user_id === auth()->user()->id)
                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Eliminar Publicación"
                        class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer" />
                </form>
            @endif
        @endauth
    </div>

    {{-- Columna derecha: comentarios y códigos --}}
    <div class="md:w-1/2 px-5">
        <div class="shadow bg-white p-5 mb-5">
            @auth
                <p class="text-xl font-bold text-center mb-4">Agrega un Nuevo Comentario</p>

                @if (session('mensaje'))
                    <div id="mensaje-temporal" class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                        {{ session('mensaje') }}
                    </div>
                @endif

                {{-- Script para ocultar mensaje después de 2 segundos --}}
                <script>
                    setTimeout(() => {
                        const mensaje = document.getElementById('mensaje-temporal');
                        if(mensaje) mensaje.style.display = 'none';
                    }, 2000);
                </script>

                {{-- Formulario Comentario --}}
                <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Añade un Comentario</label>
                        <textarea id="comentario" name="comentario" placeholder="Agrega un Comentario"
                            class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror"></textarea>
                        @error('comentario')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="submit" value="Comentar"
                        class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
                </form>
            @endauth

            {{-- Lista de comentarios --}}
            <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                @foreach ($post->comentarios as $comentario)
                    <div class="p-5 border-gray-300 border-b">
                        <a href="{{ route('post.index', $comentario->user) }}" class="font-bold">
                            {{ $comentario->user->username }}
                        </a>
                        <p class="mt-1">
                            {!! preg_replace_callback(
                                '/(https?:\/\/[\S]+|www\.[\S]+)/',
                                function ($matches) {
                                    $url = $matches[0];
                                    $href = str_starts_with($url, 'http') ? $url : "https://$url";
                                    return '<a href="' . $href . '" class="text-blue-600 hover:underline" target="_blank" rel="noopener noreferrer">' . $url . '</a>';
                                },
                                e($comentario->comentario)
                            ) !!}
                        </p>
                        <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                        @if (auth()->check() && auth()->id() === $comentario->user_id)
                            <form method="POST" action="{{ route('comentarios.destroy', $comentario) }}" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar Comentario"
                                    class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold cursor-pointer text-sm" />
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Formulario compartir código --}}
            @auth
                <div class="mt-10 border-t pt-6">
                    <p class="text-xl font-bold text-center mb-4">Comparte tu Código</p>
                    <form action="{{ route('codigos.store', $post) }}" method="POST">
                        @csrf
                        <label for="lenguaje" class="block uppercase text-gray-500 font-bold mb-2">Indica tu Lenguaje</label>
                        <select name="lenguaje" id="lenguaje" class="mb-4 w-full border rounded p-2">
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
                        <label for="codigo" class="block uppercase text-gray-500 font-bold mb-2">Código</label>
                        <textarea id="codigo" name="codigo" maxlength="1000" rows="6"
                            class="w-full bg-black text-white font-mono text-xs p-3 rounded resize-none @error('codigo') border-red-500 @enderror"
                            placeholder="Escribe tu código aquí..."></textarea>
                        @error('codigo')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                            class="bg-sky-600 hover:bg-sky-700 mt-4 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
                            Compartir Código
                        </button>
                    </form>
                </div>
            @endauth

            {{-- Códigos Compartidos --}}
            <div class="mt-10">
                <h3 class="text-xl font-bold text-center mb-4">Códigos Compartidos</h3>
                @foreach ($post->codigos as $codigo)
                    <div class="bg-gray-100 px-4 py-2 mb-2 text-sm flex justify-between items-center rounded">
                        <span class="uppercase font-bold">Lenguaje: {{ $codigo->lenguaje }}</span>
                        <div class="flex gap-2 items-center">
                            <button onclick="document.getElementById('codigo-{{ $codigo->id }}').classList.toggle('hidden')"
                                class="bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs px-3 py-1 rounded">
                                Ver Código
                            </button>
                            @if (auth()->check() && auth()->id() === $codigo->user_id)
                                <form method="POST" action="{{ route('codigos.destroy', $codigo) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold text-xs px-3 py-1 rounded">
                                        Eliminar Código
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div id="codigo-{{ $codigo->id }}" class="hidden bg-black text-white font-mono text-xs p-4 rounded mb-4 overflow-x-auto whitespace-pre-wrap">
                        <pre><code>{{ $codigo->codigo }}</code></pre>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection