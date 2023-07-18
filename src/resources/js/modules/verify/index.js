import '../../base';

import Dropzone from "dropzone";
import QRCode from "qrcode";

if (document.getElementById('verify-form-field')) {
    let myDropzone = new Dropzone("#verify-form-field", {
        url: '/verify/upload'
    });
    myDropzone.on("addedfile", file => {
        console.log(`File added: ${file.name}`);
    });
}

if (document.getElementById('verification-qr')) {
    const url = document.getElementById('verification-link').getAttribute('href');
    QRCode.toDataURL(url, {scale: 4, maskPattern: 5}, function(error, url) {
        if (error) {
            console.error(error);
            return;
        }

        const img = document.getElementById('verification-qr');
        img.src = url;
    });
}
