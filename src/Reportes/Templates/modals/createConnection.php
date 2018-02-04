
<!-- CSS Extends-->
<?=$this->section('addCss')?>
<form action="/action_page.php" style="text-align: center">
  <h3 >Datos de la conexión</h3>
  <div class="form-group">
    <select class="form-control" style="width: 50%;margin-left: 25%;text-indent: 30%;" id="driver">
      <option value="sql">SQLSERVER</option>
      <option value="MYSQL">MYSQL</option>
    </select>
  </div> 
  <hr>  
  <div class="form-group">
    <label for="host">host:port</label>
    <input type="text" class="form-control" id="host">
  </div>

    <div class="form-group">
        <label for="database">Base de datos:</label>
        <input type="text" class="form-control" id="database">
    </div>

    <h3 style="text-align: center">Credenciales</h3>
  <div class="form-group">
    <label for="user">Usuario:</label>
    <input type="text" class="form-control" id="user">
  </div>
  <div class="form-group">
    <label for="password">Contraseña:</label>
    <input type="text" class="form-control" id="password">
  </div>
</form>