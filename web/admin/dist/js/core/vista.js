//######
//## This work is licensed under the Creative Commons Attribution-Share Alike 3.0
//## United States License. To view a copy of this license,
//## visit http://creativecommons.org/licenses/by-sa/3.0/us/ or send a letter
//## to Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
//## Desarrollado por JPH - Ing. - Gregorio Jose Bolivar
//######
/**
 * Esto es un namespace que hace parte de otro. Esta vista enta encargada de procesar un conjunto de funcionalidades
 * encargadas del funcionamiento de la vista de procesar los datos generales del los ABM.
 *
 * @namespace Vista
 * @memberOf Core
 */
Core.Vista = {};
Core.Vista = {
    pathR: '',
    columns: '',
    currentRequest: '',
    main: function (path,Config) {
        this.__pathR__ = path;
        this.__columns__ = Config.colums;
        this.listado(Config.show);
        this.procesar();
    },
    listado : function (show) {
        var temp = this.__pathR__;
        var rows = this.__columns__;
        // Permite instanciar las funcionalidades de la Grid
        Core.VistaGrid.main(temp,rows,show);

        // Configuracion personalizada local de la vista
        Core.Vista.Util.priListaLoad();

        localStorage.removeItem('id');
        localStorage.setItem('temp',temp);
    },
    sortGridOnServer: function (ind,gridObj,direct) {
        alert(ind+'--'+gridObj+'--'+direct);
    },
    doOnRowSelected: function (id) {
        // Proceso mediante el cual permite cancelar peticiones enviadas y le da prioridad a las nuevas
        var send = '';
        if(Core.Vista.currentRequest){
            Core.Vista.currentRequest.abort();
        }

        Core.Vista.currentRequest = $.post('/'+localStorage.getItem('temp').toLowerCase()+'Show',{'data':id},function (dataJson) {
            if(dataJson.error==0) {
                $.each(dataJson.datos, function (key, valor) {
                    $("#" + key).val(valor).keyup();
                    if (key == 'id') {
                        localStorage.setItem('id', valor);
                    } else if (key == 'clave') {
                        var item = $("#" + key + ",#re" + key);
                        $("#" + key + ",#re" + key).val('').removeClass('requerido').siblings('label').children('div#campoRequerido').remove();
                    }
                });
                send = 'form#send' + localStorage.getItem('temp') + 'Procesar';

                $(send).addClass('update');
                $(send).data('id', localStorage.getItem('id'))
                $(send+" button#submit").html('Actualizar Datos').fadeIn(909);
                $("#divDelete").html('<a id="sacarRegistroSeleccionado" data-registro="' + localStorage.getItem('id') + '" class="btn btn-danger">Eliminar registro</a>');
                Core.Vista.sacarRegistro();
                Core.Vista.Util.priListaClick(dataJson);
            }else{
                mostrarError(dataJson.msj);
            }
        },'JSON');
    },
    procesar: function () {
        var temp = this.__pathR__;
        var send = 'form#send'+temp+'Procesar';
        var tockeA='6a5e98e08119d6bbc375cfdb928fe2bd';
        var tockeR='7ab22370bd8c9ca09537fd388778ee13';
        var token = false;
        var ruta = false;

        $(send+' #submit').click(function (event) {
            if ($(send).hasClass('update')) {
                ruta = temp.toLowerCase() + 'Update';
                token = tockeA;
            } else {
                ruta = temp.toLowerCase() + 'Create';
                token = tockeR;
            }
            // Permite instanciar funcionalidad en la vista local
            Core.Vista.Util.priClickProcesarForm(send);
            // Permite validar elementos de la mascaras
            var validate = Core.Vista.Util.validateMascaras();
            // Permite verificar que los dos elementos sean exitoso para procesar los form
            if (Core.valCamposObligatoriosCompletos(send) && validate) {

                var campos = new FormData();

                $(send).find('input, select, textarea').each(function() {
                    var elemento= this;
                    //alert("elemento.id="+ elemento.name + ", elemento.value=" + elemento.value);
                    if(elemento.id=='id' || elemento.value!='') {
                        campos.append(elemento.name, $('#'+elemento.id).val());
                    }
                });

                campos.append("token", token);
                $.ajax({
                    url: '/' + ruta,
                    type: "POST",
                    data: campos,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,   // tell jQuery not to set contentType
                    dataType: 'JSON',
                    success : function(dataJson) {
                        if (dataJson.error == 0) {
                            alertar(dataJson.msj);
                            setTimeout( location.reload(),500);
                            //Config.listado.table.ajax.reload();
                        } else {
                            mostrarError(dataJson.msj);
                        }
                    }
                });
            }
            return false;
            event.preventDefault();
        } );
    },
    sacarRegistro: function () {
        var temp = this.__pathR__;
        $('a#sacarRegistroSeleccionado').click(function () {
            var ruta = temp.toLowerCase() + 'Delete';
            var valor = $(this).data('registro');

            $.post('/'+ruta,{'obj':window.btoa(valor)},function (dataJson) {
                if (dataJson.error == 0) {
                    alertar(dataJson.msj);
                    setTimeout( location.reload(),500);
                } else {
                    mostrarError(dataJson.msj);
                }
            },'JSON');
        });
    },
    validarClave: function () {
        var d1 = $('input#clave.requerido');
        var d2 =$('input#reclave.requerido');
        if(d1.val().trim()!=d2.val().trim()){
            d2.focus();
            mostrarBug("Las claves ingresadas no coinciden debe de ser igual para continuar");
            return false;
        }else{
            return true;
        }
    }
};


