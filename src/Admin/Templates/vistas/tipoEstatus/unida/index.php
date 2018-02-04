<?php
$breadcrumb=(object)array('actual'=>'Unida','titulo'=>'Vista de integrada de gestion de Unida','ruta'=>'Unida')?>
<?php $this->layout('base',['usuario'=>$usuario,'breadcrumb'=>$breadcrumb])?>
<?php $this->push('addCss')?>
<?php $this->end()?>
<?php $this->push('title') ?>
 Gestionar de la vista Unida
<?php $this->end()?>
<div class="row">
    <!-- left column -->
    <div class="col-md-7">
        <!-- general form elements -->
        <?php $this->insert('view::vistas/tipoEstatus/unida/listado') ?>
    </div>
        <div class="col-md-5">
        <?php $this->insert('view::vistas/tipoEstatus/unida/form') ?>
    </div>
</div>
<!-- Incluir las de la vista de navegacion de ### (productos--productoss--id) ### -->
<div class="row">
    <!-- left column -->
    <div class="col-md-7">
        <!-- general form elements -->
        <?php $this->insert('view::vistas/productos/productoss/listado') ?>
    </div>
        <div class="col-md-5">
        <?php $this->insert('view::vistas/productos/productoss/form') ?>
    </div>
</div>
<?php $this->push('addJs') ?>
<script>
    // Definicion los campos del DataTable de esta vista
    var Config = {};
    <?php $this->insert('view::vistas/tipoEstatus/unida/assent') ?>
    Core.Vista.Util = {}
    Core.Vista.Util = {
        priListaLoad: function (){ 
        },
        priListaClick: function (dataJson){
           <?php $this->insert('view::vistas/productos/productoss/assent') ?>
            Config.relacionPadre = {
                "field":'id',
                "value": 'tipo_servicio_id',
                "id": dataJson.datos.id
            };
            Core.VistaRelacion.main('Productoss',Config);
        }, 
        priClickProcesarForm: function(){ }, 
        validateMascaras: function () {
            var item = true;
            $.each(Core.Vista.Mascara,function (keys, values) {
            var expreg = new RegExp(values.mascara);
            var campo = $('[name="'+values.campo+'"], #'+values.campo).val();
            if(!expreg.test(campo)) {
                alertar(values.mensaje,'Validación del campo '+values.campo);
                $('[name="'+values.campo+'"], #'+values.campo).focus();
                $('i#help-'+values.campo).html(values.mensaje);
                    item = false;
                }
            });
            return item;
        }
    };
    $(function () {
        Core.main();
        Core.Vista.main(Config.show.module,Config);
    })

</script>
<?php $this->end() ?> 
