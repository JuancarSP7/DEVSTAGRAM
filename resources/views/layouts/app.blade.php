<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @stack('styles')

        <title>DevStagram - @yield('titulo')</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        @livewireStyles
    </head>
    <body class="bg-gray-100">
        <header class="p-5 border-b bg-white shadow">
            <div class="container mx-auto flex flex-wrap justify-between items-center gap-4">

                <a href="{{ route('home')}}" class="text-3xl font-black">DevStagram</a>

                @auth
                    <form id="form-busqueda" class="relative w-full md:w-1/3 order-last md:order-none" autocomplete="off">
                        <input
                            type="text"
                            id="buscar"
                            name="buscar"
                            placeholder="Buscar DevStagramers..."
                            class="border pl-10 pr-4 py-2 w-full rounded-lg text-sm text-gray-700 placeholder-gray-600 placeholder:text-sm focus:border-2 focus:border-sky-600 focus:ring-2 focus:ring-sky-600 focus:outline-none"
                        />



                        <span class="absolute left-3 top-2.5 text-gray-600 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1 0 3 10.5a7.5 7.5 0 0 0 13.65 6.15z" />
                            </svg>
                        </span>
                        <ul id="resultados" class="absolute z-50 w-full bg-white shadow-md rounded-lg mt-1 hidden max-h-60 overflow-y-auto"></ul>
                    </form>

                    <nav class="flex gap-4 items-center order-last md:order-none">
                        <a class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer" href="{{ route('posts.create') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                            Crear
                        </a>

                        <a class="font-bold text-gray-600 text-sm" href="{{route('post.index', auth()->user()->username)}}">
                            Hola: <span class="font-normal"> {{ auth()->user()->username }}</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="font-bold uppercase text-gray-600 text-sm">Cerrar Sesión</button>
                        </form>
                    </nav>
                @endauth

                @guest
                    <nav class="flex gap-2 items-center">
                        <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}" class="font-bold uppercase text-gray-600 text-sm">Crear Cuenta</a>
                    </nav>
                @endguest

            </div>
        </header>

        <main class="container mx-auto mt-10">
            <h2 class="text-3xl text-center font-black mb-10">
                @yield('titulo')
            </h2>
            @yield('contenido')
        </main>

        <footer class="text-center p-5 text-gray-500 font-bold uppercase mt-10">
            DevStagram - Todos los derechos reservados {{ now()->year }}
        </footer>

        @livewireScripts

        {{-- Script de autocompletado global --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const input = document.querySelector('#buscar');
                const resultados = document.querySelector('#resultados');
                if (!input || !resultados) return;

                let indexSeleccionado = -1;

                async function buscarUsuarios(query) {
                    const response = await fetch(`/buscar-usuarios?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    });

                    const usuarios = await response.json();
                    resultados.innerHTML = '';

                    if (usuarios.length > 0) {
                        usuarios.forEach(user => {
                            const li = document.createElement('li');
                            li.classList = 'p-3 hover:bg-sky-100 cursor-pointer text-gray-700 flex items-center gap-3';
                            li.innerHTML = `
                                <a href="/${user.username}" class="flex items-center gap-3 w-full h-full">
                                    <img src="${user.imagen ? '/perfiles/' + user.imagen : '/img/usuario.svg'}"
                                        alt="avatar"
                                        class="w-8 h-8 rounded-full object-cover border border-gray-300" />
                                    <div>
                                        <span class="font-bold block">${user.username}</span>
                                    </div>
                                </a>
                            `;
                            resultados.appendChild(li);
                        });
                        resultados.classList.remove('hidden');
                    } else {
                        const li = document.createElement('li');
                        li.classList = 'p-3 text-center text-gray-500';
                        li.textContent = 'No se encontraron resultados.';
                        resultados.appendChild(li);
                        resultados.classList.remove('hidden');
                    }
                }

                input.addEventListener('input', async function () {
                    const query = this.value.trim();
                    indexSeleccionado = -1;

                    if (query.length < 1) {
                        resultados.classList.add('hidden');
                        resultados.innerHTML = '';
                        return;
                    }

                    await buscarUsuarios(query);
                });

                input.addEventListener('focus', async function () {
                    const query = this.value.trim();
                    if (query.length >= 1) {
                        await buscarUsuarios(query);
                    }
                });

                input.addEventListener('keydown', function (e) {
                    const items = resultados.querySelectorAll('li');
                    if (!items.length) return;

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        indexSeleccionado = (indexSeleccionado + 1) % items.length;
                        actualizarSeleccion(items);
                    }

                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        indexSeleccionado = (indexSeleccionado - 1 + items.length) % items.length;
                        actualizarSeleccion(items);
                    }

                    if (e.key === 'Enter' && indexSeleccionado >= 0) {
                        e.preventDefault();
                        const link = items[indexSeleccionado].querySelector('a');
                        if (link) {
                            window.location.href = link.href;
                        }
                    }
                });

                function actualizarSeleccion(items) {
                    items.forEach((item, index) => {
                        if (index === indexSeleccionado) {
                            item.classList.add('bg-sky-100');
                        } else {
                            item.classList.remove('bg-sky-100');
                        }
                    });
                }

                document.addEventListener('click', function (e) {
                    const form = document.querySelector('#form-busqueda');
                    if (!form.contains(e.target)) {
                        resultados.classList.add('hidden');
                        resultados.innerHTML = '';
                        input.value = '';
                    }
                });
            });
        </script>
    </body>
</html>
