<div class="box box-primary">
<div class="box-header with-border">
<h3 class="box-title">Formulario de socios</h3>
</div>
<!-- /.box-header -->
<!-- form start -->
<form role="form" method="post" id="sendSociosProcesar" enctype="multipart/form-data">
   <div class="box-body">
<input type="hidden" id="id" name="id">
<div class="form-group">
    <label for="tipo_documento">tipo_documento</label>
    <input type="text" name="tipo_documento" class="form-control contar int requerido" id="tipo_documento" placeholder="Por favor ingresar el/los tipo_documento"  maxlength="10" data-item="10">
    <i class="help" id="help-tipo_documento"></i>
</div>
<div class="form-group">
    <label for="documento">documento</label>
    <input type="text" name="documento" class="form-control contar varchar requerido" id="documento" placeholder="Por favor ingresar el/los documento"  maxlength="10" data-item="10">
    <i class="help" id="help-documento"></i>
</div>
<div class="form-group">
    <label for="nombres">nombres</label>
    <input type="text" name="nombres" class="form-control contar varchar requerido" id="nombres" placeholder="Por favor ingresar el/los nombres"  maxlength="60" data-item="60">
    <i class="help" id="help-nombres"></i>
</div>
<div class="form-group">
    <label for="apellidos">apellidos</label>
    <input type="text" name="apellidos" class="form-control contar varchar requerido" id="apellidos" placeholder="Por favor ingresar el/los apellidos"  maxlength="60" data-item="60">
    <i class="help" id="help-apellidos"></i>
</div>
<div class="form-group">
    <label for="Nacimiento">Nacimiento</label>
    <input type="text" name="fecha_nacimiento" class="form-control contar date requerido" id="fecha_nacimiento" placeholder="Por favor ingresar el/los fecha_nacimiento"  maxlength="11" data-item="11">
    <i class="help" id="help-fecha_nacimiento"></i>
</div>
<div class="form-group">
    <label for="created_usuario_id">created_usuario_id</label>
    <input type="text" name="created_usuario_id" class="form-control contar int requerido" id="created_usuario_id" placeholder="Por favor ingresar el/los created_usuario_id"  maxlength="10" data-item="10">
    <i class="help" id="help-created_usuario_id"></i>
</div>
<div class="form-group">
    <label for="updated_usuario_id">updated_usuario_id</label>
    <input type="text" name="updated_usuario_id" class="form-control contar int" id="updated_usuario_id" placeholder="Por favor ingresar el/los updated_usuario_id"  maxlength="10" data-item="10">
    <i class="help" id="help-updated_usuario_id"></i>
</div>
  </div>
  <!-- /.box-body -->
   <div class="box-footer">
       <div class="col-md-4 col-sm-6 col-xs-12 pull-left" id="divDelete"></div>
       <div class="col-md-4 col-sm-6 col-xs-12 pull-right"><button id="submit" class="btn btn-primary" value="Procesar">Procesar registro.</button></div>
   </div>
</form>
</div>
