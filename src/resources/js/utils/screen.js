export function screen() {
    var myWidth = 0,
        myHeight = 0
    if (typeof(window.innerWidth) == 'number') {
        //Non-IE
        myWidth = window.innerWidth
        myHeight = window.innerHeight
    } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        //IE 6+ in 'standards compliant mode'
        myWidth = document.documentElement.clientWidth
        myHeight = document.documentElement.clientHeight
    } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
        //IE 4 compatible
        myWidth = document.body.clientWidth
        myHeight = document.body.clientHeight
    }
    return {
        height: myHeight,
        width: myWidth
    }
}
