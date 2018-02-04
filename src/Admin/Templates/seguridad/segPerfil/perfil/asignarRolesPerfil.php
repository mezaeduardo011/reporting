<?php
$breadcrumb=(object)array('actual'=>'Perfil','titulo'=>'Vista de integrada de gestion de Perfil','ruta'=>'Perfil')?>
<?php $this->layout('base',['usuario'=>$usuario,'breadcrumb'=>$breadcrumb])?>

<?php $this->push('title') ?>
 Gestionar de la vista Perfil
<?php $this->end()?>
<div class="row">
<!-- left column -->
    <div class="col-md-3">
        <!-- general form elements -->
        <?php $this->insert('view::seguridad/segPerfil/perfil/listado') ?>
    </div>
    <div class="col-md-6">
        <!-- general form elements -->
        <?php $this->insert('view::seguridad/segPerfil/perfil/listadoRoles') ?>
    </div>
    <div class="col-md-3">
       <?php $this->insert('view::seguridad/segPerfil/perfil/formAsociarRoles') ?>
    </div>
<?php $this->push('addJs') ?>

<script>
    // Variable de configuracion
    var Config = {};
    // Columnas para el dataTable de Perfile
    // Columnas para el grilla
    Config.colums = [
        { "id": "detalle", "type":"ed", "align":"left", "sort":"str" , "value":"Detalles" },
    ];
    // Configuracion de visualizacion del grilla
    Config.show = {
        'module':'Perfil',
        'tableTitle':'Listado de Perfiles.',
        'filter':'#text_filter',
        'autoWidth': false,
        'multiSelect': false
    }
    // Configuración personalizada del entorno privado de la vista
    Core.Vista.Util = {
        asociado: [],
        myGrid2:'',
        priListaLoad: function () {
            /* CARGAR SEGUNDA GRILLA */
            var Config = {};
            // Columnas para el grilla
            Config.colums = [
                { "id": "detalle", "type":"ed", "align":"left", "sort":"str" , "value":"Detalles" }
            ];
            // Configuracion de visualizacion del grilla
            Config.show = {
                'module':'Roles',
                'filter':'#text_filter',
                'autoWidth': true,
                'multiSelect': true
            };

            /* START DE GRILLA DHTML */
            var camp = '';
            /* Procedemos a crear una cadena de texto paa enviar al procesador de la vista para enviar lo datos en json*/
            $.each(Config.colums, function (index,value) {
                camp+='id:'+value.id+'|type:'+value.type+'|align:'+value.align+'|sort:'+value.sort+'|value:'+value.value+'#';
            });
            // Quitamos el ultimo caracter de la cadena
            var tmp = camp.substring(0,camp.length-1);

            Core.Vista.myGrid2 = new dhtmlXGridObject('dataJPHRoles');
            //myLayout.cells("a").setText(Config.show.tableTitle);


            //var myGrid = myLayout.cells("a").attachGrid();
            Core.Vista.myGrid2.setImagePath("/admin/dhtmlxSuite/codebase/imgs/");
            // Filtro de la tabla
            Core.Vista.myGrid2.attachHeader( Config.show.filter);
            // Campos id Mostrar
            //myGrid.setColumnIds("col1,col2,col3");

            //myGrid.enablePaging(true, 10, 3, "pagingArea");
            Core.Vista.myGrid2.enablePaging(true,10,5,'pagingArea'+Config.show.module,true,"recinfoArea");

            Core.Vista.myGrid2.setPagingSkin("toolbar");
            Core.Vista.myGrid2.enableAutoWidth(true);
            Core.Vista.myGrid2.enableMultiselect(true);

            Core.Vista.myGrid2.attachEvent("onRowSelect", this.localOnRowSelected);
            Core.Vista.myGrid2.init();
            //Core.Vista.myGrid2.enableSmartRendering(true);
            // Evniamos los parametros de configuracion
            var gridQString = '/'+ Config.show.module.toLowerCase()+'Listar?obj='+window.btoa(tmp); // save query string to global variable (see step 5)
            Core.Vista.myGrid2.load(gridQString, 'json');

            /* END  */
            //Core.Vista = {};
            //Core.Vista.main('Roles',Config);

           /* localStorage.setItem('rolesId',0);
            // Funcionalidad privada del listaLoad
            var asoc = this.asociado;
            var onTabla = this.onTable;
            $('#dataJPHRoles tbody').on( 'click', 'tr', function () {
                var data = onTabla.row($(this)).data();
                if($(this).hasClass('selected')){
                    $(this).removeClass('selected');
                    var index = asoc    .indexOf(data.id);
                    asoc.splice(index, 1);
                }else{
                    $(this).addClass('selected');
                    asoc.push(data.id);
                }

            } );*/
            this.priClickProcesarForm();
        },
        localOnRowSelected: function(item) {
           // Core.Vista.myGrid2.
            var asoc = Core.Vista.Util.asociado;
            asoc.push(item);
            Core.Vista.Util.displayRoles(asoc.length);

        },
        priListaClick: function(dataJson) {
            // Funcionalidad adicional cuando haces click en el datatable principal
            var asoc = this.asociado;
            //var onTabla = this.onTable;
            var item = Core.Vista.myGrid2;
            localStorage.setItem('rolesId',dataJson.datos.id)
            //$.each(item, function (item, rows) {
            // Valores de datos que tienen seleccion
                $.each(dataJson.roles, function (key, valor) {

                    // Valores disponible
                    var rows = item.getAllItemIds().split(',');
                    //alert(rows[key]); Valor del item
                    if(valor.existe=='SI' && rows[key]==valor.id){
                        item.setSelectedRow(rows[key],'background-color:#293A4A;color: #ffffff');
                        //console.log(rows[key]);
                        asoc.push(rows[key]);
                    }else{
                        var index = asoc.indexOf(rows[key]);
                        asoc.splice(index, 1);
                        item.setSelectedRow(rows[key],'');
                    }

                });

            $('#displayRoles').html('').html('<span style="text-align:center;font-size: 18px">'+asoc.length+'  row(s) selected</span>');

            $('#dataJPHRoles').click( function () {
                //alert(asoc);
                //alert( onTabla.rows('.selected').data().length +' row(s) selected' );
                var cant=onTabla.rows('.selected').data().length
               this.displayRoles(cant);
            } );

        },
        displayRoles: function(cant) {
            var msj = cant +' row(s) selected';
            $('#displayRoles').html('').html('<span style="text-align:center;font-size: 18px">'+msj+'</span>');
        },
        priClickProcesarForm:function () {
            var asoc = this.asociado;

                $('#marcar').click(function (e) {
                    if(asoc.length>0 && localStorage.getItem('rolesId')>0) {
                        var campos = new FormData();
                        campos.append('seg_perfil_id', localStorage.getItem('rolesId'));
                        campos.append('seg_roles_id', asoc);
                        $.ajax({
                            url: '/setAsociarRolesPerfil',
                            type: "POST",
                            data: campos,
                            processData: false,  // tell jQuery not to process the data
                            contentType: false,   // tell jQuery not to set contentType
                            dataType: 'JSON',
                            success: function (dataJson) {
                                if (dataJson.error == 0) {
                                    alertar(dataJson.msj);
                                    setTimeout(location.reload(), 1000);
                                } else {
                                    mostrarError(dataJson.msj)
                                }
                            }
                        });
                    }else{
                        mostrarError('Uff!, Debe seleccionar un Perfil y luego seleccionar los roles que sean necesarios asociar al perfil.')
                    }
                    return false;
                })

        }
    };

    $(function () {
        Core.main();
        Core.Vista.main('Perfil',Config);
    })

</script>
<?php $this->end() ?> 
