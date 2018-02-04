<?php
$breadcrumb=(object)array('actual'=>'Perfil','titulo'=>'Vista de integrada de gestion de Perfil','ruta'=>'Perfil')?>
<?php $this->layout('base',['usuario'=>$usuario,'breadcrumb'=>$breadcrumb])?>

<?php $this->push('title') ?>
 Gestionar de la vista Perfil
<?php $this->end()?>
<div class="row">
<!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <?php $this->insert('view::seguridad/segPerfil/perfil/listado') ?>
    </div>
    <div class="col-md-6">
       <?php $this->insert('view::seguridad/segPerfil/perfil/form') ?>
    </div>
<?php $this->push('addJs') ?>

<script>
    // Variable de configuracion
    var Config = {};

    // Columnas para el grilla
    Config.colums = [
        { "id": "detalle", "type":"ed", "align":"left", "sort":"str" , "value":"Detalles" },
    ];
    // Configuracion de visualizacion del grilla
    Config.show = {
        'module':'Perfil',
        'filter':'#text_filter'
    }
    // Configuración personalizada del entorno privado de la vista
    Core.Vista.Util = {
        priListaLoad: function () {
        // Funcionalidad privada del listaLoad

        },
        priListaClick: function (dataJson) {
        // Funcionalidad adicional cuando haces click en el datatable principal

        },
        priClickProcesarForm:function () {

        }
    };

    $(function () {
        Core.main();
        Core.Vista.main('Perfil',Config);
    })

</script>
<?php $this->end() ?> 
