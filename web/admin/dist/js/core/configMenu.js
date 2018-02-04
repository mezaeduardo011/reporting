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
 * Esto es un namespace que hace parte de otro. Encargado de controlar las funcionalidades de Gestion de Menu de la vista box4 del html,
 * pero este gestionador de instancia de la vista 3 del generdor de vista
 *
 * @namespace GestionMenu
 * @memberOf Config
 */
Config.GestionMenu = {
    main: function () {
        var optPrincipalMenu = $('#box3 #itemPrincipalMenu')
        var optGestionMenu = $('#box3 #optGestionMenu');

        // Accion del menu principal, Editar entidad existente
        optPrincipalMenu.click(function(){
        	Config.GestionMenu.showOptionModelPrincipalMenu($(this));
        });

        // Accion del menu, Editar entidad existente
        optGestionMenu.click(function(){
        	Config.GestionMenu.showOptionModel($(this));
        });
    },
    showOptionModelPrincipalMenu: function (item) {
        var entidad = item.data('entidad');
        Config.html = '';
        $.post('/sendProcesarPrincipalMenu',{'entidad':entidad},function(dataJson){
            $('#modalCore #modalCoreLabel').html('Configuración del menu <strong id="vistaModa">'+entidad+'</strong>');

            // Permite extraer el html con los item
            Config.html = Config.GestionMenu.cargarItemPrincipal(dataJson);

            // Permite cargar el contenido html en el body del modal
            $('#modalCore div#modalBody').html(Config.html);

            // Permite tener accion si cambia el icono del selector
            Config.GestionMenu.changeIconSegundo();

            setTimeout(function () {
                // Seleccionar el icon que esta almacenado en la tabla
                $.each(dataJson.itemPrinc,function (idx,val) {
                    $('#modalCore div#modalBody .iconoUrl'+idx).val(val.icon_fa).change();
                });
            },500);

            // Enviar los datos al contolador para actualizar los cambios
            Config.GestionMenu.updateNombreMenu();

            $('#modalCore .modal-footer').hide();

        },'JSON');

        $("#modalCore").modal();
        console.log('Loading del Config.GestionMenu.showOptionModelPrincipalMenu item '+entidad);
    },
    showOptionModel: function(item) {
    	var app = item.data('apps');
    	var entidad = item.data('entidad');
    	var vista = item.data('vista');
        Config.html = '';

         $.post('/sendProcesarSubMenu',{'apps':app,'entidad':entidad,'vista':vista},function(dataJson){

            $('#modalCore #modalCoreLabel').html('Configuración de Menu de la vista /'+app+'/'+entidad+'/<strong id="vistaModa">'+dataJson.itemSegun[0].nombre+'</strong>');
            // Permite extraer el html con los item
            Config.html = Config.GestionMenu.cargarItemMenu(dataJson);

            // Permite cargar el contenido html en el body del modal
            $('#modalCore div#modalBody').html(Config.html);

            // Permite tener accion si cambia el icono del selector
            Config.GestionMenu.changeIconSegundo();

            // Seleccionar el icon que esta almacenado en la tabla
            $('#iconoUrl').val(dataJson.itemSegun[0].icon_fa).change();

            // Seleccionar el target del elemento del menu que se esta procesando
            $('#targetUrl').val(dataJson.itemSegun[0].targe).change();

            // Cambiar nombre de vista dinamica
            Config.GestionMenu.changeNombreVista();

            // Enviar los datos al contolador para actualizar los cambios
            Config.GestionMenu.updateNombreVista();

             $('#modalCore .modal-footer').show();

    	},'JSON');

    	$("#modalCore").modal();

        console.log('Loading del Config.GestionMenu.showOptionModel vista '+app+'/'+entidad+'/'+vista);

	},
    cargarItemPrincipal: function (dataJson) {
        Config.GestionMenu.jsonFa();
        Config.html = '<form name="sendItemPrincipal" id="sendItemPrincipal" method="post">';
        Config.html += '<table>';
        $.each(dataJson.itemPrinc, function (idx,val) {
            Config.html += '<tr id="subItem">';
            Config.html += '    <td><input class="requerido form-control"  size="15" pattern="^[A-Z]([A-Z_]){1,29}$" value="'+val.app+'" readonly style="border: 0px"></td>';
            Config.html += '    <td><input class="requerido form-control"  size="15" pattern="^[A-Z]([A-Z_]){1,29}$" value="'+val.entidad+'" readonly style="border: 0px"></td>';
            Config.html += '    <td><input class="requerido form-control contador" name="nombreUrl[]" id="nombreUrl" placeholder="Nombre de enlace" maxlength="60" size="20"  value="'+val.nombre+'" required></td>';
            Config.html += '    <td><div class="itemIcon"'+idx+' id="show"></div><select class="requerido form-control iconoUrl'+idx+'" name="iconoUrl[]" id="iconoUrl" required>'+localStorage.getItem('jsonFa')+'<select></td>';
            Config.html += '    <input type="hidden" name="id[]" id="id" value="'+val.id+'">';
            Config.html += '    <input type="hidden" name="apps[]" id="apps" value="'+val.app+'">';
            Config.html += '    <input type="hidden" name="entidad[]" id="entidad" value="'+val.entidad+'"> </td>';
            Config.html += '</tr>';
        })

        Config.html += '</table>';
        Config.html += '<div class="footerSubmitModal">';
        Config.html += '    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarVentana">Cerrar</button>';
        Config.html += '    <input type="submit" class="btn btn-primary" id="guardarCambios" value="Guardar Cambios">';
        Config.html += '</div>';
        Config.html += '</form>';
        return Config.html;
    },
	cargarItemMenu: function (dataJson) {
        Config.GestionMenu.jsonFa();
        Config.html = '<table>';
        Config.html += '<tr id="subItem">';
        Config.html += '    <td><input class="requerido form-control" name="baseUrl" id="baseUrl" placeholder="Ruta real del enlace" maxlength="60" size="20" pattern="^[A-Z]([A-Z_]){1,29}$" value="'+dataJson.itemSegun[0].vista+'" readonly style="border: 0px"></td>';
        Config.html += '    <td><input class="requerido form-control" name="nombreUrl" id="nombreUrl" placeholder="Nombre de enlace" maxlength="60" size="20" pattern="^[a-z]([a-z_]){1,29}$" value="'+dataJson.itemSegun[0].nombre+'" required></td>';
        Config.html += '    <td><div class="itemIcon" id="show"></div><select class="requerido form-control" name="iconoUrl" id="iconoUrl">'+localStorage.getItem('jsonFa')+'<select></td>';
        Config.html += '    <td><select name="targetUrl" class="requerido form-control" id="targetUrl"><option value="_self">_self</option><option value="_blank">_blank</option></select>';
        Config.html += '    <input type="hidden" name="id" id="hoSubMenuId" value="'+dataJson.itemSegun[0].id+'">';
        Config.html += '    <input type="hidden" name="apps" id="apps" value="'+dataJson.itemSegun[0].app+'">';
        Config.html += '    <input type="hidden" name="entidad" id="entidad" value="'+dataJson.itemSegun[0].entidad+'"> </td>';
        Config.html += '</tr>';
        Config.html += '<table>';
        return Config.html;
    },
    updateNombreVista: function () {
        var guardar = $('#modalCore #guardarCambios');
        guardar.click(function (event) {
            var hoMenuId = $('#modalCore #hoSubMenuId').val();
            var apps = $('#modalCore #apps').val();
            var entidad = $('#modalCore #entidad').val();
            var baseUrl = $('#modalCore #baseUrl').val();
            var nombreUrl =  $('#modalCore #nombreUrl').val();
            var iconoUrl =  $('#modalCore #iconoUrl').val();
            var targetUrl =  $('#modalCore #targetUrl').val();

            // Permite cancelar peticiones se se produce mas de una
            if(Config.currentRequest){
                Config.currentRequest.abort();
            }

            Config.currentRequest = $.post('/sendGestionMenu',{'hoMenuId':hoMenuId,'apps':apps,'entidad':entidad,'baseUrl':baseUrl,'nombreUrl':nombreUrl,'iconoUrl':iconoUrl,'targetUrl':targetUrl},function (dataJson) {
                if(dataJson.error==0) {
                    alertar(dataJson.msj, 'Gestión de menu.');
                    $("#modalCore").modal('hide');
                }
            });
            setTimeout(function () {
                // Actualizar el menu
                Core.Menu.main();
            },'500');
            event.preventDefault();
        })
    },
    updateNombreMenu: function () {
        var guardar = $('#modalCore form#sendItemPrincipal');
        guardar.submit(function (event) {
            // Permite cancelar peticiones se se produce mas de una
            if(Config.currentRequest){
                Config.currentRequest.abort();
            }
            Config.currentRequest = $.post('/setProcesarPrincipalMenu',$(this).serialize(),function (dataJson) {
                alertar(dataJson.msj, 'Gestión de menu.');
                $("#modalCore").modal('hide');
            });
            setTimeout(function () {
                // Actualizar el menu
                Core.Menu.main();
            },'500');
            event.preventDefault();
        })

    },
    changeNombreVista: function () {
            var nombreVista = $('#modalCore #nombreUrl');
            nombreVista.keyup(function () {
                var newNombreVista = $(this).val();
                $('#modalCore #modalCoreLabel #vistaModa').html(' ').html(newNombreVista);
            })
    },
    changeIconSegundo: function(){
        var iconoUrl = $('div#modalBody #iconoUrl');
        iconoUrl.change(function(){
            $('div#modalBody #show').html('<i  class="fa '+$(this).val()+' fa-2x" aria-hidden="true"></i>');
        });

        $('#iconoUrl select > option').hover(function () {
            $('div#modalBody #show').html('<i  class="fa '+$(this).val()+' fa-2x" aria-hidden="true"></i>');
        })
    },
    jsonFa:function(){
        $.get('/admin/dist/js/core/fa.json',function(dataJson){
            Config.html = '';
            Config.html +='<option value="" selected>Seleccionar</option>';
            $.each(dataJson.iconos,function(idx,valu){
                Config.html +='<option value="'+ valu.fa+'">'+valu.fa+'</option>';
            });
            localStorage.setItem('jsonFa',Config.html);
        },'JSON');
    }
}



