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
 * Esto es un namespace que hace parte de otro.  Encargado de controlar las funcionalidades de la
 * vista de las mascaras de funcionalidades y configuraciones las definicion de las vista.
 *
 * @namespace Mascaras
 * @memberOf Config
 */
Config.Mascaras = {}
Config.Mascaras = {
    main: function () {
        var optGestionMenu = $('#box1 #optGestionMascara');

        // Accion del menu, Editar entidad existente
        optGestionMenu.click(function(){
            Config.html = '';
            Config.html +=' <a class="btn btn-block btn-social btn-github" id="optGestionMascaras">';
            Config.html +='     <i class="fa fa-plus-square"></i> Crear Mascaraca';
            Config.html +=' </a>';

            // Agregar contenido a la vista secundaria
            Config.agregarContenido(optGestionMenu.text(), Config.html,'box1');
            $('#box1 #menuPrincipal .btn-github').removeClass('active')
            optGestionMenu.addClass('active');
            Config.activarSegundo('box1');
            Config.Mascaras.optCrearMascaras();

        });
    },
    optCrearMascaras:function () {
        var optCrearMenu = $('#box1 #optGestionMascaras');
        optCrearMenu.click(function () {
            Config.html = '';
            Config.Mascaras.activarCuartoBloque();

            Config.html = '<div class="row">';
            Config.html += '    <div class="col-md-7">';
            Config.html +='        <a class="btn btn-block btn-social btn-github">';
            Config.html +='          <i class="fa fa-list"></i> Mascaras existente';
            Config.html +='         </a>';
            Config.html +='     </div>';
            Config.html +='     <div class="col-md-5">';
            Config.html +='         <a class="btn btn-block btn-social btn-github" id="optNuevaMascara">';
            Config.html +='          <i class="fa fa-plus-square "></i> Nueva Mascara';
            Config.html +='         </a>';
            Config.html +='     </div>';
            Config.html +=' </div>';
            Config.html +=' <div id="divMascaraExistente" style=""></div>';

            $('#box4 #menuPrincipal #menuPrincipalBody').html(' ').html(Config.html);

            Config.Mascaras.getListado();
            // Se encarga de activar el contenedor dos de la vite de gestion de menu y darle accion
            Config.Mascaras.optGestorConfigMascara();
        })
    },
    getListado: function () {
        // Permite extraer todas las Aplicaciones, Tablas y vistas disponibles para el sistema
        $.post('/mascarasListar',function (dataJson) {
            Config.html = '';
            Config.html += '<table class="table table-striped text-center">';
            Config.html += ' <tr>';
            Config.html += '    <th>Tipo Dato</th>';
            Config.html += '    <th>label</th>';
            //Config.html += '    <th>mascara</th>';
            Config.html += '    <th>Class</th> ';
            Config.html += '    <th>opt</th> ';
            Config.html += ' </tr>';
            if(dataJson.data.length>0) {
                $.each(dataJson.data, function (key, value) {
                    Config.html += ' <tr>';
                    Config.html += '    <td>' + value.ho_tipo_dato_type + '</td>';
                    Config.html += '    <td>' + value.label + '</td>';
                    //Config.html += '    <td>' + value.mascara + '</td>';
                    Config.html += '    <td ><span class="badge bg-green">' + value.clase_input + '</span></td>';
                    Config.html += '    <td >';
                    Config.html += '        <i data-id="1" class="fa fa-check-square-o " style="cursor:pointer"></i>';
                    Config.html += '        <i data-id="1" class="fa fa-edit" style="cursor:pointer"></i>';
                    Config.html += '    </td>';
                    Config.html += '</tr>';
                });
            }else{
                Config.html += ' <tr>';
                Config.html += '    <td colspan="4" text-center><span class="badge bg-green"> NO SE HA ENCONTRADO MASCARAS REGISTRADAS</span></td>';
                Config.html += '</tr>';
            }
            Config.html += '</table>';
            $('#box4 #divMascaraExistente').html(' ').html(Config.html).show(900);
            $('#box4 #menuSegundarioBody .btn-github').removeClass('active');
            // Regresar a la pantalla principal
            Config.actRegresarVitaPrincipal();
        },'JSON');
    },
    optGestorConfigMascara:function () {
        var optNuevaMascara = $('#box4 #optNuevaMascara');
        // Cargar los tipos de datos
        var option = Config.TipoDatos.getTipoDatos();
        optNuevaMascara.click(function() {
            Config.html = Config.Mascaras.showFormulario();
            Config.agregarContenido('Registro de nueva Mascara', Config.html,'box4');
            Config.Mascaras.setMascaraSubmit();
            Config.activarSegundo('box4');
        });

    },
    activarCuartoBloque: function(){
        console.log('Loading del Config.Mascaras.activarCuartoBloque');
        $('#box1, #box2, #box4').hide(900);
        $('#box4, #box4 #menuPrincipal').show(900);
    },
    showFormulario: function () {

        Config.html = '';
        Config.html += '<form name="mascara" method="post" id="sendMascaraProcesar" enctype="multipart/form-data">';
        Config.html +=    '   <div class="box-body">';
        Config.html +=    '<input type="hidden" id="id" name="id">';
        Config.html +=   '  <div class="form-group">';
        Config.html +=   '      <label for="tipo">Tipo de datos</label>';
        Config.html +=   '      <select name="ho_tipo_dato_type" class="form-control requerido" id="ho_tipo_dato_type" required>'+localStorage.getItem('getTipoDatos')+'</select>';
        Config.html +=    ' </div>';
        Config.html +=   '  <div class="form-group">';
        Config.html +=   '      <label for="label">label</label>';
        Config.html +=   '      <input type="text" name="label" class="form-control contar requerido" id="label" placeholder="Ingresar la etiqueta para la expresion"  maxlength="20" data-item="20" required>';
        Config.html +=    ' </div>';
        Config.html +=    ' <div class="form-group">';
        Config.html +=    '     <label for="expresion">Expresión</label>';
        Config.html +=    '     <input type="text" name="mascara" class="form-control contar requerido" id="mascara" placeholder="Ingresar la mascara que desea poner como expresion regular" maxlength="100" data-item="100" required>';
        Config.html +=    ' </div>';
        Config.html +=    ' <div class="form-group">';
        Config.html +=    '     <label for="mensaje">mensaje</label>';
        Config.html +=    '     <input type="text" name="mensaje" class="form-control contar requerido" id="mensaje" placeholder="Por favor ingresar el/los nombre" maxlength="200" data-item="200" required>';
        Config.html +=    ' </div>';
        Config.html +=    ' <div class="form-group">';
        Config.html +=    '     <label for="clase">Clase</label>';
        Config.html +=    '     <input type="text" name="clase_input" class="form-control contar requerido" id="clase_input" placeholder="Ingresar la clase js para validar el campo" maxlength="30" data-item="30" required>';
        Config.html +=    ' </div>';
        Config.html +=   '  </div>';
        Config.html +=    '  <!-- /.box-body -->';
        Config.html +=    '   <div class="box-footer">';
        Config.html +=   '       <div class="col-md-4 col-sm-6 col-xs-12 pull-right"><button id="submit" class="btn btn-primary" value="Procesar">Procesar registro.</button></div>';
        Config.html +=    '   </div>';
        Config.html +=    '</form>';
        return Config.html;
    },
    setMascaraSubmit: function () {
        var sendMascaraProcesar = $('#box4 form#sendMascaraProcesar');
        sendMascaraProcesar.submit(function (event) {
            $.post('/mascaraCreate',$(this).serialize(),function (dataJson) {
                if(dataJson.error==0){
                    alertar(dataJson.msj)
                    Config.Mascaras.getListado();
                    Config.desactivarSegundo('box4');
                }else{
                    mostrarError(dataJson.msj);
                }
            });

            event.preventDefault();
        })
    },
    getMascaraShow: function (type) {
        $.post('/mascaraShow',{'type':type},function(dataJson){
            Config.html = '';
            $.each(dataJson.data,function(idx,val){
                Config.html += '<option value="'+val.clase_input+'">'+val.label+'</option>';
            });
            sessionStorage.setItem('getMascaraShow'+type,Config.html);
        },'JSON');
    }
}