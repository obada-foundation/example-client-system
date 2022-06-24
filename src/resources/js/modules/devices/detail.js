import axios from 'axios';

/*document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('create_obit_btn').addEventListener('click', (event) => {
        event.target.disabled = true;
        axios(window.storeObitUrl, {
            method:'post',
            data: {
                device_id: window.device_id
            },
            responseType: 'json',
        }).then((response) => {
            event.target.disabled = false;
            swal("Done!", "Local Obit created. View obit to synch to blockchain.", "success");
        }).catch((e) => {
            event.target.disabled = false;
            if(e.response.data.hasOwnProperty('errorMessage')) {
                swal("Error!", e.response.data.errorMessage, "error");
            } else {
                swal("Error!", "We could not create the obit.", "error");
            }
        });
    });
});*/
