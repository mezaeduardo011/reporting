//######
//## This work is licensed under the Creative Commons Attribution-Share Alike 3.0
//## United States License. To view a copy of this license,
//## visit http://creativecommons.org/licenses/by-sa/3.0/us/ or send a letter
//## to Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
//## Desarrollado por JPH - Ing. - Gregorio Jose Bolivar
//######
/**
 * Esto es un namespace que hace parte de otro.  Encargado de controlar las funcionalidades del diseñador de
 * tablas que se instancia desde el listado de tablas
 *
 * @namespace GestionaTablas
 * @memberOf Config
 */
Config.GestionaTablas = {
    html: null,
    progreso : null,
    main: function() {
        this.createTable();
    },
    createTable:function () {
        var addEntidad = $('#box2 #addEntidad');

        // Cabecera del nuevo formulario de creacion de entidades
        Config.html = '<form id="sendCreacionEntidad"  class="form-horizontal col-lg-12"" >';
        Config.html += ' <table class="table table-striped text-center">';
        Config.html += '        <tr>';
        Config.html += '            <td colspan="7"><div class="input-group col-lg-7"><span class="input-group-addon"><i class="fa fa-database fa-3" aria-hidden="true"> &nbsp;&nbsp; <b>'+localStorage.getItem('baseDatosName')+' / </b> </i></span><input type="text" name="entidad" maxlength="40" class="form-control" placeholder="Ingresar el nombre de tabla" pattern="^[a-z]([a-z_]){1,29}$" autofocus required></div><div class="cursor btn" id="addBtcAuditor"><i class="fa fa-address-card" aria-hidden="true" title="Agregar campos de auditoria."></i></div></td>';
        Config.html += '        </tr>';
        Config.html += '        <tr class="border:1px">';
        Config.html += '          <th style="width:15%">Nombre</th>';
        Config.html += '          <th style="width:15%">Tipo</th>';
        Config.html += '          <th style="width:15%" title="Campo Predeterminado">Fijo</th>';
        Config.html += '          <th style="width:10%">Null</th>';
        Config.html += '          <th style="width:20%">Index</th>';
        Config.html += '          <th style="width:20%;">Extra</th>';
        Config.html += '          <th style="width:5%;">Act</th>';
        Config.html += '        </tr>';
        Config.html += '     <tbody id="camposEntidad">';
        Config.html += '     </tbody>';
        Config.html += '        <tr>';
        Config.html += '            <th colspan="7" style="text-align: right"><input type="hidden" name="baseDatosDriver" value="'+localStorage.getItem('baseDatosDriver')+'"><input type="hidden" name="conexionId" value="'+localStorage.getItem('conexionId')+'"><input type="hidden" name="databaseName" value="'+localStorage.getItem('baseDatosName')+'"><input type="submit" class="btn btn-primary"><i class="fa fa-plus-circle fa-2 cursor btn" aria-hidden="true" id="addItem" title="Agregar Campos"> </th>';
        Config.html += '        </tr>';
        Config.html += '     </tfoot>';
        Config.html += '  </table>';
        Config.html += '</form>';

        // Acciones de la tabla dinamica que se instancia desde el config.js line 344 Config.GestionaTablas.main();
        addEntidad.click(function () {
            //Carga la tabla dinamica a cabecera
            $('#box2 #menuSegundarioBody').html(' ').html(Config.html);

            // Agregar item cuando es primera vez
            Config.GestionaTablas.addItemTabla('PRI');

            // Accion cuando hace click en la opciones de la tabla dinamica
            $('#box2 #addItem').click(function(){
                    // Agregar item cuando es la segunda vez
                    Config.GestionaTablas.addItemTabla('SEG');
                    // Accion cuando quiere eliminar un elemento de la tabla dinamica
                    $('#box2 #delItem').click(function(){
                        $(this).parent('td').parent('tr').hide(900).remove();
                    });
                    // Acccion para cuando es varchar
                    $('#box2 #tipos').change(function () {
                        var toque = $(this);
                        if(toque.val()=='varchar'){
                            $(this).siblings().show(900).focus().change(function(){
                                // Valor ingresao del varchar
                                var valorItem = $(this).val();
                                // Valor del nuevo varchar
                                var redefinirVarchar = toque.val()+'('+valorItem+')';
                            });
                        }else{
                            $(this).siblings().hide(900);
                        }
                    });
            });
            Config.GestionaTablas.sendCreacionData();
            Config.GestionaTablas.addRowsAuditor();
            Config.GestionaTablas.dragable();
      });

    },
    sendCreacionData: function () {
        var sendCreacion = $('#box2 form#sendCreacionEntidad');
        sendCreacion.submit(function(){
           $.post('/createTablas',$(this).serialize(),function (dataJson) {
               if(dataJson.error==0){
                   alertar(dataJson.msj);
                   setTimeout(function () {
                       Config.Box2.loadConfigTablas();
                   },'500');
               }else{
                   mostrarError(dataJson.msj);
               }
           },'JSON');
           return false;
        });
    },
    addRowsAuditor: function () {
        var addBtcAuditor = $('#box2 #addBtcAuditor');
        // Funcionalidad de agregar los campos de auditoria
            addBtcAuditor.on('click', function () {
                //alert($('#box2 #sendCreacionEntidad #camposEntidad').find('tr').hasClass('auditory'));
                if(!$('#box2 #sendCreacionEntidad #camposEntidad').find('tr').hasClass('auditory')) {
                    for (i = 1; i <= 4; i++) {
                        Config.GestionaTablas.addItemTabla();
                        var item = $('#box2 #sendCreacionEntidad #camposEntidad').find('tr');
                        var tema = item.length;
                        // Opciones necesaria para los campos de auditoria de la creacion de la entidad 4 Campos
                        switch (i) {
                            case 1:
                                item.eq(tema - 1).addClass('auditory').children('td').children('input#campos').val('created_usuario_id').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('select#tipos').val('int').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('input#default,select').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('select#requerido').val('NOT NULL').attr({'readonly': 'readonly'});
                                break;
                            case 2:
                                item.eq(tema - 1).addClass('auditory').children('td').children('input#campos').val('updated_usuario_id').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('select#tipos').val('int').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('input#default,select').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('select#requerido').val('NULL').attr({'readonly': 'readonly'});
                                break;
                            case 3:
                                item.eq(tema - 1).addClass('auditory').children('td').children('input#campos').val('created_at').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('select#tipos').val('datetime').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('input#default,select').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('select#requerido').val('NOT NULL').attr({'readonly': 'readonly'});
                                break;
                            case 4:
                                item.eq(tema - 1).addClass('auditory').children('td').children('input#campos').val('updated_at').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('select#tipos').val('datetime').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('input#default,select').attr({'readonly': 'readonly'});
                                item.eq(tema - 1).children('td').children('select#requerido').val('NULL').attr({'readonly': 'readonly'});
                                break;
                        }
                    }
                }else{
                    mostrarError('No puede agregar mas campos de control de auditoría en esta creación.')
                }
            });
    },
    addItemTabla: function (opt) {
        // Variable encargada de contener la configuracion de los tipos de datos soportados
        var tipo = '<select name="tipos[]" class="requerido form-control" id="tipos" required>';
        tipo += '<option value="0"><-Seleccione-></option>';
        tipo += '<option value="int">Integer</option>';
        tipo += '<option value="varchar">Varchar</option>';
        tipo += '<option value="text">text</option>';
        tipo += '<option value="intbig">Intbig</option>';
        tipo += '<option value="bit">boolean</option>';
        tipo += '<option value="date">date</option>';
        tipo += '<option value="datetime">datetime</option>';
        tipo += '</select>';
        tipo += '<input id="item" name="varcharValor[]" type="text" size="2" maxlength="3" style="position:absolute;margin-top:-30px; z-index: 100; display: none;float: left"/>';

        // Variable encargada de contener los index de las variables
        var index = '<select name="index[]" class="form-control" id="index">';
        index += '<option value="0"><-Seleccione-></option>';
        index += '<option value="PRIMARY KEY">PRIMARY KEY</option>';
        index += '<option value="UNIQUE">UNIQUE</option>';
        //index += '<option value="FOREIGN KEY">FOREIGN KEY</option>';
        index += '</select>';

        // Variable encargada de contener las funcionaes extras del selector
        var extra = '<select name="extra[]" class="form-control" id="extra">';
        extra += '<option value="0"><-Seleccione-></option>';
        extra += '<option value="AUTO INCREMENTO">AUTO INCREMENTO</option>';
        extra += '</select>';

        // Definicion del item que se va agregar nueva
        Config.html = '<tr>';
        Config.html += '    <td><input class="requerido form-control" name="campos[]" id="campos" placeholder="Nombre del campo" maxlength="60" size="20" pattern="^[a-z]([a-z_]){1,29}$" required></td>';
        Config.html += '    <td>'+tipo+'</td>';
        Config.html += '    <td><input name="default[]" class="requerido form-control" placeholder="Valor por default" id="default"></td>';
        Config.html += '    <td><select name="requerido[]" class="requerido form-control" id="requerido"><option value="NULL">SI</option><option value="NOT NULL">NO</option></select></td>';
        Config.html += '    <td>'+index+'</td>';
        Config.html += '    <td>'+extra+'</td>';
        var btn = '<i class="fa fa-arrows-v fa-2 cursor" aria-hidden="true" title="Mover Item" ></i><i class="fa fa-minus-circle fa-2 cursor btn" aria-hidden="true" id="delItem" title="eliminar item"></i>';
        Config.html += '    <td class="optionAction" id="moveItem">'+btn+'</td>';
        Config.html += '</tr>';

        // Imprime el html en el nuevo elemento creado en la tabla
        $('#box2 #camposEntidad').append(Config.html).show('slow');

        // Funcionalidad nueva cuando es primera vez
        if(opt=='PRI'){
            $('#campos').val('id');
            $('#tipos').val('int');
            $('#camposEntidad input, #camposEntidad select').attr({'readonly':'readonly'});
            $('#requerido').val('NOT NULL');
            $('#index').val('PRIMARY KEY');
            $('#extra').val('AUTO INCREMENTO');
        }
        Config.GestionaTablas.deleteRows();
        Config.GestionaTablas.optionForeingKey();
    },
    deleteRows:function () {
        $('#box2 #delItem').click(function(){
            $(this).parent('td').parent('tr').hide(900).remove();
        });
    },
    optionForeingKey: function(){
        $('#box2 #index').on('change',function () {
            var item = $(this).val();
            if(item =='FOREIGN KEY'){
                alert('kkk');
            }
        })
    },
    dragable: function () {
        $("tbody").sortable({
            items: "> tr:not(:first)",
            appendTo: "parent",
            helper: "clone"
        }).disableSelection();

        $("#tabs ul li a").droppable({
            hoverClass: "drophover",
            tolerance: "pointer",
            drop: function(e, ui) {
                var tabdiv = $(this).attr("href");
                $(tabdiv + " table tr:last").after("<tr>" + ui.draggable.html() + "</tr>");
                ui.draggable.remove();
            }
        });


    }
};
