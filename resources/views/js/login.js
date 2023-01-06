const jquery = require("./jquery");

function replaceClass(id, oldClass, newClass) {
    var elem = $(`#${id}`);
    if (elem.hasClass(oldClass)) {
        elem.removeClass(oldClass);
    }
    elem.addClass(newClass);
}

var state = false;
function showPass(){
    if(state){
        document.getElementById("password").setAttribute("type","password");
        replaceClass('eye','fa fa-eye','fa fa-eye-slash');
        state = false;
    }else {
        document.getElementById("password").setAttribute("type","text");
        replaceClass('eye','fa fa-eye-slash','fa fa-eye');
        state = true;
    }
}