import '../../base';

import Dropzone from "dropzone";

let myDropzone = new Dropzone("#verify-form-field", {
    url: '/verify/file'
});
myDropzone.on("addedfile", file => {
    console.log(`File added: ${file.name}`);
});
