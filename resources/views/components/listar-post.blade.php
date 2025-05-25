@props(['posts', 'mostrarInfoAutor' => false])

<div>
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show', ['user' => $post->user->username, 'post' => $post->id]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="@lang('listar_post.imagen_alt', ['titulo' => $post->titulo])" />
                    </a>

                    @if ($mostrarInfoAutor)
                        <p class="text-gray-600 text-sm mt-2 text-center">
                            @lang('listar_post.publicado_por')
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
            @lang('listar_post.no_publicaciones')
        </p>
    @endif
</div>
