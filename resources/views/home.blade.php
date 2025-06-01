@extends('layouts.app')

@section('titulo')
    {{-- Usamos la clave de traducción para el título principal --}}
    @lang('home.titulo')
@endsection

@section('contenido')
    {{-- Título secundario traducido --}}
    <h2 class="text-xl text-gray-500 font-bold mb-4 text-center">
        @lang('home.subtitulo')
    </h2>

    {{-- Pasamos mostrarInfoAutor como booleano para el componente --}}
    <x-listar-post :posts="$posts" :mostrarInfoAutor="true" />
@endsection
