@extends('layouts.app')

@section('titulo')
    {{-- Título traducido desde archivos de idioma --}}
    @lang('create.titulo')
@endsection

@push('styles')
    <!-- Estilos de Dropzone para el área de arrastre -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('contenido')
    {{-- ============================= --}}
    {{-- TOAST DE ÉXITO FLOTANTE       --}}
    {{-- ============================= --}}
    @if (session('mensaje'))
        <div 
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 2000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="fixed top-8 left-1/2 transform -translate-x-1/2 z-50
                   bg-green-500 text-white px-8 py-3 rounded-xl shadow-xl flex items-center gap-3 font-semibold text-lg"
            style="min-width: 260px;"
            @keydown.escape.window="show = false"
            x-cloak
        >
            {{-- Icono de check --}}
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('mensaje') }}</span>
        </div>
    @endif

    <div class="md:flex md:items-center">
        {{-- ============================= --}}
        {{-- Zona Dropzone para subir imagen --}}
        {{-- ============================= --}}
        <div class="md:w-1/2 px-10">
            <form 
                action="{{ route('imagenes.store') }}" 
                method="POST" 
                enctype="multipart/form-data" 
                id="dropzone" 
                class="dropzone border-dashed border-2 border-gray-300 dark:border-gray-600 w-full h-96 rounded flex flex-col justify-center items-center dark:bg-gray-800"
            >
                @csrf
                {{-- No incluir contenido aquí: Dropzone añade su propio mensaje --}}
            </form>
        </div>
        
        {{-- ============================= --}}
        {{-- Formulario de la publicación  --}}
        {{-- ============================= --}}
        <div class="md:w-1/2 p-10 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{ route('posts.store') }}" method="POST" novalidate>
                @csrf

                {{-- Campo Título --}}
                <div class="mb-5">
                    <label for="titulo" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        @lang('create.label_titulo')
                    </label>
                    <input 
                        id="titulo" 
                        name="titulo" 
                        type="text" 
                        placeholder="@lang('create.placeholder_titulo')" 
                        class="border p-3 w-full rounded-lg 
                               @error('titulo') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100" 
                        value="{{ old('titulo') }}" 
                    />
                    @error('titulo')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Campo Descripción --}}
                <div class="mb-5">
                    <label for="descripcion" class="mb-2 block uppercase text-gray-500 dark:text-gray-300 font-bold">
                        @lang('create.label_descripcion')
                    </label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        placeholder="@lang('create.placeholder_descripcion')" 
                        class="border p-3 w-full rounded-lg 
                               @error('descripcion') border-red-500 dark:border-red-500 @enderror
                               dark:bg-gray-700 dark:text-gray-100"
                    >{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                {{-- Campo oculto para imagen subida --}}
                <div class="mb-5">
                    <input name="imagen" type="hidden" value="{{ old('imagen') }}" />
                    @error('imagen')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Botón de envío --}}
                <input 
                    type="submit" 
                    value="@lang('create.boton')" 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" 
                />
            </form>
        </div>  
    </div>
@endsection

{{-- ============================= --}}
{{-- SCRIPTS PARA DROPZONE Y MULTIIDIOMA --}}
{{-- ============================= --}}
@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    // Mensajes traducidos según el idioma activo
    const dropzoneMessages = {
        dictDefaultMessage:        @json(__('create.dropzone_message')),
        dictFallbackMessage:       @json(__('create.dropzone_fallback')),
        dictInvalidFileType:       @json(__('create.dropzone_invalid_type')),
        dictFileTooBig:            @json(__('create.dropzone_file_too_big', ['max' => 2])),
        dictResponseError:         @json(__('create.dropzone_response_error', ['status' => ':status'])),
        dictCancelUpload:          @json(__('create.dropzone_cancel_upload')),
        dictCancelUploadConfirmation: @json(__('create.dropzone_cancel_confirm')),
        dictRemoveFile:            @json(__('create.dropzone_remove_file')),
        dictUploadCanceled:        @json(__('create.dropzone_upload_canceled')),
        dictSuccess:               @json(__('create.dropzone_success')),
        dictError:                 @json(__('create.dropzone_error')),
    };

    Dropzone.autoDiscover = false;

    document.addEventListener('DOMContentLoaded', function () {
        // LIMPIEZA PROFUNDA DE INSTANCIAS DROPZONE
        if (window.Dropzone) {
            // Borra todas las instancias (método robusto)
            if (Array.isArray(Dropzone.instances) && Dropzone.instances.length) {
                Dropzone.instances.forEach(dz => {
                    try { dz.destroy(); } catch(e) {}
                });
                Dropzone.instances = [];
            }
            // Borra atributo "dropzone" del form (por si lo dejó Dropzone)
            const dzForm = document.getElementById('dropzone');
            if (dzForm && dzForm.dropzone) {
                try { dzForm.dropzone.destroy(); } catch(e) {}
                dzForm.dropzone = null;
            }
        }
        // Borra cualquier mensaje residual de Dropzone
        const dzForm = document.getElementById('dropzone');
        const dzMessage = dzForm ? dzForm.querySelector('.dz-message') : null;
        if (dzMessage) dzMessage.remove();

        // INICIALIZACIÓN SEGURA DE DROPZONE
        new Dropzone("#dropzone", {
            ...dropzoneMessages,
            maxFilesize: 2,           // MB
            acceptedFiles: 'image/*',
            init: function () {
                // ========== AÑADIDO CLAVE: GUARDAR EL NOMBRE DE LA IMAGEN SUBIDA ==========
                this.on("success", function(file, response) {
                    // Al recibir la respuesta del backend (nombre de la imagen), la guardamos en el input oculto
                    document.querySelector('input[name="imagen"]').value = response.imagen;
                });
                this.on("error", function(file, message) {
                    // Toast de error opcional
                });
            }
        });

        // DEPURACIÓN: Verifica mensaje actual en consola
        console.log('Dropzone lang:', dropzoneMessages.dictDefaultMessage);
    });
</script>
@endpush
