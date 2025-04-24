import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen', 
    acceptedFiles: ".png, .jpg, .jpeg, .gif", 
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        if(document.querySelector('[name="imagen"]').value.trim()){
            const imagenPublicada = {};
            imagenPublicada.size = 1234;    // tamaño ficticio
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;
            this.options.addedfile.call(this, imagenPublicada);            //opcion de Dropzone para añadir archivo
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);        //opcion de DRopzone para añadir miniatura
            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    },
    
});


dropzone.on('success', function(file, response) {
    document.querySelector('[name="imagen"]').value = response.imagen;   // Asigna la imagen al input oculto
});

dropzone.on('removedfile', function() {
    document.querySelector('[name="imagen"]').value = "";   // Limpia el input oculto
    // Eliminar la imagen del servidor
});    


