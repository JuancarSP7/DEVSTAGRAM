@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }} {{-- Establece el título de la página con el título del post --}}
@endsection

@section('contenido')
<div class="container mx-auto md:flex">
    {{-- Columna izquierda: imagen y detalles del post --}}
    <div class="md:w-1/2">
        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">

        {{-- Sección de likes --}}
        <div class="p-3 flex items-center gap-4">
            @auth
                {{-- Componente Livewire para gestionar likes en tiempo real --}}
                <livewire:like-post :post="$post" />
            @endauth
        </div>

        {{-- Información del autor y fecha del post --}}
        <div>
            <p class="font-bold">{{ $post->user->username }}</p>
            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
            <p class="mt-5">{{ $post->descripcion }}</p>
        </div>

        {{-- Botón para eliminar el post si es del usuario autenticado --}}
        @auth
            @if ($post->user_id === auth()->user()->id)
                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                    @method('DELETE') {{-- Método DELETE para eliminar el post --}}
                    @csrf
                    <input type="submit" value="Eliminar Publicación"
                        class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer" />
                </form>
            @endif
        @endauth
    </div>

    {{-- Columna derecha: formulario y listado de comentarios --}}
    <div class="md:w-1/2 p-5">
        <div class="shadow bg-white p-5 mb-5">

            {{-- Formulario para agregar nuevo comentario --}}
            @auth
                <p class="text-xl font-bold text-center mb-4">Agrega un Nuevo Comentario</p>

                {{-- Mensaje de confirmación al comentar --}}
                @if (session('mensaje'))
                    <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                        {{ session('mensaje') }}
                    </div>
                @endif

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

            {{-- Listado de comentarios del post --}}
            <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                @if ($post->comentarios->count())
                    @foreach ($post->comentarios as $comentario)
                        <div class="p-5 border-gray-300 border-b">
                            {{-- Nombre del usuario que comentó --}}
                            <a href="{{ route('post.index', $comentario->user) }}" class="font-bold">
                                {{ $comentario->user->username }}
                            </a>

                            {{-- Detectar URLs en los comentarios y convertirlas en enlaces clickables a través de expresiones regulares --}}
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

                            {{-- Fecha del comentario --}}
                            <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>

                            {{-- Botón de eliminar comentario si el autor es el usuario autenticado --}}
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
                @else
                    <p class="p-10 text-center">No Hay Comentarios Aún</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
