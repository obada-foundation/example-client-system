export function formatUSN(usn) {
    if (usn.length <= 0) {
        return;
    }

    let str = [];
    for (let i = 0; i < usn.length; i+=4) {
        str.push(usn.slice(i, i+4));
    }

    return str.join('-');
}
