//######
//## This work is licensed under the Creative Commons Attribution-Share Alike 3.0
//## United States License. To view a copy of this license,
//## visit http://creativecommons.org/licenses/by-sa/3.0/us/ or send a letter
//## to Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
//## Desarrollado por JPH - Ing. - Gregorio Jose Bolivar
//######
/**
 * Esto es un namespace que hace parte de otro. Encargado de controlar las funcionalidades
 * de la vista cuando existe relaciones entre padre e hijos de vistas
 *
 * @namespace Box2
 * @memberOf Config
 */
Core.VistaRelacion = {};
Core.VistaRelacion = {
    pathR: '',
    columns: '',
    myGridR : '',
    main: function (path,Config) {
        this.__pathR__ = path;
        this.__columns__ = Config.colums;
        Core.Vista.Select.priListaLoad();
        this.listado(Config);
        this.procesar();
    },
    listado : function (Config) {
        var temp = this.__pathR__;
        var rows = this.__columns__;
        var datos = {'data':null };

        if(Config.relacionPadre.field.length>0){
            datos=Config.relacionPadre.field+"|"+Config.relacionPadre.value+"|"+Config.relacionPadre.id;
        }
        /* START DE GRILLA DHTML */
        var camp = '';
        /* Procedemos a crear una cadena de texto paa enviar al procesador de la vista para enviar lo datos en json*/
        $.each(rows, function (index,value) {
            camp+='id:'+value.id+'|type:'+value.type+'|align:'+value.align+'|sort:'+value.sort+'|value:'+value.value+'#';
        });
        // Quitamos el ultimo caracter de la cadena
        var tmp = camp.substring(0,camp.length-1);

        Core.VistaRelacion.myGridR = new dhtmlXGridObject('dataJPH'+Config.show.module);
        Core.VistaRelacion.myGridR.enablePaging(true,10,5,'pagingArea'+Config.show.module,true,"recinfoArea");
        Core.VistaRelacion.myGridR.setImagePath("/admin/dhtmlxSuite/codebase/imgs/");
        Core.VistaRelacion.myGridR.attachHeader(Config.show.filter);
        Core.VistaRelacion.myGridR.setPagingSkin("toolbar");
        Core.VistaRelacion.myGridR.enableAutoWidth(Config.show.autoWidth);
        Core.VistaRelacion.myGridR.enableMultiselect(Config.show.multiSelect);
        Core.VistaRelacion.myGridR.attachEvent("onRowSelect", Core.VistaRelacion.doOnRowSelected);
        Core.VistaRelacion.myGridR.submitOnlyRowID(true);
        Core.VistaRelacion.myGridR.init();
        Core.VistaRelacion.myGridR.enableSmartRendering(true);
        var gridQString = '/'+Config.show.module.toLowerCase()+'Listar?relacion='+window.btoa(datos)+'&obj='+window.btoa(tmp)+''; // save query string to global variable (see step 5)
        localStorage.setItem('showModule',Config.show.module);
        localStorage.setItem('module',temp);
        Core.VistaRelacion.myGridR.load(gridQString, 'json');
        /* END  */
        localStorage.removeItem('id');
    },
    doOnRowSelected: function (item) {
        // Enviar peticion para ver el detalles delregistro
        $.post('/'+localStorage.getItem('showModule').toLowerCase()+'Show',{'data':item},function (dataJson) {
            if(dataJson.error==0) {
                $.each(dataJson.datos, function (key, valor) {
                    $("#" + key).val(valor);
                    if (key == 'id') {
                        localStorage.setItem('id', valor);
                    } else if (key == 'clave') {
                        var item = $("#" + key + ",#re" + key);
                        $("#" + key + ",#re" + key).val('').removeClass('requerido').siblings('label').children('div#campoRequerido').remove();
                    }
                });
                send = 'form#send' + localStorage.getItem('module') + 'Procesar';

                $(send).addClass('update');
                $(send).data('id', localStorage.getItem('id'))
                $(send+" button#submit").html('Actualizar Datos').fadeIn(909);
                $("#divDelete").html('<a id="sacarRegistroSeleccionado" data-registro="' + localStorage.getItem('id') + '" class="btn btn-danger">Eliminar registro</a>');
                Core.VistaRelacion.sacarRegistro();
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

        $(send+' #submit').click(function (e) {
            if ($(send).hasClass('update')) {
                ruta = temp.toLowerCase() + 'Update';
                token = tockeA;
                //alert('UPDATE SI');
            } else {
                ruta = temp.toLowerCase() + 'Create';
                token = tockeR;
                //alert('CREAR SI');
            }
            if (Core.valCamposObligatoriosCompletos(send)) {
                var campos = new FormData();

                $(send).find(':input, select, textarea').each(function() {
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
                //$.post('/' + ruta, window.btoa($(this).serialize() + '&act=' + token), function (dataJson) {
                /*$.post('/' + ruta, $(this).serialize() + '&act=' + token, function (dataJson) {

                }, 'JSON');*/
            }
            return false;
            e.preventDefault();
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
    }
};

