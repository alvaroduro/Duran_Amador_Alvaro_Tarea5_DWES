 /**Funcion para convertir un string en un slug evitando caracteres y mayusculas */
 window.string_to_slug = function (str, querySelector) { //Con esto tenemos acceso global a mi fx
    // Eliminar espacios al inicio y final
    str = str.replace(/^\s+|\s+$/g, '');

    // Convertir todo a minúsculas
    str = str.toLowerCase();

    // Definir caracteres especiales y sus reemplazos
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaeeeeiiiioooouuuunc------";

    // Reemplazar caracteres especiales por los correspondientes en 'to'
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    // Eliminar caracteres no alfanuméricos y reemplazar espacios por guiones
    str = str.replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');

    // Asignar el slug generado al campo de entrada correspondiente
    document.querySelector(querySelector).value = str;
}