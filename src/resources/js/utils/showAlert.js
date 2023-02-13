import Alert from 'bootstrap/js/src/alert';

export function showAlert(options) {
    const default_options = {
        message: '',
        type: 'error',
        autoclose: false
    };
    options = Object.assign({}, default_options, options);
    const container = document.getElementById('js_alerts_container');
    let classes = 'alert alert-' + options.type + ' mt-4 mb-0';

    if (!options.autoclose) {
        classes += ' alert-dismissible';
    }

    container.innerHTML += '' +
        '<div class="' + classes + '" role="alert">' +
        '<span>' + options.message + '</span>' +
        (!options.autoclose ? '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' : '') +
        '</div>';

    if (options.autoclose) {
        setTimeout(() => {
            const alert = new Alert(container.childNodes[container.childNodes.length - 1]);
            alert.close();
        }, 5000);
    }
}
