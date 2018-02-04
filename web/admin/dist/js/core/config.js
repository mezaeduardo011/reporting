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
 * Un namespace, Encargado de tener todas las configuraciones del módulo del generador del sistema
 * este es el namespace principal donde te tendrás las opciones iniciales
 * @namespace
 */
var Config;
Config = {
    html: null,
    progreso : null,
    currentRequest: '',
    main: function() {
        localStorage.removeItem('conexionId');
        localStorage.removeItem('entidadesSeleccionadas');
        // Opciones del menu
        var optBaseDatos = $('#box1 #optBaseDatos');
        var optCrearModelo = $('#box1 #optCrearModelo');

        console.log('Loading del Config.Menu');
        // Accion del menu Base de datos
        optBaseDatos.click(function(){
            Config.html = '';
            Config.html +=' <a class="btn btn-block btn-social btn-github" id="optDbExistente">';
            Config.html +='     <i class="fa fa-list"></i> Conexiones existente';
            Config.html +=' </a>';
            Config.html +=' <div id="divDbExistente" style="display: none"></div>';
            Config.html +=' <a class="btn btn-block btn-social btn-github" id="optNuevaConexion" style="margin-top: 4px">';
            Config.html +='     <i class="fa fa-database"></i> Nueva Conexion';
            Config.html +=' </a><br/>';
            Config.html +=' <div id="divNuevaConexion" style="display: none"></div>';

            Config.agregarContenido(optBaseDatos.text(), Config.html,'box1');

            $('#box2 #menuPrincipal .btn-github').removeClass('active')
            optBaseDatos.addClass('active');
            Config.activarSegundo('box1');
            Config.activarMostrarConfigDB();
        });
        // Accion del menu Crear nuevo Modulo
        optCrearModelo.click(function(){
            $('#box2 #menuPrincipal .btn-github').removeClass('active')
            optCrearModelo.addClass('active');
            var texto = optCrearModelo.text();
            $('#box2 #menuPrincipal #menuPrincipalTitulo').html(' ').html(texto);
            Config.Box2.configurarUniversoTablas(texto);
            Config.desactivarSegundo('box2');
        });
        // Gestionador de Menu
        Config.GestionMenu.main();
        // Gestion de Mascaras
        Config.Mascaras.main();

    },
    /** Permite agregar contenido en el segundo contenedor de cada bloque
     * @param String titulo, el contenido del titulo para mostrar
     * @param String contenido, el bloque que desea activar
     * @param String contenedor, el contenido en html que vas a cargar
     */
    agregarContenido: function (titulo, contenido, contenedor) {
        console.log('Loading del Config.agregarContenido '+contenedor);
        $('#'+contenedor+' #menuSegundarioTilulo').html(' ').html(titulo);
        $('#'+contenedor+' #menuSegundarioBody').html(' ').html(contenido);
    },
    activarSegundo: function(box){
        console.log('Loading del Config.activarSegundo '+box);
        $('#'+box+' #menuSegundario').show(900);
    },
    desactivarSegundo: function(box){
        console.log('Loading del Config.desactivarSegundo '+box);
        $('#'+box+' #menuSegundario').hide(900);
    },
    activarSegundoBloque: function(){
        console.log('Loading del Config.activarSegundoBloque ');
        $('#box1, #box3').hide(900);
        $('#box2, #box2 #menuPrincipal').show(900);
    },

    activarMostrarConfigDB: function(){
        var optDbExistente = $('#box1 #optDbExistente');
        var optNuevaConexion = $('#box1 #optNuevaConexion');
        optDbExistente.click(function(){
            if(optDbExistente.hasClass('active')){
                $('#box1 #menuSegundarioBody .btn-github').removeClass('active')
                $('#box1 #divDbExistente').html(' ').hide(900);
            }else {
               Config.loadTableConexiones()
            }
        });
        optNuevaConexion.click(function(){
            // Verificar si la vista esta activa debe cerrar
            if(optNuevaConexion.hasClass('active')){
                $('#box1 #menuSegundarioBody .btn-github').removeClass('active')
                $('#box1 #divNuevaConexion').html(' ').hide(900);
            }else{
                Config.html = '';
                Config.html +=' <form method="post" id="procesarConfigDB">';
                Config.html +=' <div class="form-group">';
                Config.html +=' <label>Datos del Server:</label>';
                Config.html +=' <div class="input-group">';
                Config.html +='  <div class="input-group-addon">';
                Config.html +='  <i class="fa fa-certificate"></i>&nbsp;';
                Config.html +='  </div>';
                Config.html +='    <input type="text" name="label" class="form-control" maxlength="20" placeholder="Ingresar la etiqueta de la conexion."  pattern="^([a-zA-Z0-9]){5,20}$" required>';
                Config.html +=' </div>';
                Config.html +=' <div class="input-group">';
                Config.html +='  <div class="input-group-addon">';
                Config.html +='  <i class="fa fa-id-card-o"></i>&nbsp;';
                Config.html +='  </div>';
                Config.html +='   <select class="form-control" name="driver" required> ';
                Config.html +='   <option selected value="sql">SQL Server</option> ';
                Config.html +='   </select> ';
                Config.html +=' </div>';
                Config.html +=' <div class="input-group">';
                Config.html +='  <div class="input-group-addon">';
                Config.html +='  <i class="fa fa-server"></i>&nbsp;';
                Config.html +='  </div>';
                Config.html +='    <input type="text" name="host" class="form-control" placeholder="Ingresar la ip del Servidor de BD" required>';
                Config.html +=' </div>';
                Config.html +=' <div class="input-group">';
                Config.html +='  <div class="input-group-addon">';
                Config.html +='  <i class="fa fa-database"></i>&nbsp;';
                Config.html +='  </div>';
                Config.html +='    <input type="text" name="db" class="form-control" placeholder="Ingresar el nombre de la BD" required>';
                Config.html +=' </div>';
                Config.html +=' <div class="input-group">';
                Config.html +='  <div class="input-group-addon">&nbsp;';
                Config.html +='  <i class="fa fa-user"></i>';
                Config.html +='  </div>';
                Config.html +='    <input type="text" name="usuario" class="form-control" placeholder="Ingresar el usuario de BD" required>';
                Config.html +=' </div>';
                Config.html +=' <div class="input-group">';
                Config.html +='  <div class="input-group-addon">';
                Config.html +='  <i class="fa fa-key"></i>&nbsp;';
                Config.html +='  </div>';
                Config.html +='    <input type="password" name="clave" class="form-control" placeholder="Ingresar la clave de base de datos" required >';
                Config.html +=' </div>';
                Config.html +=' <div class="box-footer">';
                Config.html +='  <button type="submit" class="btn btn-default">Cancelar</button>';
                Config.html +='  <button type="submit" class="btn btn-info pull-right">Crear Configuracion</button>';
                Config.html +=' </div>';
                Config.html +='</div>';
                Config.html +='</form>';
                $('#box1 #menuSegundarioBody .btn-github').removeClass('active')
                optNuevaConexion.addClass('active');
                $('#box1 #divNuevaConexion').html(' ').html(Config.html).show(900);
                Config.sendEnviarConfiguracion();
            }
        });
    },
    loadTableConexiones: function () {
        var optDbExistenteLoad = $('#box1 #optDbExistente');
        $.post('/getConfiguracionConexiones', function(dataJson) {
            Config.html = '';
            Config.html += '<table class="table table-striped text-center">';
            Config.html += ' <tr>';
            Config.html += '    <th>Etiqueta</th>';
            Config.html += '    <th>Host</th>';
            Config.html += '    <th>DB</th> ';
            Config.html += '    <th>User</th> ';
            Config.html += '    <th>opt</th> ';
            Config.html += ' </tr>';
            if(dataJson.items>0) {
                $.each(dataJson.data, function (key, value) {
                    Config.html += ' <tr>';
                    Config.html += '    <td>' + value.label + '</td>';
                    Config.html += '    <td>' + value.host + '</td>';
                    Config.html += '    <td>' + value.db + '</td>';
                    Config.html += '    <td ><span class="badge bg-green">' + value.usuario + '</span></td>';
                    Config.html += '    <td >';
                    Config.html += '        <i data-id="1" class="fa fa-check-square-o " style="cursor:pointer"></i>';
                    Config.html += '        <i data-id="1" class="fa fa-edit" style="cursor:pointer"></i>';
                    Config.html += '    </td>';
                    Config.html += '</tr>';
                });
            }else{
                Config.html += ' <tr>';
                Config.html += '    <td colspan="5" text-center><span class="badge bg-green"> NO SE HA ENCONTRADO CONEXIONES REGISTRADAS</span></td>';
                Config.html += '</tr>';
            }
            Config.html += '</table>';
            $('#box1 #divDbExistente').html(' ').html(Config.html).show(900);
            $('#box1 #menuSegundarioBody .btn-github').removeClass('active');
            optDbExistenteLoad.addClass('active');
        })
    },
    sendEnviarConfiguracion: function () {
        $('#box1  #menuSegundario #procesarConfigDB').submit(function () {
            console.info('Proceso enviando Config DataBase sendEnviarConfiguracion');
            $.post('/setDataBase',$(this).serialize(),function (dataJson) {
                if(dataJson.error==0){
                    Config.loadTableConexiones()
                    alertar(dataJson.msj);
                    $('#box1  #menuSegundario #procesarConfigDB input').val(' ');
                }else{
                    mostrarError(dataJson.msj);
                }

            },'JSON');
            return false;
        })
    },

    actRegresarVitaPrincipal: function () {
        var optRegresarVitaPrincipal = $('#menuPrincipalBody #optRegresarVitaPrincipal');
        optRegresarVitaPrincipal.click(function () {
            Config.regresarVitaPrincipal();
            informar('regresar a la vista principal', 'informar')
        })
    },
    regresarVitaPrincipal: function(){
        console.log('Loading del Config.activarSegundoBloque');
        $('#box1').show(900);
        $('#box4, #box3, #box2, #box2 #menuPrincipal').hide(900);
    },


};
document.write("<script type='text/javascript' src='admin/dist/js/core/configBox2.js'></script>");
document.write("<script type='text/javascript' src='admin/dist/js/core/configBox3.js'></script>");
document.write("<script type='text/javascript' src='admin/dist/js/core/gestionTablas.js'></script>");
document.write("<script type='text/javascript' src='admin/dist/js/core/configMenu.js'></script>");
document.write("<script type='text/javascript' src='admin/dist/js/core/configMascara.js'></script>");
document.write("<script type='text/javascript' src='admin/dist/js/core/configTipoDatos.js'></script>");
