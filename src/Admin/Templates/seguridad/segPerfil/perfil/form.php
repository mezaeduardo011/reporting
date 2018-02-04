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
<input type="text" name="detalle" class="form-control contar default requerido " id="detalle" placeholder="Enter detalle" maxlength="50" data-item="50">
</div>
  </div>
  <!-- /.box-body -->
   <div class="box-footer">
       <div class="col-sm-6 col-xs-12 pull-left" id="divDelete"></div>
       <div class="col-sm-6 col-xs-12 pull-right"><button id="submit" class="btn btn-primary" value="Procesar">Procesar registro.</button></div>
   </div>
</form>
</div>