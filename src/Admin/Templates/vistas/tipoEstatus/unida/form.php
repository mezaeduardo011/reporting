<div class="box box-primary">
<div class="box-header with-border">
<h3 class="box-title">Formulario de unida</h3>
</div>
<!-- /.box-header -->
<!-- form start -->
<form role="form" method="post" id="sendUnidaProcesar" enctype="multipart/form-data">
   <div class="box-body">
<input type="hidden" id="id" name="id">
<div class="form-group">
    <label for="nombre">nombre</label>
    <input type="text" name="nombre" class="form-control contar letraSpacio requerido" id="nombre" placeholder="Por favor ingresar el/los nombre"  maxlength="30" data-item="30">
    <i class="help" id="help-nombre"></i>
</div>
<div class="form-group">
    <label for="color">color</label>
    <input type="text" name="color" class="form-control contar color requerido" id="color" placeholder="Por favor ingresar el/los color" value="#000" maxlength="7" data-item="7">
    <i class="help" id="help-color"></i>
</div>
  </div>
  <!-- /.box-body -->
   <div class="box-footer">
       <div class="col-md-4 col-sm-6 col-xs-12 pull-left" id="divDelete"></div>
       <div class="col-md-4 col-sm-6 col-xs-12 pull-right"><button id="submit" class="btn btn-primary" value="Procesar">Procesar registro.</button></div>
   </div>
</form>
</div>
