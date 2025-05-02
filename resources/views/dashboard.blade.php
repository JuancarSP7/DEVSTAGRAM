@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')

<div class="flex justify-center">
    {{-- Contenedor principal relativo (clave para posicionar el modal respecto a este bloque) --}}
    <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row relative">

        {{-- Imagen del perfil --}}
        <div class="w-8/12 lg:w-6/12 px-5">
            <img src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}"
                 alt="imagen usuario" />
        </div>

        {{-- Info del usuario y botones --}}
        <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col md:justify-center items-center md:items-start py-10">

            {{-- Nombre y botón editar si soy yo --}}
            <div class="flex items-center gap-2">
                <p class="text-gray-700 text-2xl">{{ $user->username }}</p>
                @auth
                    @if ($user->id === auth()->user()->id)
                        <a href="{{ route('perfil.index')}}" class="text-gray-500 hover:text-gray-600 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                            </svg>
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Seguidores (solo el texto es azul clicable) --}}
            <p class="text-sm font-bold mt-5 cursor-pointer" onclick="abrirModal('seguidores')">
                {{ $user->followers->count() }}
                <span class="text-blue-600 font-normal hover:underline">@choice('Seguidor|Seguidores', $user->followers->count())</span>
            </p>

            {{-- Siguiendo --}}
            <p class="text-sm font-bold cursor-pointer" onclick="abrirModal('seguidos')">
                {{ $user->followings->count() }}
                <span class="text-blue-600 font-normal hover:underline">Siguiendo</span>
            </p>

            {{-- Total de publicaciones --}}
            <p class="text-gray-800 text-sm font-bold">
                {{ $user->posts->count() }}
                <span class="font-normal">Posts</span>
            </p>

            {{-- Botón de seguir o dejar de seguir --}}
            @auth
                @if ($user->id !== auth()->user()->id)
                    @if (!$user->siguiendo(auth()->user()))
                        <form action="{{ route('users.follow', $user)}}" method="POST">
                            @csrf
                            <input type="submit" value="Seguir"
                                class="bg-blue-600 text-white rounded-lg px-3 py-1 cursor-pointer hover:bg-blue-700 font-bold uppercase text-xs">
                        </form>
                    @else
                        <form action="{{ route('users.unfollow', $user)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Dejar de Seguir"
                                class="bg-red-600 text-white rounded-lg px-3 py-1 cursor-pointer hover:bg-blue-700 font-bold uppercase text-xs">
                        </form>
                    @endif
                @endif
            @endauth

            {{-- Modal de seguidores/seguidos con animación de entrada desde la derecha --}}
            <div id="modalUsuarios"
                class="absolute top-0 right-[-12rem] z-50 bg-white rounded-xl shadow-xl w-96 max-h-[80vh] overflow-y-auto p-4 hidden 
                       transition-all duration-300 ease-out transform translate-x-10 opacity-0">
                <h2 id="modalTitulo" class="text-xl font-bold mb-4"></h2>
                <ul id="modalLista" class="space-y-2"></ul>
                <button onclick="cerrarModal()" class="mt-4 w-full text-center text-red-500 font-semibold">Cerrar</button>
            </div>

        </div>
    </div>
</div>

{{-- Sección de publicaciones del usuario --}}
<section class="container mx-auto mt-10">
    <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
    <x-listar-post :posts="$posts" />
</section>

{{-- Script para cargar el contenido y mostrar el modal con animación --}}
<script>
    function abrirModal(tipo) {
        const username = @json($user->username);
        const url = `/${username}/${tipo}`;
        const titulo = tipo === 'seguidores' ? 'Seguidores' : 'Siguiendo';

        fetch(url)
            .then(res => res.json())
            .then(data => {
                // Asignar título y vaciar lista anterior
                document.getElementById('modalTitulo').innerText = titulo;
                const lista = document.getElementById('modalLista');
                lista.innerHTML = '';

                if (data.length === 0) {
                    lista.innerHTML = '<li class="text-gray-500 text-sm">No hay usuarios</li>';
                }

                data.forEach(usuario => {
                    const imagen = usuario.imagen ? `/perfiles/${usuario.imagen}` : '/img/usuario.svg';
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <a href="/${usuario.username}" class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded transition">
                            <img src="${imagen}" class="w-8 h-8 rounded-full object-cover">
                            <span class="text-sm font-medium text-gray-800">${usuario.username}</span>
                        </a>
                    `;
                    lista.appendChild(li);
                });

                const modal = document.getElementById('modalUsuarios');
                modal.classList.remove('hidden');

                // Fuerza un reflujo (necesario para que la animación funcione)
                void modal.offsetWidth;

                // Elimina las clases de entrada para animar aparición
                modal.classList.remove('translate-x-10', 'opacity-0');
            });
    }

    function cerrarModal() {
        const modal = document.getElementById('modalUsuarios');

        // Añade clases para la animación de salida
        modal.classList.add('translate-x-10', 'opacity-0');

        // Espera la duración antes de ocultarlo
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // coincide con Tailwind: duration-300
    }
</script>

@endsection
