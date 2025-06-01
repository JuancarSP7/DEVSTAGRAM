<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="theme()"                              {{-- Alpine.js para modo claro/oscuro --}}
      x-init="init()"                               {{-- Inicializa tema al cargar --}}
      :class="{ 'dark': isDark }">                  {{-- Aplica clase dark automáticamente --}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>[x-cloak] { display: none !important; }</style> {{-- Oculta elementos con x-cloak hasta Alpine esté listo --}}

    @stack('styles')                               {{-- Estilos individuales de página --}}

    <title>DevStagram - @yield('titulo')</title>

    {{-- Alpine.js CDN para manejar tema claro/oscuro --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Configuración del modo claro/oscuro
        function theme() {
            return {
                isDark: localStorage.getItem('isDark') === 'true'
                         || window.matchMedia('(prefers-color-scheme: dark)').matches,
                init()     { this.applyTheme(); },
                toggle()   {
                    this.isDark = !this.isDark;
                    localStorage.setItem('isDark', this.isDark);
                    this.applyTheme();
                },
                applyTheme() {
                    document.documentElement.classList.toggle('dark', this.isDark);
                }
            }
        }
    </script>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles
</head>
<body class="bg-gray-100 dark:bg-gray-900">

<header class="p-5 border-b bg-white dark:bg-gray-800 shadow">
    <div class="container mx-auto flex items-center gap-4">

        {{-- Logo / Home --}}
        <a href="{{ route('home') }}" class="text-3xl font-black text-gray-800 dark:text-gray-100">
            @lang('app.logo')
        </a>

        {{-- Búsqueda de usuarios (solo desktop), centrada --}}
        @auth
        <form id="form-busqueda" class="relative hidden md:block w-1/3 mx-auto" autocomplete="off">
            <input
                type="text" id="buscar" name="buscar" placeholder="@lang('app.buscar_placeholder')"
                class="border pl-10 pr-4 py-2 w-full rounded-lg text-sm text-gray-700 placeholder-gray-600 focus:border-2 focus:border-sky-600 focus:ring-2 focus:ring-sky-600 focus:outline-none"
            />
            <span class="absolute left-3 top-2.5 text-gray-600 text-sm">
                {{-- Icono lupa --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1 0 3 10.5a7.5 7.5 0 0 0 13.65 6.15z" />
                </svg>
            </span>
            <ul id="resultados" class="absolute z-50 w-full bg-white dark:bg-gray-700 shadow-md rounded-lg mt-1 hidden max-h-60 overflow-y-auto"></ul>
        </form>
        @endauth

        {{-- Contenedor derecho: navegación, modo claro/oscuro y selector de idioma --}}
        <div class="flex items-center ml-auto gap-1">

            {{-- Navegación autenticado/invitado --}}
            @auth
            <nav class="flex items-center gap-4">
                <a href="{{ route('posts.create') }}" class="flex items-center gap-2 bg-white dark:bg-gray-800 border p-2 text-gray-600 dark:text-gray-200 rounded text-sm uppercase font-bold hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    {{-- Icono crear --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                    @lang('app.crear')
                </a>
                <a href="{{ route('post.index', auth()->user()->username) }}" class="font-bold text-gray-600 dark:text-gray-200 text-sm">
                    @lang('app.hola'): <span class="font-normal">{{ auth()->user()->username }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-bold uppercase text-gray-600 dark:text-gray-200 text-sm">@lang('app.cerrar_sesion')</button>
                </form>
            </nav>
            @else
            <nav class="flex items-center gap-2">
                <a href="{{ route('login') }}" class="font-bold uppercase text-gray-600 dark:text-gray-200 text-sm">@lang('app.login')</a>
                <a href="{{ route('register') }}" class="font-bold uppercase text-gray-600 dark:text-gray-200 text-sm">@lang('app.crear_cuenta')</a>
            </nav>
            @endauth

            {{-- Botón para alternar modo claro/oscuro --}}
            <button @click="toggle()"
                    class="p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-sky-600 text-gray-800 dark:text-gray-100"
                    aria-label="@lang('app.alternar_modo')">
                {{-- Icono luna (modo claro) --}}
                <svg x-show="!isDark" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
                </svg>
                {{-- Icono sol (modo oscuro) --}}
                <svg x-show="isDark" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414M16.95 16.95l1.414 1.414M7.05 7.05l1.414 1.414M12 7a5 5 0 100 10 5 5 0 000-10z" />
                </svg>
            </button>

            {{-- Selector de idioma profesional --}}
            <div class="relative inline-block text-left ml-2" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open"
                        type="button"
                        class="inline-flex justify-center items-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 bg-white dark:bg-gray-900 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none"
                        aria-haspopup="true"
                        aria-expanded="open">
                    @if(app()->getLocale() === 'es')
                        {{-- Bandera España SVG --}}
                        <svg class="mr-2" width="20" height="15" viewBox="0 0 60 40"><rect width="60" height="40" fill="#c60b1e"/><rect y="10" width="60" height="20" fill="#ffc400"/></svg>
                        <span>Es</span>
                    @else
                        {{-- Bandera UK SVG --}}
                        <svg class="mr-2" width="20" height="15" viewBox="0 0 60 40"><rect width="60" height="40" fill="#00247d"/><g stroke="#fff" stroke-width="6"><path d="M0 0l60 40M60 0L0 40"/><path d="M30 0v40M0 20h60"/></g><g stroke="#cf142b" stroke-width="4"><path d="M0 0l60 40M60 0L0 40"/><path d="M30 0v40M0 20h60"/></g></svg>
                        <span>En</span>
                    @endif
                    {{-- Flecha --}}
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open"
                     x-cloak
                     class="origin-top-right absolute right-0 mt-2 w-32 rounded-md shadow-lg bg-white dark:bg-gray-900 ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                     role="menu"
                     aria-orientation="vertical"
                     tabindex="-1">
                    <div class="py-1" role="none">
                        <a href="{{ route('lang.switch', 'es') }}"
                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800"
                           role="menuitem">
                            <svg class="mr-2" width="20" height="15" viewBox="0 0 60 40"><rect width="60" height="40" fill="#c60b1e"/><rect y="10" width="60" height="20" fill="#ffc400"/></svg>
                            <span>Español</span>
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}"
                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800"
                           role="menuitem">
                            <svg class="mr-2" width="20" height="15" viewBox="0 0 60 40"><rect width="60" height="40" fill="#00247d"/><g stroke="#fff" stroke-width="6"><path d="M0 0l60 40M60 0L0 40"/><path d="M30 0v40M0 20h60"/></g><g stroke="#cf142b" stroke-width="4"><path d="M0 0l60 40M60 0L0 40"/><path d="M30 0v40M0 20h60"/></g></svg>
                            <span>English</span>
                        </a>
                    </div>
                </div>
            </div>
            {{-- Fin selector de idioma --}}
        </div>
    </div>
</header>

<main class="container mx-auto mt-10">
    <h2 class="text-3xl text-center font-black mb-10 text-gray-800 dark:text-gray-100">@yield('titulo')</h2>
    @yield('contenido')
</main>

<footer class="text-center p-5 text-gray-500 dark:text-gray-400 font-bold uppercase mt-10">
    {{-- Traducción para el footer --}}
    @lang('app.footer', ['year' => now()->year])
</footer>

@livewireScripts

{{-- Script de autocompletado global para buscar usuarios --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector('#buscar');
        const resultados = document.querySelector('#resultados');
        let indexSeleccionado = -1;

        resultados.addEventListener('mouseleave', function() {
            indexSeleccionado = -1;
            actualizarSeleccion(resultados.querySelectorAll('li'));
        });

        async function buscarUsuarios(query) {
            const response = await fetch(`/buscar-usuarios?q=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            });
            const usuarios = await response.json();
            resultados.innerHTML = '';

            if (usuarios.length > 0) {
                usuarios.forEach((user, idx) => {
                    const li = document.createElement('li');
                    li.classList = 'p-3 cursor-pointer text-gray-700 dark:text-gray-200 flex items-center gap-3 transition-colors hover:bg-sky-100 dark:hover:bg-sky-800';
                    li.innerHTML = `
                        <a href="/${user.username}" class="flex items-center gap-3 w-full h-full">
                            <img src="${user.imagen ? '/perfiles/' + user.imagen : '/img/usuario.svg'}" alt="avatar" class="w-8 h-8 rounded-full object-cover border border-gray-300" />
                            <div>
                                <span class="font-bold block text-gray-700 dark:text-gray-200">${user.username}</span>
                            </div>
                        </a>
                    `;
                    li.addEventListener('mouseenter', function() {
                        indexSeleccionado = idx;
                        actualizarSeleccion(resultados.querySelectorAll('li'));
                    });
                    li.addEventListener('mouseleave', function() {
                        indexSeleccionado = -1;
                        actualizarSeleccion(resultados.querySelectorAll('li'));
                    });
                    resultados.appendChild(li);
                });
                resultados.classList.remove('hidden');
            } else {
                const li = document.createElement('li');
                li.classList = 'p-3 text-center text-gray-500 dark:text-gray-400';
                li.textContent = '{{ __("app.no_resultados") }}';
                resultados.appendChild(li);
                resultados.classList.remove('hidden');
            }
        }

        input.addEventListener('input', async function () {
            const query = this.value.trim(); indexSeleccionado = -1;
            if (query.length < 1) {
                resultados.classList.add('hidden'); resultados.innerHTML = ''; return;
            }
            await buscarUsuarios(query);
        });

        input.addEventListener('focus', async function () {
            const query = this.value.trim(); if (query.length >= 1) await buscarUsuarios(query);
        });

        input.addEventListener('keydown', function (e) {
            const items = resultados.querySelectorAll('li'); if (!items.length) return;
            if (e.key === 'ArrowDown') { e.preventDefault(); indexSeleccionado = (indexSeleccionado + 1) % items.length; actualizarSeleccion(items); }
            if (e.key === 'ArrowUp')   { e.preventDefault(); indexSeleccionado = (indexSeleccionado - 1 + items.length) % items.length; actualizarSeleccion(items); }
            if (e.key === 'Enter' && indexSeleccionado >= 0) { e.preventDefault(); const link = items[indexSeleccionado].querySelector('a'); if (link) window.location.href = link.href; }
        });

        function actualizarSeleccion(items) {
            items.forEach((item, index) => {
                item.classList.remove('bg-sky-100', 'dark:bg-sky-800', 'text-gray-900', 'dark:text-white');
                if (index === indexSeleccionado) {
                    item.classList.add('bg-sky-100', 'dark:bg-sky-800', 'text-gray-900', 'dark:text-white');
                }
            });
        }

        document.addEventListener('click', function (e) {
            const form = document.querySelector('#form-busqueda');
            if (!form.contains(e.target)) { resultados.classList.add('hidden'); resultados.innerHTML = ''; input.value = ''; }
        });
    });
</script>

{{-- AQUI ES DONDE SE INCLUYEN LOS SCRIPTS DE LAS VISTAS HIJAS --}}
@stack('scripts')

</body>
</html>
