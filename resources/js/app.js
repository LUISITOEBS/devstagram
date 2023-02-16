import './bootstrap';
import Dropzone from "dropzone";

Dropzone.autoDiscover = false;


const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tui imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,
    init: function(){
        
        if( document.querySelector('[name="imagen"]').value.trim() ){
            console.log('Bien');
            const imagenPublicada = {};
            imagenPublicada.size = 1234;
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;
            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${ imagenPublicada.name }` );
            imagenPublicada.previewElement.classList.add('dz-sucess', 'dz-complete');
        }
    },
});

// dropzone.on('sending', (file, hr, formdata) => {
//     console.log(formdata);
// });

dropzone.on('success', ( file, response ) => {
    console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen;
});

// dropzone.on('error', ( message ) => {
//     console.log(message);
// });

dropzone.on('removedfile', () => {
    console.log('Deleted');
    document.querySelector('[name="imagen"]').value = '';
});

