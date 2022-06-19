
// Agregado automático de un inmueble al input 'nombreOfertaDonacion' en base al elemento seleccionado en el select inmueble:
function agregarInmuebleAImput(){
    var inmueble = document.getElementById("inmueble");
    if (inmueble.options[inmueble.selectedIndex].value >= 1) {
        document.getElementById("nombreOfertaDonacion").value = inmueble.options[inmueble.selectedIndex].text;
    }else{
        document.getElementById("nombreOfertaDonacion").value = "";
    }
}


// ==================================== Funciónes para validar sólo archivos de tipo JPG y PNG ====================================

function ValidarOfertaDonacion(){
    var elementoOferta = document.getElementById("imgOferta");
    var extensionesValidas = /(.jpg|.jpeg|.JPG|.JPEG|.png|.PNG)$/i;
    if (!(extensionesValidas.exec(elementoOferta.value))) {
        swal("¡Formato no soportado!", "Los formatos de archivos permitdos son [ jpg, jpeg, png ]", "warning");
        elementoOferta.value = "";
    }
}

function ValidarAcuerdo(){
    var elementoAcuerdo = document.getElementById("imgAcuerdo");
    var extensionesValidas = /(.jpg|.jpeg|.JPG|.JPEG|.png|.PNG)$/i;
    if (!(extensionesValidas.exec(elementoAcuerdo.value))) {
        swal("¡Formato no soportado!", "Los formatos de archivos permitdos son [ jpg, jpeg, png ]", "warning");
        elementoAcuerdo.value = "";
    }
}

function ValidarEscritura(){
    var elementoEscritura = document.getElementById("imgEscritura");
    var extensionesValidas = /(.jpg|.jpeg|.JPG|.JPEG|.png|.PNG)$/i;
    if (!(extensionesValidas.exec(elementoEscritura.value))) {
        swal("¡Formato no soportado!", "Los formatos de archivos permitdos son [ jpg, jpeg, png ]", "warning");
        elementoEscritura.value = "";
    }
}

function ValidarComodato(){
    var elementoComodato = document.getElementById("imgComodato");
    var extensionesValidas = /(.jpg|.jpeg|.JPG|.JPEG|.png|.PNG)$/i;
    if (!(extensionesValidas.exec(elementoComodato.value))) {
        swal("¡Formato no soportado!", "Los formatos de archivos permitdos son [ jpg, jpeg, png ]", "warning");
        elementoComodato.value = "";
    }
}