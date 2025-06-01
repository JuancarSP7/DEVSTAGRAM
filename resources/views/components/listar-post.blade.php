@props(['posts', 'mostrarInfoAutor' => false])

{{-- 
    El siguiente CSS oculta el texto de resumen de la paginación ("Showing 1 to 21 of 24 results")
    generado por Laravel. Solo afecta ese texto, dejando los controles de paginación visibles.
--}}
<style>
    .text-sm.text-gray-700.leading-5 {
        display: none !important;
    }
</style>

<div>
    @if ($posts->count())
        {{-- 
            GRID de 7 columnas:
            - Se adapta según el tamaño de pantalla (responsive).
            - Evita espacios en blanco en la cuadrícula.
            - Centra los posts horizontalmente.
        --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-7 gap-8 justify-center">
            @foreach ($posts as $post)
                <div class="bg-white rounded-lg shadow p-2 flex flex-col items-center">
                    {{-- Imagen del post --}}
                    <a href="{{ route('posts.show', ['user' => $post->user->username, 'post' => $post->id]) }}">
                        <img 
                            src="{{ asset('uploads') . '/' . $post->imagen }}" 
                            alt="@lang('listar_post.imagen_alt', ['titulo' => $post->titulo])"
                            class="rounded-lg w-full object-cover"
                            style="aspect-ratio: 1/1; min-width:140px; max-width:180px; min-height:140px; max-height:180px;"
                        />
                    </a>
                    {{-- Info del autor (opcional, si se pasa mostrarInfoAutor=true) --}}
                    @if ($mostrarInfoAutor)
                        <p class="text-gray-600 text-xs mt-2 text-center">
                            @lang('listar_post.publicado_por')
                            <a href="{{ route('post.index', $post->user) }}" class="text-blue-600 hover:underline">
                                {{ $post->user->username }}
                            </a>
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Paginación centrada --}}
        <div class="my-10 flex justify-center">
            {{ $posts->links() }}
        </div>
    @else
        {{-- Mensaje si no hay publicaciones --}}
        <p class="text-gray-600 uppercase text-sm text-center font-bold">
            @lang('listar_post.no_publicaciones')
        </p>
    @endif
</div>
