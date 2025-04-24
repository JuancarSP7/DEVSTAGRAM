@extends('layouts.app')

@section('titulo')
    Página Principal
@endsection

@section('contenido')
    <h2 class="text-xl text-gray-500 font-bold mb-4 text-center">Publicaciones de tus seguidores</h2>

    {{-- ✅ PASAMOS mostrarInfoAutor de forma compatible con Blade --}}
    <x-listar-post :posts="$posts" mostrarInfoAutor="1" />
@endsection
