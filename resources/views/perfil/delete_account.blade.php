@extends('layouts.app')

@section('titulo')
    Darse de Baja
@endsection

@section('contenido')
<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-red-600">¿Estás seguro de que deseas darte de baja?</h2>
    <p class="mb-8 text-gray-700 text-lg font-semibold">
        Esta opción eliminará <span class="font-bold text-red-600">permanentemente</span> tu cuenta, publicaciones y comentarios.
    </p>
    <form method="POST" action="{{ route('perfil.baja.destroy') }}">
        @csrf
        @method('DELETE')
        <div class="flex flex-col md:flex-row gap-4">
            {{-- Botón CANCELAR: igual que el de baja, pero azul --}}
            <a href="{{ route('perfil.index', auth()->user()->username) }}"
               class="w-full md:w-1/2 text-center bg-sky-600 hover:bg-sky-700 text-white font-bold p-3 rounded-lg transition-colors uppercase tracking-wider text-base shadow focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2"
               style="letter-spacing: 0.05em;">
                CANCELAR
            </a>
            {{-- Botón DARSE DE BAJA: rojo, idéntico diseño --}}
            <button type="submit"
                class="w-full md:w-1/2 text-center bg-red-600 hover:bg-red-700 text-white font-bold p-3 rounded-lg transition-colors uppercase tracking-wider text-base shadow focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                style="letter-spacing: 0.05em;"
            >
                DARSE DE BAJA
            </button>
        </div>
    </form>
</div>
@endsection
