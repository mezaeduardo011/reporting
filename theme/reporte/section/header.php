  <header class="main-header">


    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <div class="col-md-12" style="color: #FFF;padding-top: 1%">
        <ul class="list-inline col-md-3" style="padding-top: 0.3%">
            <li class="active" onclick="createConnection()"><i class="fa fa-bolt fa-lg" aria-hidden="true"></i></li>
            <li class="active" >
              <select class="selectpicker" id="listConnections" style="color:black" onchange="useConnection(this)">
                <option>Sin Conexión</option>
              </select>
            </li>
            <li class="active" onclick="showTables()"><i class="fa fa-database fa-lg" aria-hidden="true"></i></li>
        </ul>
        <ul class="list-inline  col-md-8 col-md-pull-1 desabledHighl">
            <li class="active"><i class="fa fa-reply fa-lg" aria-hidden="true"></i></li>
            <li class="active"><i class="fa fa-share fa-lg" aria-hidden="true"></i></li>          
            <li><i class="fa fa-floppy-o fa-lg" aria-hidden="true" onclick="saveXml(this)"></i></li>
            <li class="buttonTab active"><i class="fa fa-file-image-o fa-lg" aria-hidden="true"></i></li>
            <li class="buttonTab"><i class="fa fa-file-code-o fa-lg" aria-hidden="true"></i></li>
            <li class="buttonTab"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></li>
            <li class="active"><i class="fa fa-search-plus fa-lg" aria-hidden="true" onclick="zoomIn(this)"></i></li>
            <li class="active"><i class="fa fa-search-minus fa-lg" aria-hidden="true" onclick="zoomOut(this)"></i></li>
            <li class="" style="color:black">
              <select class="selectpicker"> 
                <option>SansSerif</option>
                <option>Serif</option>
              </select>
            </li>
            <li class="">
              <select class="selectpicker" style="color:black"> 
                <option>10</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </li>
            <li class="">
              <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
              A
            </li> 
            <li class="">
              <i class="fa fa-minus-circle fa-lg" aria-hidden="true"></i>
              a
            </li> 
            <li class="" style="font-weight: bold;">
              b
            </li>
            <li class="" style="font-weight: italic;">
              i
            </li>
            <li class="" style="text-decoration-line: underline;">
              u
            </li> 
            <li class="" style="text-decoration-line: underline;">
              <i class="fa fa-align-left fa-lg" aria-hidden="true"></i>
            </li>
            <li class="" style="text-decoration-line: underline;">
              <i class="fa fa-align-justify fa-lg" aria-hidden="true"></i>
            </li> 
            <li class="" style="text-decoration-line: underline;">
              <i class="fa fa-align-center fa-lg" aria-hidden="true"></i>
            </li>    
            <li class="" style="text-decoration-line: underline;">
              <i class="fa fa-align-right fa-lg" aria-hidden="true"></i>
            </li>                                     
        </ul>
      </div>
    </nav>
  </header>

  <script>
      function getTables()
      {
          $.get( "/reportes.php/getTables",function( response ) {
              console.log(response);
          });
      }
  </script>