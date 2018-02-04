/*
######
## This work is licensed under the Creative Commons Attribution-Share Alike 3.0
## United States License. To view a copy of this license,
## visit http://creativecommons.org/licenses/by-sa/3.0/us/ or send a letter
## to Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
## Desarrollado por JPH - Ing. - Gregorio Jose Bolivar
######
*/
/**
 * Esto es un namespace que hace parte de otro. Encargado de controlar las funcionalidades de la vista de las tipos de datos del sistema.
 *
 * @namespace TipoDatos
 * @memberOf Config
 */
Config.TipoDatos = {};
Config.TipoDatos = {
    main:function () {

    },
    getTipoDatos:function(){
        $.post('/tipoDatosListar',function(dataJson){
            Config.html = '';
            Config.html +='<option value="0" selected>Seleccionar</option>';
            $.each(dataJson.data,function(idx,val){
                Config.html += '<option value="'+val.type+'">'+val.label+'</option>';
            });
            localStorage.setItem('getTipoDatos',Config.html);
        },'JSON');
    },
    getTipoDatosShow: function (type) {
        $.post('/tipoDatosShow',{'type':type},function(dataJson){
            Config.html = '';
            $.each(dataJson.data,function(idx,val){
                Config.html += '<option value="'+val.type+'">'+val.label+'</option>';
            });
            localStorage.setItem('getTipoDatosShow'+type,Config.html);
        },'JSON');
    }


}