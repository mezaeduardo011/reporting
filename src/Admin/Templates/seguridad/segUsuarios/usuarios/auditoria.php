    <?php
$breadcrumb=(object)array('actual'=>'Usuarios','titulo'=>'Vista de integrada de gestion de Usuarios','ruta'=>'Usuarios')?>
<?php $this->layout('base',['usuario'=>$usuario,'breadcrumb'=>$breadcrumb])?>
<?php $this->push('addCss')?>

<?php $this->end()?>
<?php $this->push('title') ?>
 Gestionar de la vista Usuarios
<?php $this->end()?>

<div class="row">
<!-- left column -->
    <div class="col-md-4">
        <?php $this->insert('view::seguridad/segUsuarios/usuarios/showUsuario') ?>
    </div>
    <div class="col-md-8">
        <?php $this->insert('view::seguridad/segUsuarios/usuarios/logSession') ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php $this->insert('view::seguridad/segUsuarios/usuarios/logAcciones') ?>
    </div>
</div>
<?php $this->push('addJs') ?>
<script>
    Core.Menu.main();
    var userId=sessionStorage.getItem('usuarioId');
    //alert(userId);
    if(userId.length<2){
        window.location.href = '/usuariosIndex';
    }

    // Variable de configuracion
    var Config = {};
    // Columnas para el grilla
    Config.colums1 = [
        { "id":"host", "type":"ed", "align":"center", "sort":"str" , "value":"Host"},
        { "id":"navegador", "type":"ed", "align":"center", "sort":"str" , "value":"Navegador"},
        { "id":"accion", "type":"ed", "align":"center", "sort":"str" , "value":"Accion"},
        { "id":"created_at", "type":"ed", "align":"center", "sort":"str" , "value":"Fecha"},
    ];


    /* START DE GRILLA DHTML */
    var camp1 = '';
    var myGrid1
    /* Procedemos a crear una cadena de texto paa enviar al procesador de la vista para enviar lo datos en json*/
    $.each(Config.colums1, function (index,value) {
        camp1+='id:'+value.id+'|type:'+value.type+'|align:'+value.align+'|sort:'+value.sort+'|value:'+value.value+'#';
    });
    // Quitamos el ultimo caracter de la cadena
    var tmp1 = camp1.substring(0,camp1.length-1);

    myGrid1 = new dhtmlXGridObject('dataJPHUsuariosLogSession');
    myGrid1.setImagePath("/admin/dhtmlxSuite/codebase/imgs/");
    myGrid1.attachHeader('#combo_filter,#combo_filter,#combo_filter,#text_filter');
    myGrid1.enablePaging(true,15,5,"pagingAreaUsuariosLogSession",true);
    myGrid1.setPagingSkin("bricks");
    myGrid1.enableAutoWidth(true);
    myGrid1.enableMultiselect(true);
    myGrid1.init();
    setInterval(function(){
        var gridQString1 = '/usuariosSegLogLogin?token='+userId+'&obj='+window.btoa(tmp1); // save query string to global variable (see step 5)
        myGrid1.load(gridQString1, 'json');
    }, 3000);


    // Variable de configuracion
    var Config = {};
    // Columnas para el grilla
    Config.colums2 = [
        { "id":"proceso", "type":"ed", "align":"center", "sort":"str" , "value":"Accion"},
        { "id":"entidad", "type":"ed", "align":"center", "sort":"str" , "value":"Entidad"},
        { "id":"host", "type":"ed", "align":"center", "sort":"str" , "value":"Host"},
        { "id":"created_at", "type":"ed", "align":"center", "sort":"str" , "value":"Fecha"},
    ];

    /* START DE GRILLA DHTML */
    var camp2 = '';
    var myGrid2
    /* Procedemos a crear una cadena de texto paa enviar al procesador de la vista para enviar lo datos en json*/
    $.each(Config.colums2, function (index,value) {
        camp2+='id:'+value.id+'|type:'+value.type+'|align:'+value.align+'|sort:'+value.sort+'|value:'+value.value+'#';
    });
    // Quitamos el ultimo caracter de la cadena
    var tmp2 = camp2.substring(0,camp2.length-1);

    myGrid2 = new dhtmlXGridObject('dataJPHUsuariosAcciones');
    myGrid2.setImagePath("/admin/dhtmlxSuite/codebase/imgs/");
    myGrid2.attachHeader('#combo_filter,#combo_filter,#combo_filter,#text_filter');
    myGrid2.enablePaging(true,15,5,"pagingAreaUsuariosAcciones",true);
    myGrid2.setPagingSkin("bricks");
    myGrid2.attachEvent("onRowSelect", doOnRowSelected);
    myGrid2.enableAutoWidth(true);
    myGrid2.enableMultiselect(true);
    myGrid2.init();

    setInterval(function(){
        var gridQString2 = '/usuariosShowAcciones?token='+userId+'&obj='+window.btoa(tmp2); // save query string to global variable (see step 5)
        myGrid2.load(gridQString2, 'json');
    }, 3000);

    function doOnRowSelected(item) {
        $.post('showAccionesAuditoria',{'item':item},function(dataJson){
            $('#myModalLabel').html('Vista del registro de auditoría');
            var html = '<table class="table table-bordered">';
            $.each(dataJson.datos,function (index,value) {

                if(index=='id' || index=='usuario_id'){return}
                if(index=='new_value' && value==''){return}
                if(index=='old_value' && value==''){return}

            html += '<tr>';
                html += '    <td>'+index+'</td>';
                valor = value;
                if((index=='old_value' && value.length>1) || (index=='new_value' && value.length>1) ){
                    valor = '<table>';
                    $.each(JSON.parse(value),function (index2,value2) {
                        valor += '<tr>';
                        valor += '<td>'+index2+'</td>';
                        valor += '<td>'+value2+'</td>';
                        valor += '</tr>';
                    })
                    valor += '</table>'
                }
                html += '    <td>'+valor+'</td>';
                html += '</tr>';
            })
            html += '</table>';
            $('#modalBody').html(html);
            $('.modal-footer').remove();
            $('.modal modal-dialog').addClass('modal-lg')
            $('.modal').modal('show')
        })
    }

    $(function () {
        Core.VistaAuditoria.main();
    })
</script>
<?php $this->end() ?>
