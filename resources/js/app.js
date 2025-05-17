// IMPORTACIÓN DE ALPINE.JS EN EL BUNDLE
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

import Dropzone from "dropzone";

// --------------------------------------------
// Configuración de Dropzone (sin cambios)
// --------------------------------------------
Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen', 
    acceptedFiles: ".png, .jpg, .jpeg, .gif", 
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        if (document.querySelector('[name="imagen"]').value.trim()) {
            const imagenPublicada = {};
            imagenPublicada.size = 1234;    // tamaño ficticio
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;
            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);
            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    },
});

dropzone.on('success', function(file, response) {
    document.querySelector('[name="imagen"]').value = response.imagen;
});

dropzone.on('removedfile', function() {
    document.querySelector('[name="imagen"]').value = "";
    // Aquí podrías hacer una petición para eliminar la imagen en el servidor
});
