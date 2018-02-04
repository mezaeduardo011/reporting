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
 * Esto es un namespace que hace parte de otro. Encargado de controlar las funcionalidades de la vista box2 de de
 * configuracion de parametros.
 *
 * @namespace Box2
 * @memberOf Config
 */
Config.Box2 = {
    configurarUniversoTablas: function () {
        Config.activarSegundoBloque();
        Config.html = '';

        $.post('/getConfiguracionConexiones', function(dataJson) {
            Config.html +='<div class="form-group">';
            Config.html +='  <label>Seleccionar conexiones existente</label>';
            Config.html +='  <select class="form-control" id="selectConexionDataBaseSelect">';
            Config.html +='   <option selected>Seleccione</option>';
            $.each(dataJson.data,function (key, value) {
                Config.html += '   <option data-label="'+value.label+'" value="'+value.id+'" class="item">'+value.label+'</option>';
            });
            Config.html +=' </select>';
            Config.html +='</div>';
            Config.html +='<div id="showConexionDataBaseSelect"></div>';
            Config.html +=' <a class="btn btn-block btn-social btn-github" id="optRegresarVitaPrincipal">';
            Config.html +='     <i class="fa fa-undo"></i> Regresar a la pantalla anterior';
            Config.html +=' </a>';
            $('#box2 #menuPrincipal #menuPrincipalBody').html(' ').html(Config.html);
            Config.Box2.showConexionDataBaseSelect();
            Config.actRegresarVitaPrincipal();
        });
        console.log('Loading del Config.configurarUniversoTablas');
    },
    showConexionDataBaseSelect: function () {
        var showConexionDataBaseSelect = $('#box2 #menuPrincipalBody #selectConexionDataBaseSelect');
        showConexionDataBaseSelect.change(function () {
            var opt = $(this).val();
            localStorage.setItem('conexionId',opt);
            Config.Box2.loadConfigTablas();
        });
    },
    loadConfigTablas:function () {
        var opt = localStorage.getItem('conexionId');
        $.post('/getConfiguracionConexiones',{'conexion': opt}, function(dataJson){
            if(dataJson.items>0) {
                Config.html = '<div class="panel panel-default">';
                Config.html += '     <div class="panel-leftheading">';
                Config.html += '         <h4 class="panel-lefttitle"> &nbsp;&nbsp; ' + dataJson.data[0].label + ' </h4>';
                localStorage.setItem('baseDatosName',dataJson.data[0].db);
                localStorage.setItem('baseDatosDriver',dataJson.data[0].driver);
                Config.html += '     </div>';
                Config.html += '     <div class="panel-rightbody >';
                Config.html += '         <div class="input-group input-group-addon"">';
                $.each(dataJson.data, function (key, value) {
                    Config.html += '          <div class="input-group-addon">';
                    Config.html += '             <i class="fa fa-certificate"></i> &nbsp; Label&nbsp;:&nbsp; ' + value.label;
                    Config.html += '          </div><p></p>';
                    Config.html += '          <div class="input-group-addon">';
                    Config.html += '             <i class="fa fa-id-card-o"></i>  &nbsp;Driver&nbsp;:&nbsp;' + value.driver;
                    Config.html += '          </div><p></p>';
                    Config.html += '          <div class="input-group-addon">';
                    Config.html += '             <i class="fa fa-server"></i>  &nbsp;DB&nbsp;:&nbsp;' + value.db;
                    Config.html += '          </div><p></p>';
                    Config.html += '          <div class="input-group-addon">';
                    Config.html += '             <i class="fa fa-server"></i>  &nbsp;Host&nbsp;:&nbsp;' + value.host;
                    Config.html += '          </div><p></p>';
                    Config.html += '          <div class="input-group-addon">';
                    Config.html += '             <i class="fa fa-user"></i>  &nbsp;User&nbsp;:&nbsp;' + value.usuario;
                    Config.html += '          </div><p></p>';
                    Config.html += '          <div class="input-group-addon">';
                    Config.html += '             <i class="fa fa-key"></i>  &nbsp;Clave&nbsp;:&nbsp; ****** ';
                    Config.html += '          </div><p></p>';
                    Config.html += '         </div>';
                })
                Config.html += '     </div>';
                Config.html += '     <div class="clearfix"></div>';
                Config.html += '</div>';
                $('#box2 #menuPrincipal #menuPrincipalBody #showConexionDataBaseSelect').html(' ').html(Config.html).show(900);
                Config.Box2.mostrarUniversoTablaSegunConexion(dataJson.data[0].label,opt);
            }else{
                $('#box2 #menuPrincipal #menuPrincipalBody #showConexionDataBaseSelect').html(' ').html(Config.html).hide(900);
                Config.desactivarSegundo('box2');
            }

        });
    },
    mostrarUniversoTablaSegunConexion: function (titulo,dbId) {
        Config.activarSegundo('box2');
        $('#box2 #menuSegundarioTilulo').html(' ').html(titulo);
        $.post('/getAllUniverso',{'db':dbId},function (dataJson) {

            Config.html = '<form id="sendUniversoSeleccionado">';
            Config.html += ' <table class="table table-striped">';
            Config.html += '     <tr>';
            Config.html += '          <th style="width: 10px"><input type="checkbox" title="Todos" id="seleccionarTodoUniverso"></th>';
            Config.html += '          <th style="width: 10px">#</th>';
            Config.html += '          <th style="width: 10px">Base Dato</th>';
            Config.html += '          <th style="width: 10px">Tablas <i class="fa fa-plus-circle fa-2 cursor btn" aria-hidden="true" id="addEntidad"></i></th>';
            Config.html += '          <th style="width: 10px" class="text-center">N.Campo</th>';
            Config.html += '     </tr>';
            if(dataJson.error==0) {
                $.each(dataJson.data, function (key, value) {
                    Config.html += '  <tr>';
                    if (value.TABLE_REGISTRADA == 'SI'){
                        $chk = 'checked';
                    }else{
                        $chk = '';
                    }
                    Config.html += '        <td><input type="checkbox" class="item" data-table="' + value.TABLE_NAME + '" data-db="' + dbId + '" '+$chk+'></td>';
                    Config.html += '        <td>'+(parseInt(key)+1)+'</td>';
                    Config.html += '        <td>'+value.TABLE_CATALOG+'</td>';
                    Config.html += '        <td>'+value.TABLE_NAME+'</td>';
                    Config.html += '        <td class="text-center"><span class="badge bg-blue">'+value.TABLE_COLUMNS+'</span></td>';
                    Config.html += '  </tr>';
                })
            }else{
                Config.html += ' <tr>';
                Config.html += '    <td colspan="5" text-center><span class="badge bg-green">'+dataJson.msj+'</span></td>';
                Config.html += '</tr>';
            }

            Config.html += '</table>';
            Config.html += ' <div class="box-footer">';
            Config.html += '  <button type="submit" class="btn btn-info pull-right" id="enviarUniversoTablas">Enviar tablas seleccionadas</button>';
            Config.html += ' </div>';
            Config.html += '</form>';
            $('#box2 #menuSegundarioBody').html(' ').html(Config.html);
            Config.Box2.seleccionarTodoUniverso();
            Config.Box2.sendUniversoSeleccionado();
            // ### Otro namespace encargado de Procesar la creacion de tablas ###
            Config.GestionaTablas.main();
        },'JSON');
    },
    seleccionarTodoUniverso: function () {
        var activarSeleccionMultiple = $('#box2 #seleccionarTodoUniverso');
        var item = $('#box2 .item');
        activarSeleccionMultiple.change(function () {
            if($(this).is(':checked')){
                item.attr('checked', 'checked')
            }else{
                item.removeAttr('checked')
            }

        })
    },
    sendUniversoSeleccionado: function () {
        var sendUniversoSeleccionado = $('#box2 #menuSegundarioBody #sendUniversoSeleccionado');
        sendUniversoSeleccionado.submit(function () {
            if($('#box2 #menuSegundarioBody .item ').is(':checked')){

                // Registrar elemento
                var table = [];
                var db = '';
                $("#box2 #menuSegundarioBody input:checkbox:checked").each(function(key, value) {
                    db = $(this).data('db');
                    //alert(value.data('table'));
                    if(parseInt(db)>0 && typeof parseInt(db)!=="undefined"){
                        var item = $(this).data('table');
                        table.push(item);
                    }
                });

                $.post('/setEntidadesProcesar',{'db':db,'entidad':table},function ($dataJson) {
                    alertar('Enviar Configuracion del universo de las tablas');
                    // Cargo las entidades seleccionadas en localstore
                    localStorage.setItem('entidadesSeleccionadas',table);
                    Config.Box3.listadoUniversoTablas();
                    Config.Box3.activarTercerBloque();
                });
            }else{
                mostrarBug('Es necessario seleccionar una tabla para continuar', 'Uff!');
                console.warn('sendUniversoSeleccionado: Es necesario al menos seleccionar una entidad.')
            }
            return false;
        })
    },
    regresarVitaSegundaria: function(){
        console.log('Loading del Config.regresarVitaSegundaria');
        $('#box2').show(900);
        $('#box3, #box1, #box1 #menuPrincipal').hide(900);
    },
    optRegresarVistaSegundaria: function () {
        var optRegresarVistaSegundaria = $('#box3 #menuPrincipalBody #optRegresarVistaSegundaria');
        optRegresarVistaSegundaria.click(function () {
            Config.activarSegundoBloque();
            informar('Regresar a la vista Segundaria', 'informar')
        });
    },
}