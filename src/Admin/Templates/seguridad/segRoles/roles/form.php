<div class="box box-primary">
<div class="box-header with-border">
<h3 class="box-title">Formulario de roles</h3>
</div>
<!-- /.box-header -->
<!-- form start -->
<form role="form" method="post" id="sendRolesProcesar" enctype="multipart/form-data">
   <div class="box-body">
    <input type="hidden" id="id" name="id">
       <div class="row">
           <!-- left column -->
           <div class="col-md-7">
                <div class="form-group">
                    <label for="detalle">detalle</label>
                    <input type="text" name="detalle" class="form-control default contar requerido " id="detalle" placeholder="Enter detalle" maxlength="100" data-item="100">
                </div>
           </div>
           <!-- rigth column -->
           <div class="col-md-5">
               <div class="form-group">
                   <label for="detalle">Permisos</label>
                   <select name="permisos" id="permisos" class="form-control default requerido ">
                       <option value="CONTROL TOTAL">CONTROL TOTAL</option>
                       <option value="CONSULTAS">CONSULTAS</option>
                       <option value="ALTA">ALTA</option>
                       <option value="BAJA">BAJA</option>
                       <option value="MODIFICACION">MODIFICACION</option>
                   </select>
               </div>
           </div>
       </div>
  </div>
  <!-- /.box-body -->
   <div class="box-footer">
       <div class="col-md-4 col-sm-6 col-xs-12 pull-left" id="divDelete"></div>
       <div class="col-md-4 col-sm-6 col-xs-12 pull-right"><button id="submit" class="btn btn-primary" value="Procesar">Procesar registro.</button></div>
   </div>
</form>
</div>
