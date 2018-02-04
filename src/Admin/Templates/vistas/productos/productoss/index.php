<?php
$breadcrumb=(object)array('actual'=>'Productoss','titulo'=>'Vista de integrada de gestion de Productoss','ruta'=>'Productoss')?>
<?php $this->layout('base',['usuario'=>$usuario,'breadcrumb'=>$breadcrumb])?>
<?php $this->push('addCss')?>
<?php $this->end()?>
<?php $this->push('title') ?>
 Gestionar de la vista Productoss
<?php $this->end()?>
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
    <?php $this->insert('view::vistas/productos/productoss/assent') ?>
    Core.Vista.Util = {}
    Core.Vista.Util = {
        priListaLoad: function (){ 
            // Configurar de los campos tipo_estatus--estatus--id ';
            var html1 = '<option>Seleccionar</option>';
            $.post("/getEntidadComun",{"tipo":"combo","tabla_vista":"tipo_estatus--estatus--id","vista_campo":"color|nombre","cart_separacion":"-"},function(dataJson){
                $.each(dataJson.datos,function(key,value){
                html1 += '<option value="'+value.id+'">'+value.nombre+'</option>;'
                });
                $(".tipo_estatus--estatus--id").html(html1)
            });
            // Configurar de los campos productos--productoss--id ';
            var html4 = '<option>Seleccionar</option>';
            $.post("/getEntidadComun",{"tipo":"combo","tabla_vista":"productos--productoss--id","vista_campo":"descripcion","cart_separacion":" "},function(dataJson){
                $.each(dataJson.datos,function(key,value){
                html4 += '<option value="'+value.id+'">'+value.nombre+'</option>;'
                });
                $(".productos--productoss--id").html(html4)
            });
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
