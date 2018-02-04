<div class="box box-primary">
<div class="box-header with-border">
<h3 class="box-title">Formulario de perfil</h3>
</div>
<!-- /.box-header -->
<!-- form start -->
<form role="form" method="post" id="sendPerfilProcesar" enctype="multipart/form-data">
   <div class="box-body">
        <input type="hidden" id="id" name="id">
        <div class="form-group">
            <label for="detalle">detalle</label>
            <input type="text" name="detalle" class="form-control default" id="detalle" placeholder="Seleccione un Perfil" style="border: none; text-align:center; font-size: 20px ">
        </div>
    </div>
</form>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Listado de Perfiles asociados</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="post" id="asociarRoles" enctype="multipart/form-data">
        <div class="box-body text-center" id="displayRoles">

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-sm-6 col-xs-12 pull-right"><button id="marcar" class="btn btn-primary" value="Procesar">Asociar Roles.</button></div>
        </div>
    </form>
</div>