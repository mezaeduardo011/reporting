//######
//## This work is licensed under the Creative Commons Attribution-Share Alike 3.0
//## United States License. To view a copy of this license,
//## visit http://creativecommons.org/licenses/by-sa/3.0/us/ or send a letter
//## to Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
//## Desarrollado por JPH - Ing. - Gregorio Jose Bolivar
//######
/**
 * Esto es un namespace que hace parte de otro. Encargado de controlar las funcionalidades de la vista box2 de de
 * configuracion de parametros.
 *
 * @namespace VistaSeguridad
 * @memberOf Core
 */
Core.VistaSeguridad = {
    pathR: '',
    columns: '',
    main: function (path,Config) {
        this.__pathR__ = path;
        this.__columns__ = Config.colums;
        // Cantidad de listado de vista
        var display = Config.show.display;
        // Si se puede ver el buscador
        var search = Config.show.search;
        // Si se ve el paginado
        var pagina = Config.show.pagina;
        //Identificador del valor para el data
        var rowid = Config.show.rowid;
        this.listado(display,search,pagina,rowid);
        this.procesar();
    },
    listado : function (display,search,pagina,rowid) {
        var temp = this.__pathR__;
        var rows = this.__columns__;
        var table = $('#dataJPH').DataTable({
            "ajax": {
                "url": temp.toLowerCase()+'Listar',
                "dataSrc": ""
            },
            "rowId": rowid,
            "iDisplayLength": display,
            "searching": search,
            "paging": pagina,
            "columns": rows,
            "sServerMethod": "POST",
            "language": {
                "url": "/admin/dist/js/Spanish.json"
            }
        });
        Core.VistaSeguridad.Util.priListaLoad();
        localStorage.removeItem('id');
        $('#dataJPH tbody').on('click', 'tr', function () {
            var data = table.row($(this)).data();

            var send = '';
            $('table tr').css({'background':'', 'color':''});
            $(this).css({'background':'#293A4A', 'color':'#ffffff'});
            //alert( 'You clicked on '+data+'s row' );
            $.post('/'+temp.toLowerCase()+'Show',{'data':data.id},function (dataJson) {
                $.each(dataJson.datos,function (key, valor) {
                    //alert(key);
                    $("#"+key).val(valor);
                    if(key=='id') {
                        localStorage.setItem('id', valor);
                    }else if(key=='clave'){
                        var item = $("#"+key +",#re"+key);
                        $("#"+key +",#re"+key).val('').removeClass('requerido').siblings('label').children('div#campoRequerido').remove();
                    }
                });
                send = 'form#seg'+temp+'Procesar';

                $(send).addClass('update');
                $(send).data('id',localStorage.getItem('id'))
                $("button#submit").html('Actualizar Datos').fadeIn(909);
                $("#divDelete").html('<a id="sacarRegistroSeleccionado" data-registro="'+localStorage.getItem('id')+'" class="btn btn-danger">Eliminar registro</a>');
                Core.VistaSeguridad.sacarRegistro();
                Core.VistaSeguridad.Util.priListaClick(dataJson);
            },'JSON')

        } );
    },
    procesar: function () {
        var temp = this.__pathR__;
        var send = 'form#seg'+temp+'Procesar';
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
            Core.VistaSeguridad.Util.priClickProcesarForm(send);
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
                        } else {
                            mostrarError(dataJson.msj)
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
