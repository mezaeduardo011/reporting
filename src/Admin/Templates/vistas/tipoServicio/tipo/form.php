<div class="box box-primary">
<div class="box-header with-border">
<h3 class="box-title">Formulario de tipo</h3>
</div>
<!-- /.box-header -->
<!-- form start -->
<form role="form" method="post" id="sendTipoProcesar" enctype="multipart/form-data">
   <div class="box-body">
<input type="hidden" id="id" name="id">
<div class="form-group">
    <label for="descripcion">descripcion</label>
    <input type="text" name="descripcion" class="form-control contar letraSpacio requerido" id="descripcion" placeholder="Por favor ingresar el/los descripcion"  maxlength="100" data-item="100">
    <i class="help" id="help-descripcion"></i>
</div>
  </div>
  <!-- /.box-body -->
   <div class="box-footer">
       <div class="col-md-4 col-sm-6 col-xs-12 pull-left" id="divDelete"></div>
       <div class="col-md-4 col-sm-6 col-xs-12 pull-right"><button id="submit" class="btn btn-primary" value="Procesar">Procesar registro.</button></div>
   </div>
</form>
</div>
