<?php
$breadcrumb=(object)array('actual'=>'Gggg','titulo'=>'Vista de integrada de gestion de Gggg','ruta'=>'Gggg')?>
<?php $this->layout('base',['usuario'=>$usuario,'breadcrumb'=>$breadcrumb])?>
<?php $this->push('addCss')?>
<?php $this->end()?>
<?php $this->push('title') ?>
 Gestionar de la vista Gggg
<?php $this->end()?>
<div class="row">
    <!-- left column -->
    <div class="col-md-7">
        <!-- general form elements -->
        <?php $this->insert('view::vistas/prueba/gggg/listado') ?>
    </div>
        <div class="col-md-5">
        <?php $this->insert('view::vistas/prueba/gggg/form') ?>
    </div>
</div>
<?php $this->push('addJs') ?>
<script>
    // Definicion los campos del DataTable de esta vista
    var Config = {};
    <?php $this->insert('view::vistas/prueba/gggg/assent') ?>
    Core.Vista.Util = {}
    Core.Vista.Util = {
        priListaLoad: function (){ 
        },
        priListaClick: function (dataJson){
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
