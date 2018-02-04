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
 * vista box3 de funcionalidades y configuraciones las definicion de las vista.
 *
 * @namespace Box3
 * @memberOf Config
 */
Config.Box3 = {
    activarTercerBloque: function(){
        console.log('Loading del Config.activarSegundoBloque');
        $('#box1, #box2').hide(900);
        $('#box3, #box3 #menuPrincipal').show(900);
    },
    listadoUniversoTablas: function () {
        // leer las tablas seleccionadas en local store
        var table = localStorage.getItem('entidadesSeleccionadas');
        var conexion = localStorage.getItem('conexionId');
        $titulo='Listado de Tablas Seleccionadas';
        $('#box3 #menuPrincipalTitulo').html(' ').html($titulo);
        //alert(table);
        $('#optExtra').html(' ').html('<i class="fa fa-compress btn" aria-hidden="true" id="comprimirExpandir"></i>')

        if(Config.currentRequest){
            Config.currentRequest.abort();
        }

        Config.currentRequest =$.post('/getEntidadesSeleccionadas',{'conn':conexion,'entidad':table},function (dataJson) {

            Config.html = '';
            Config.html +='<div class="col-sm-12 col-md-12 ">';
            Config.html +='         <div class="panel-group"  id="accordionTablas">';
            $a = 0;
            $.each(dataJson, function (key , values) {
                Config.html +='             <div class="panel panel-default ">';
                Config.html +='                 <div class="panel-heading">';
                Config.html +='                     <h4 class="panel-title">';
                Config.html +='                         <a data-toggle="collapse" data-parent="#accordion" href="#collapse'+key+'" id="'+key+'-titulo">';
                Config.html +='                         <i class="fa fa-table" aria-hidden="true"></i> &nbsp;'+key+'</a>';
                Config.html +='                         <a id="itemPrincipalMenu" data-entidad="'+key+'"><i class="fa fa-bars pull-right" aria-hidden="true"></i></a>';
                Config.html +='                         <span class="label label-primary pull-right"> &nbsp;'+values.length+'</span>';
                Config.html +='                     </h4>';
                Config.html +='                 </div>';
                Config.html +='                 <div id="collapse'+key+'" class="panel-collapse collapse ">';
                Config.html +='                     <div class="panel-body">';
                Config.html +='                         <table class="table" id="'+key+'">';
                Config.html +='                             <tr>';
                Config.html +='                                 <td>';
                Config.html +='                                     <i class="fa fa-plus-circle" aria-hidden="true"></i> <a class="cursor" data-tabla="'+key+'" data-id="0">Nueva Vista</a>';
                Config.html +='                                 </td>';
                Config.html +='                             </tr>';
                $.each(values, function (item,valores) {
                    if(valores.catidad>0){
                        Config.html += '                     <tr>';
                        Config.html += '                         <td>';
                        if(parseInt(valores.procesado)==0) {
                            console.info(valores.procesado+'--0');
                            Config.html += '                      <i class="fa fa-square-o" aria-hidden="true"></i> <a class="cursor" data-tabla="' + key + '" data-id="1-' + valores.nombre + '">' + valores.nombre + '</a>';
                        }else{
                    	var Tmp = ' <ul class="nav navbar-nav opt">';
                        	Tmp += '	<li class="dropdown">';
                            Tmp += '	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Opciones <i class="fa fa-bars" aria-hidden="true"></i></a>';
                            Tmp += '	<ul class="dropdown-menu">';
                        	Tmp += '		<li><a href="#" id="optGestionMenu" data-apps="'+valores.apps+'" data-entidad="'+key+'" data-vista="'+valores.nombre+'">Gestion de Menu <i class="fa fa-cog pull-right" aria-hidden="true"></i></a></li>';
                          	Tmp += '		<li class="divider"></li>';
                          	Tmp += '		<li><a href="#">User stats <span class="glyphicon glyphicon-stats pull-right"></span></a></li>';
                          	Tmp += '		<li class="divider"></li>';
                          	Tmp += '		<li><a href="#">Favourites Snippets <span class="glyphicon glyphicon-heart pull-right"></span></a></li>';
                          	Tmp += '		<li class="divider"></li>';
                          	Tmp += '		<li><a href="/'+valores.nombre+'Index" target="_blank" class="cursor">Abrir la vista <i class="fa fa-external-link pull-right" aria-hidden="true"></i></a></li>';
                          	Tmp += '	</ul>';
                          	Tmp += '	</li>';
                        	Tmp += '</ul>';
                        	Config.html += '                  <a class="cursor optMenuLink" data-tabla="' + key + '" data-id="1-'+valores.nombre+'"><i class="fa fa-check-square-o" aria-hidden="true"></i> '+valores.nombre+'</a>  <div class=" text-right" style="margin-top: -21px">'+Tmp+'</div>';
                            console.info(valores.procesado+'--1');
                        }
                        Config.html += '                       </td>';
                        Config.html += '                     </tr>';
                    }
                });
                Config.html +='                         </table>';
                Config.html +='                     </div>';
                Config.html +='                 </div>';
                Config.html +='             </div>';
                $a ++;
            });

            Config.html +='         </div>';
            Config.html +='     </div>';

            Config.html +='<div class="col-sm-6 ">';
            Config.html +=' <a class="btn btn-block btn-social btn-github" id="optRegresarVistaSegundaria">';
            Config.html +='     <i class="fa fa-undo"></i> Regresar a la pantalla anterior';
            Config.html +=' </a>';
            Config.html +='</div>';
            Config.html +='<div class="col-sm-6 ">';
            Config.html +='     <a class="btn btn-block btn-social btn-facebook" id="optProcesarCodigoVistas" title="Procesar Vista">';
            Config.html +='         <i class="fa fa-cog fa-3x fa-fw"><!--Anima fa-spin --></i> Generar';
            Config.html +='     </a>';
            Config.html +='</div>';

            $('#box3 #menuPrincipal #menuPrincipalBody').html(' ').html(Config.html);
            /* Gestion de menu desde el configurador de menu */
            Config.GestionMenu.main();
            
            Config.Box3.comprimirExpandir();
            Config.Box2.optRegresarVistaSegundaria();
            Config.Box3.optProcesarCodigoVistas();
            Config.Box3.selecionarItemTabla();

        },'JSON');
    },
    getConfiguracionVista: function (connect, tabla, id, select) {
        // Enviar datos post para retornar datos
        if(Config.currentRequest){
            Config.currentRequest.abort();
        }

        Config.currentRequest = $.post('/getConfiguracionVista',{'connect':connect, 'tabla':tabla , 'vista':id },function(dataJson ) {
            Config.html = '<form method="post" id="sendVistaActiva">';
            Config.html += '<input type="hidden" name="conexiones_id" value="'+connect+'">';
            Config.html += '<input type="hidden" id="tabla" name="tabla" value="'+tabla+'">';
            Config.html +=' <table class="table table-striped" id="defineEntity">';
            // Definicion de la tabla
            Config.html +='     <tr>';
            Config.html +='          <th>Columna</th>';
            Config.html +='          <th>Tipo</th>';
            Config.html +='          <th title="Dimension de la tabla original">D</th>';
            Config.html +='          <th>Etiqueta &nbsp;<i id="cut" class="fa fa-files-o cursor" aria-hidden="true" title="Copiar todos los nombre de la vista real en esta fila"></i></th>';
            Config.html +='          <th>Mascara</th>';
            Config.html +='          <th title="Campo requerido">REQ</th>';
            Config.html +='          <th title="Ocultar en la Vista">HVI</th>';
            Config.html +='          <th title="Ocultar en el DataTable">HLI</th>';
            Config.html +='          <th title="Valor fijo en la vista">FIJO</th>';
            Config.html +='          <th title="Ingresar Place Holder">MSJ</th>';
            Config.html +='          <th title="Navega en otra Vista o es combo">NOV</th>';
            Config.html +='          <th title="Cual vista navega del listado">CUAL</th>';
            Config.html +='          <th title="Cual campo es el que necesita">Campo</th>';
            Config.html +='     </tr>';

            // Extraer las aplicaciones existente
            var seleApps='<select name="apps" id="apps">';
            seleApps +='<option value="0" selected><- Aplicación -></option>';
            $.post('/getListApp',function (dataJson) {
                $.each(dataJson.seleApps, function (key, value) {
                    $('#apps').append('<option value="'+value+'">'+value+'</option>');
                });
            },'JSON');
            seleApps+='</select>';

            // Recorrer datos principal
            $.each(dataJson , function( key, value ) {
                var tmp = $('#box3 #'+tabla+'-titulo').text().trim();
                var titulo =   seleApps+' / <b>'+tmp + '</b>'+ ' / <input placeholder="Nombre de la vista" name="nombre" id="nameVista" value="' + select +'" style="border: none" maxlength="50" required>';
                $('#box3 #menuSegundarioTilulo').html(' ').html(titulo);
                var BTN = 'Procesar vista';
                // Recorrer campos principal
                $.each(value.columns , function( item, valor ) {
                    // ########### Ya esta registrado  mostar ############
                    // Valores cuando es un update o mostrar
                    var VA_0 = '';
                    var VA_1 = '';
                    var VA_2 = '';
                    var VA_3 = '';
                    var VA_4 = '';
                    var VA_5 = '';
                    var VA_6 = ''; // Valor para el campo oculto del ordenamiento
                    var VA_7 = ''; // Valor para el campo oculto de caracter de separacion
                    var VA_FIJO = valor.fijo.length>0 ? 'value="'+valor.fijo+'"' : '';

                    // Verificar cuando trae valores cuando la vista esta registrada
                    if(id!=0 && (valor.label.length>0 || valor.place_holder.length>0 || valor.relacionado==1)) {
                        VA_0 = 'value="' + valor.label + '"';     // Valor cuando existen valor en la etiqueta
                        VA_2 = 'value="' + valor.place_holder + '"'; // Valor cuando existe registro en el place_holder
                        if (valor.relacionado!=0){ // Debe ser grilla o combo
                            VA_3 = '<option value="'+valor.relacionado+'" selected>'+valor.relacionado+'</option>'; // Valor para cuando retorna el valor relacionado y esta chequeado
                            VA_4 = '<option value="'+valor.tabla_vista+'" selected>'+valor.tabla_vista+'</option>'; // Seeccion de Tabla y Vista
                            VA_5 = Config.Box3.mostrarSelectores(valor.vista_campo); // Seleccion de Item
                            VA_6 = valor.vista_campo; // Seleccion de Item
                            if(VA_5.rows>1) {
                                VA_7 = 'value="' + valor.cart_separacion + '" style="display: block"';
                            }
                        }
                        BTN = 'Actualizar vista';
                    }
                    // ###########  END   ######
                    // Verificar si la item es Primery Key
                    var PK_0 = valor.restrincion!='PRI' ? '' : 'readonly';                                      // Solo para SELECT y INPUT
                    var PK_1 = valor.restrincion=='PRI' ? 'onclick="this.checked=!this.checked" checked' : '';  // Solo para Checkbox Marcar como Ocultar y bloquea su uso
                    var PK_2 = valor.restrincion=='PRI' ? 'onclick="this.checked=!this.checked"' : '';  // Solo para Checkbox
                    var RE_1 = valor.nulo!='YES' ? 'onclick="this.checked=!this.checked" checked' : '';    // Solo para Checkbox Marca como requerido y no se puede quitar
                    var TC_0 = ''; // Cuando es un tipo de capo reservado por el sistema es imput
                    var TC_1 = ''; // Cuando es tipo Checkbox de campo reservado y es para Ocultar
                    var TC_2 = ''; // Cuando es tipo Checkbox de campo reservado y es para Mostrar
                    if(valor.name=='created_user_id' || valor.name=='updated_user_id' ||  valor.name=='created_at' ||  valor.name=='updated_at'){
                        TC_0 = 'value="'+valor.name+'" readonly'
                        TC_1 = 'onclick="this.checked=!this.checked" checked'
                        TC_2 = 'onclick="this.checked=!this.checked"'
                    }

                    var pk = valor.restrincion=='PRI' ? '<u><b title="Primary Key de la entidad">'+valor.name+'</b></u>' : valor.name;
                    Config.html +='    <td><input type="hidden" name="restrincion['+item+']" value="'+valor.restrincion+'"><input type="hidden" name="field['+item+']" value="'+valor.name+'">'+pk+'</td>';
                    if(id!=0){
                        Config.html +='<td><input type="hidden" name="id['+item+']" value="'+valor.id+'">';
                    }else{
                        Config.html +='<td>';
                    }
                    Config.html +='    <input type="hidden" name="type['+item+']" value="'+valor.tipo+'">'+valor.tipo+'</td>';
                    Config.html +='    <td><input type="hidden" name="dimension['+item+']" value="'+valor.dimension+'"><span class="badge bg-blue">'+valor.dimension+'</span></td>';
                    //alert(valor.restrincion);
                    var req = valor.nulo!='YES' ? 'nulo' : '';
                    var req1 = valor.nulo!='YES' ? '<div class="requerido" title="Campo Requerido">*</div>' : '';
                    var req2 = valor.nulo!='YES' ? '<div id="etiqueta-'+item+'" data-item="'+item+'" style=" float: right; margin-top: -12px; margin-right: -12px; font-size: 10px; z-index: 100;" title="Maxima cantidad de caracteres">40</div>' : '';
                    var imp = valor.restrincion=='PRI' ? '<input type="hidden" name="etiqueta['+item+']" size="20" value="'+valor.name+'" required><span title="Primary Key de la entidad">'+valor.name +'</span>' : req1+'<input class="form-control etiqueta" name="etiqueta['+item+']"  data-item="etiqueta-'+item+'" type="text" size="20" maxlength="40" '+req+' '+TC_0+' '+VA_0+'>'+req2;
                    Config.html +='          <td>'+imp+'</td>';

                    Config.html +='          <td>'+Config.Box3.selectMascara(item,valor,PK_0)+'</td>';
                    Config.html +='          <td class="text-center"><input type="checkbox" name="nulo['+item+']" '+RE_1+' '+TC_2+' '+VA_1+'></td>';
                    Config.html +='          <td class="text-center"><input type="checkbox" name="hidden_form['+item+']" '+PK_1+' '+TC_1+' '+VA_1+'></td>';
                    Config.html +='          <td class="text-center"><input type="checkbox" name="hidden_list['+item+']" '+PK_1+' '+TC_1+' '+VA_1+'></td>';
                    Config.html +='          <td class="text-center"><input class="form-control" type="text" name="fijo['+item+']" id="fijo_'+item+'" '+PK_0+' '+VA_FIJO+'></td>';
                    Config.html +='          <td class="text-center"><input class="form-control" type="text" name="place_holder['+item+']" id="place_holder_'+item+'" '+PK_0+' '+TC_0+' '+VA_2+'></td>';
                    Config.html +='          <td class="text-center">'+Config.Box3.selectNavegaVista(item,VA_3)+'</td>';
                    Config.html +='          <td>'+Config.Box3.selectCualVista(item,TC_0,VA_4)+'</td>';
                    Config.html +='          <td class="vista_campo">'+Config.Box3.selectVistaCampos(item,TC_0,VA_5,VA_6,VA_7)+'</td>';
                    Config.html +='     </tr>';
                });
                Config.html +='</table>';
                Config.html +=' <div class="box-footer">';
                Config.html +='  <button type="submit" class="btn btn-info pull-right" id="enviarUniversoTablas">'+BTN+'</button>';
                Config.html +=' </div>';
                Config.html +='</form>';
                var mostrarUniversoTablabody = $('#box3 #menuSegundarioBody').html(' ').html(Config.html);
            });
            // Valores de seleccion de la apps
            setTimeout(function () {
                $('#apps').val(dataJson[0].apps)
            },500);
            // Copiar los elementos del la configuracion de las tabla a la vista
            Config.Box3.copiarMasivo();
            // Permite efectuar la actividad cuando existe relacion entre vistas
            Config.Box3.activarRelacionTable();
            // Permite enviar la nueva configuracion de la entidad
            Config.Box3.sendVistaNuevaConfigurada();
            // Configuracion de Select2
            $('.select2').select2({
                placeholder: 'Valores del selector',
                tags: true,
                width: 200
            });
            $("ul.select2-selection__rendered").sortable({
                containment: 'parent'
            })
            // End config seect 2
        },'JSON');
    },
    selectMascara: function(item,valor,PK_0){
        // Permite instanciar los tipos de datos en el momento cuando carga
        Config.Mascaras.getMascaraShow(valor.tipo);
        Config.html = '';
        Config.html +='<select class="form-control" name="mascara['+item+']" '+PK_0+' id="mascara_'+item+'">';
        /*if(valor.restrincion=='PRI' || valor.tipo=='int' || valor.name=='created_user_id' || valor.name=='created_user_id' ){
            Config.html +='          <option value="integer" selected>Integer</option>';
        }else if(valor.tipo=='bit'){
            Config.html +='          <option value="boolean" selected>Boolean</option>';
        }else if(valor.tipo=='date'){
            Config.html +='          <option value="boolean" selected>Fecha</option>';
        }else if(valor.tipo=='timestamp' ||valor.tipo=='datetime' || valor.name=='created_at' || valor.name=='updated_at'){
            Config.html +='          <option value="timestamp" selected>Timestamp</option>';
        }else if(valor.tipo=='text' || valor.dimension>250){
            Config.html +='          <option value="textArea" selected >TextArea</option>';
        }else if(valor.tipo=='varchar'){
            Config.TipoDatos.getTipoDatosShow(valor.tipo)
            Config.html +='          <option value="textArea" selected >TextArea</option>';
        }else if(valor.tipo=='bigint'){
            Config.html +='          <option value="textArea" selected >TextArea</option>';
        }else if(valor.tipo=='char'){
            Config.html +='          <option value="textArea" selected >TextArea</option>';
        }else{
            Config.html +='          <option value="texto">Texo</option>';
            Config.html +='          <option value="integer">Integer</option>';
            Config.html +='          <option value="string">String</option>';
            Config.html +='          <option value="datepicker">Fecha</option>';
            Config.html +='          <option value="correo">Correo</option>';
            Config.html +='          <option value="ip">IP</option>';
            Config.html +='          <option value="telefono">Telefono</option>';
            Config.html +='          <option value="color">Color</option>';
        }*/
        Config.html += sessionStorage.getItem('getMascaraShow'+valor.tipo);
        Config.html +='          </select>';
        //sessionStorage.removeItem('getMascaraShow'+valor.tipo);
        return Config.html;
    },
    selectNavegaVista: function (item,VA_3) {
        Config.html = '';
        Config.html +='<select class="form-control" name="relacionado['+item+']" id="relacionEntidad">'+VA_3+'';
        Config.html +='<option value="0">----</option>';
        Config.html +='<option value="combo">Combo</option>';
        Config.html +='<option value="grilla">Grilla</option>';
        Config.html +='</select>';
        return Config.html;
    },
    selectCualVista: function (item,TC_0,VA_4) {
        Config.html = '';
        Config.html +='<select class="form-control" name="tabla_vista['+item+']" id="tabla_vista" '+TC_0+' data-items="'+item+'" >';
        Config.html +='<option value="0" selected>----</option>';
        Config.html += VA_4;
        Config.html +='</select>';
        return Config.html;

    },
    selectVistaCampos: function (item,TC_0,VA_5,VA_6,VA_7) {
        Config.html = '';
        Config.html += '<select class="form-control select2" style="min-width:50%;max-width:100%" multiple name="vista_campo['+item+']" id="vista_campo" '+TC_0+'>';
        Config.html += VA_5.campos;
        Config.html += '</select>';
        Config.html += '<input type="text" id="campCombox" name="campCombox['+item+']" value="'+VA_6+'" style="display: none">';
        Config.html += '<input type="text" id="extra" name="extra['+item+']" size="1" maxlength="1" title="Caracter de separación." '+VA_7+'>';
        return Config.html;
    },
    mostrarSelectores:function(vista_campo) {
        var campos = vista_campo.split('|');
        var item = '';
        if(campos.length<2){
            item = '<option value="'+vista_campo+'" selected>'+vista_campo+'</option>';
        }else{
            for(a=0;a<campos.length;a++){
                item += '<option value="'+campos[a]+'" selected>'+campos[a]+'</option>';
            }
        }
        return {'campos':item,'rows':campos.length};
    },
    copiarMasivo: function (){
        $('#cut').click(function () {
            var ta1 = $('#box3 #defineEntity').find('tr');
            $.each(ta1 ,function(index,elemento){
                var let = $(elemento).find('td').eq(0).text();
                $(elemento).find('td').eq(3).children('input').val(let).keyup();
                var msjPlaceHolder = 'Por favor ingresar el/los '+let;
                $(elemento).find('td').eq(9).children('input').val(msjPlaceHolder).attr({'title':msjPlaceHolder});
            })
            alertar('Todos los elementos copiado exitosamente.')
        });
    },
    activarRelacionTable:function () {
        var btnActivarRelacion =  $('#box3 #relacionEntidad');

        // Si activa el boton de que hay una relacion de vista padre e hijo
        btnActivarRelacion.on('change',function (event) {
            var activo = $(this);
            if($(this).val()!=0) {
                var apps = $('#box3 #apps');
                if(apps.val()==0){
                    mostrarError('¡Uff!, debe seleccionar una aplicación para procesar las relaciones de entidades');
                    apps.focus();
                    event.preventDefault();
                }else{
                    var conex = localStorage.getItem('conexionId');
                    var opt = '<option value="0" selected>Seleccione</option>';

                    $.post('/getVistas',{'apps':apps.val(),'conexionId':conex,'tipo':activo.val()},function (dataJson) {
                        var rowss = [];
                        // Se arma las los listado de las tabla que pueden relacionar
                        $.each(dataJson.datos,function (key,value) {
                            opt+='<option name="'+value.entidad+'|'+value.vista+'">'+value.entidad+'--'+value.vista+'--'+value.pk+'</option>';
                        });
                        activo.parent('td').next('td').children('select').html(opt).change(function (event) {
                            var v = $(this);
                            var item = v.data('items');
                            // Crea la el listado del select2 del producto final
                            $.post('/getVistasColumns',{'apps':apps.val(),'conexionId':conex,'entidad':v.val()},function (dataJson) {
                                Config.html = '';
                                $.each(dataJson.rows ,function(k,v){
                                    Config.html += '<option value="'+v.campos+'">'+v.campos+'</option>';
                                });
                                v.parent('td').next('td').children('select').html(' ').html(Config.html);
                            });
                            v.parent('td').next('td').children('select').on('change',function(){
                                var item = $(this);
                                var herm = item.children('option:selected');
                                // Definir caracteres para e inpur cuando es relacion, defult vacio
                                var input = '';
                                // Permite levantar el atributo de caracter de separacion
                                //alert(herm.length);
                                if(herm.length>0){
                                    $.each(herm,function(key,val){
                                        input += ''+ val.value + '|';
                                    });
                                    // Permite mostrar y ocultar el campo extra para identificar caracter de separacion por defaul es vacio
                                    if(herm.length>1) {
                                        v.parent('td').next('td').children('input#extra').show(900).val('');
                                    }else{
                                        v.parent('td').next('td').children('input#extra').hide(900).val('');
                                    }
                                    var datos = input.substring(0,input.length-1);
                                    v.parent('td').next('td').children('input#campCombox').val(datos);

                                }

                            });
                            v.parent('td').next('td').children('span').find('.select2-selection__rendered').on('mouseup',function(){
                                var myVal = [];
                                $(this).each(function(index, valor) {
                                    var item = $(this).text();
                                    var temp = item.substring(1,item.length);
                                    myVal.push(temp);
                                });

                                //alert(myVal);
                            });

                        })
                    },'JSON');
                }
            } else {
                var opt = '<option value="0" selected>Seleccione</option>';
                btnActivarRelacion.parent('td').next('td').children('select').html(opt);
                btnActivarRelacion.parent('td').next('td').next('td').children('select').html(opt);
            }
        })
    },
    sendVistaNuevaConfigurada: function () {
        // Contador de campos
        $('#box3 #menuSegundarioBody .etiqueta').keyup(function() {
            var id = $(this).data('item');
            var max_chars = $(this).attr('maxlength');
            var chars = $(this ).val().length;
            var diff = max_chars - chars;
            $('#'+id ).html(diff);
        });
        // Enviar la vista al controlador
        $('#box3 #menuSegundarioBody form#sendVistaActiva').submit(function(e){
            var apps = $('#box3 #apps');
            var name = $('#box3 #nameVista');
            var item = $('#box3 #tabla');
            // Validar que alla ingresado un valor valido en la vista
            if(name.val()=='Nueva Vista' && name.val()!=''){
                mostrarError('Debe cambiar el nombre de la vista para poder procesar el registro: '+name.val());
                name.focus();
                return false;
            }else if(name.val().length<4){
                mostrarError('Debe cambiar el nombre de la vista para poder procesar el registro, debe tener mas de 3 caracteres y diferente de null la vista: '+name.val());
                name.focus();
                return false;
            }
            // Validar que alla seleccionado una apps
            //alert(parseInt(apps.val()));
            if(parseInt(apps.val())==0){
                mostrarError('Debe seleccionar una aplicación en el cual será creada esta vista: '+name.val());
                apps.focus();
                return false;
            }
            var procesada = $("#box3 #tabla").val();
            // Permite regenerar el campo de ordenamiento para verificar los datos del combo
            Config.Box3.reordenarCamposCombo();
            //$('#box3 #comprimirExpandir').click();
            $.post('/sendVistaNuevaConfigurada',$(this).serialize()+'&name='+name.val()+'&apps='+apps.val(), function (dataJson) {
                if(dataJson.error==0) {
                    alertar(dataJson.msj);
                    Config.desactivarSegundo('box3');
                    Config.Box3.listadoUniversoTablas(); //collapsed
                    setTimeout(function(){ $('#box3 #accordionTablas #'+procesada+'-titulo').click(); }, 1000);
                }
            })
            e.preventDefault();
        })

    },
    reordenarCamposCombo: function () {
        $('#box3 #menuSegundario table tr').each(function(index,value){
            var obj = $(this).find('td.vista_campo');
            //obj.css({'background-color':'#f11'});
            var spn = obj.children('span').find('.select2-selection__rendered li.select2-selection__choice');
            var imp = obj.children('input#campCombox');
            if(spn.length>0){
                var datos = '';
                $.each(spn,function(idx,val){
                    tmp = val.innerText;
                    datos += tmp.substring(1,tmp.length)+'|';
                });
                var temp = datos.substring(0,datos.length-1);
                imp.val(temp);
            }
        })
    },
    comprimirExpandir:function () {
        $('#comprimirExpandir').on('click',function () {
            var existe = $(this).hasClass('activado');
            if(!existe) {
                $('#box3 #menuPrincipalTitulo').hide(900);
                $('#box3 #menuPrincipalBody').hide(900).parent('div').parent('div').addClass('col-md-1').removeClass('col-md-4').hide(900);
                $('#box3 #menuSegundario').addClass('col-md-12').removeClass('col-md-8');
                $(this).addClass('activado');
                $(this).addClass('fa-expand').removeClass('fa-compress');
            }else{
                $('#box3 #menuPrincipalTitulo').show(900);
                $('#box3 #menuPrincipalBody').show(900).parent('div').parent('div').addClass('col-md-4').removeClass('col-md-1').show(900);
                $('#box3 #menuSegundario').addClass('col-md-8').removeClass('col-md-12');
                $(this).removeClass('activado');
                $(this).addClass('fa-compress').removeClass('fa-expand');
            }
        });
    },
    optProcesarCodigoVistas: function () {
        $('#box3 #optProcesarCodigoVistas').click(function () {
            var con = localStorage.getItem('conexionId');
            var ent = localStorage.getItem('entidadesSeleccionadas');
            $(this).children('i').addClass('fa-spin');
            // Informar proceso
            //var progreso = setInterval(Config.informarProgresoVista, 500);
            $.ajax({
                async: true,
                type: 'POST',
                url: '/procesarCrudVistas',
                data: {'connect':con,'tabla':ent},
                success: function(dataJson){
                    if(dataJson.error==0){
                        alertar(dataJson.msj);
                        $('#box3 #optProcesarCodigoVistas').children('i').removeClass('fa-spin');
                        Config.Box3.listadoUniversoTablas(); //collapsed
                        //$('table.table#'+item.val()).append('<tr><td><i class="fa fa-circle" aria-hidden="true"></i> <a class="cursor" data-tabla="'+item.val()+'" data-id="1">'+name.val()+'</a></td></tr>').fadeIn(1000)
                        //Config.selecionarItemTabla();
                        //setTimeout(function(){ $('#box3 #accordionTablas #'+procesada+'-titulo').click(); }, 1000);
                        Core.Menu.main();
                        Config.desactivarSegundo('box3');
                    }else{
                        mostrarError(dataJson.msj)
                    }
                },
                error: function(xhr, type, exception) {
                    // if ajax fails display error alert
                    mostrarError("ajax error response type "+type);
                }
            });


        })
    },
    informarProgresoVista: function () {
        $.ajax({
            async: true,
            type: 'POST',
            url: '/informarProceso',
            success: function(dataJson){
                alertar(dataJson.msj+' '+dataJson.proceso+''+dataJson.alter);
                if(dataJson.proceso==100){clearInterval(Config.Box3.optProcesarCodigoVistas.progreso)}
            },
            error: function(xhr, type, exception) {
                // if ajax fails display error alert
                alert("ajax error response type "+type);
            }
        });
    },
    selecionarItemTabla: function(){
        var item = $('#accordionTablas .cursor')
        item.click(function () {
            // Item seleccionado
            var select = $(this).text();

            // Tabla del renglon
            var tabla = $(this).data('tabla');
            var id = $(this).data('id');
            var connect = localStorage.getItem('conexionId');

            Config.Box3.getConfiguracionVista(connect, tabla, id, select);
            // Activar el segundo contenedor
            Config.activarSegundo('box3');
        });
    },
}