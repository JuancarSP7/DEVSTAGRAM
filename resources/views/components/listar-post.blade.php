@props(['posts', 'mostrarInfoAutor' => false])

<div>
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show', ['user' => $post->user->username, 'post' => $post->id]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}" />
                    </a>

                    @if ($mostrarInfoAutor)
                        <p class="text-gray-600 text-sm mt-2 text-center">
                            Publicado por:
                            <a href="{{ route('post.index', $post->user) }}" class="text-blue-600 hover:underline">
                                {{ $post->user->username }}
                            </a>
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="my-10">
            {{ $posts->links() }}
        </div>
    @else
        <p class="text-gray-600 uppercase text-sm text-center font-bold">
            No hay publicaciones, sigue a tu DevStagramer favorito para poder ver sus posts
        </p>
    @endif
</div>
