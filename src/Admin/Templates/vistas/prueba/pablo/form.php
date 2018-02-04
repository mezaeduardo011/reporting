<div class="box box-primary">
<div class="box-header with-border">
<h3 class="box-title">Formulario de pablo</h3>
</div>
<!-- /.box-header -->
<!-- form start -->
<form role="form" method="post" id="sendPabloProcesar" enctype="multipart/form-data">
   <div class="box-body">
<input type="hidden" id="id" name="id">
<div class="form-group">
    <label for="apellido">apellido</label>
    <input type="text" name="apellido" class="form-control contar correo requerido" id="apellido" placeholder="Por favor ingresar el/los apellido"  maxlength="50" data-item="50">
    <i class="help" id="help-apellido"></i>
</div>
<div class="form-group">
    <label for="nombre">nombre</label>
    <input type="text" name="nombre" class="form-control contar ipv4 requerido" id="nombre" placeholder="Por favor ingresar el/los nombre" value="hugo" maxlength="50" data-item="50">
    <i class="help" id="help-nombre"></i>
</div>
  </div>
  <!-- /.box-body -->
   <div class="box-footer">
       <div class="col-md-4 col-sm-6 col-xs-12 pull-left" id="divDelete"></div>
       <div class="col-md-4 col-sm-6 col-xs-12 pull-right"><button id="submit" class="btn btn-primary" value="Procesar">Procesar registro.</button></div>
   </div>
</form>
</div>
