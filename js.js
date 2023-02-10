function pass() {
    var check = document.getElementById("checkbox");

    if (check.checked) {
        document.getElementById("clave").style="display: block";
        document.getElementById("clave2").style="display: block";
        document.getElementById("span").innerHTML="<br>"
        document.getElementById("span2").innerHTML="<br>"
    }
    else {
        document.getElementById("clave").style="display: none";
        document.getElementById("clave2").style="display: none";
        document.getElementById("span").innerHTML=""
        document.getElementById("span2").innerHTML=""
    }
}