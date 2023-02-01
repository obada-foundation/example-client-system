export function copyToClipboard(text) {
    var dummy = document.createElement("textarea");
    // to avoid breaking page when copying more words
    // can't copy when adding below this code
    // dummy.style.display = 'none'
    document.body.appendChild(dummy);
    // Be careful if you use textarea. setAttribute('value', value), which works with "input" does not work with "textarea". – Eduard
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
}
