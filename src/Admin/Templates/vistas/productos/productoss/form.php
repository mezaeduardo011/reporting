<div class="box box-primary">
<div class="box-header with-border">
<h3 class="box-title">Formulario de productoss</h3>
</div>
<!-- /.box-header -->
<!-- form start -->
<form role="form" method="post" id="sendProductossProcesar" enctype="multipart/form-data">
   <div class="box-body">
<input type="hidden" id="id" name="id">
<div class="form-group">
    <label for="tipo_servicio_id">tipo_servicio_id</label>
    <select  name="tipo_servicio_id" class="form-control int requerido tipo_estatus--estatus--id " id="tipo_servicio_id"  placeholder="Por favor ingresar el/los tipo_servicio_id"><option value="0">Seleccionar</option></select>
</div>
<div class="form-group">
    <label for="descripcion">descripcion</label>
    <input type="text" name="descripcion" class="form-control contar letraSpacio requerido" id="descripcion" placeholder="Por favor ingresar el/los descripcion"  maxlength="100" data-item="100">
    <i class="help" id="help-descripcion"></i>
</div>
<div class="form-group">
    <label for="codigo">codigo</label>
    <input type="text" name="codigo" class="form-control contar letraSpacio requerido" id="codigo" placeholder="Por favor ingresar el/los codigo"  maxlength="10" data-item="10">
    <i class="help" id="help-codigo"></i>
</div>
<div class="form-group">
    <label for="productos_id">productos_id</label>
    <select  name="productos_id" class="form-control int productos--productoss--id " id="productos_id"  placeholder="Por favor ingresar el/los productos_id"><option value="0">Seleccionar</option></select>
</div>
  </div>
  <!-- /.box-body -->
   <div class="box-footer">
       <div class="col-md-4 col-sm-6 col-xs-12 pull-left" id="divDelete"></div>
       <div class="col-md-4 col-sm-6 col-xs-12 pull-right"><button id="submit" class="btn btn-primary" value="Procesar">Procesar registro.</button></div>
   </div>
</form>
</div>
