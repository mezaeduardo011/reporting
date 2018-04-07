<style>

</style>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="overflow-y: auto;height: 700px;overflow-x: hidden;">
        <!-- Sidebar user panel -->

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">

            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Inspector De Elementos</li>
            <li class="active treeview " >
                <a href="#" class="optElement" data-ul="ulStyle">
                    <i class="fa fa-dashboard"></i>Estilos <span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded ulStyle">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#" class="optElement" data-ul="ulParameters">
                    <i class="fa fa-dashboard"></i>Parametros <span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded ulParameters">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Campos <span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" ></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded" id="ulCampos">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Variables <span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Título <span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu " id="ulTitle">
                    <!--             <li><a href="../examples/invoice.html"><i class="fa fa-circle-o"></i> Caja</a></li>
                                <li><a href="../examples/profile.html"><i class="fa fa-circle-o"></i> Caja2</a></li> -->
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Encabezado De Página<span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Encabezado De Columna <span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Detalle<span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Pie De Columna<span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Último Pie De Página<span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Resumen <span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Sin Datos <span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded">
                </ul>
            </li>
            <li class="active treeview ">
                <a href="#">
                    <i class="fa fa-dashboard"></i>Fondo <span></span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu elementsAdded">
                </ul>
            </li>

            <li class="header">------------------------------------------------------</li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark control-sidebar-open">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab"  data-toggle="tab">Elementos del reporte</a></li>
        <!--  <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li> -->
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <div class="panelElements">
                <ul class="control-sidebar-menu">


                    <li>
                        <a href="javascript:void(0)" data-id='4,11' data-element='Caja' data-nameTag = 'frame' data-xml='<frame><reportElement x="15" y="40" width="100" height="20"/></frame>' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='11' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Caja</h5>
                            </div>
                        </a>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Html</h5>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-id=15 data-element='Texto Estático' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='15' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Texto Estático</h5>
                            </div>
                        </a>

                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Separacion</h5>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Campo De Texto</h5>
                            </div>
                        </a>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Gráfico</h5>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Tabla Cruzada</h5>
                            </div>
                        </a>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Elipse</h5>
                            </div>
                        </a>
                    </li>


                    <li>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Imagen</h5>
                            </div>
                        </a>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Código De  Barra</h5>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Elemento Genérico</h5>
                            </div>
                        </a>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Lista</h5>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Línea</h5>
                            </div>
                        </a>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Rectángulo</h5>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Rectángulo Redondo</h5>
                            </div>
                        </a>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Ordenar</h5>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Texto Estático</h5>
                            </div>
                        </a>

                        <a href="javascript:void(0)" data-id=12 data-element='box' draggable="true" ondragstart="Report.EventsDragDrop.drag(event)" id='12' class="elementPanel disabled eventFrame col-md-6">
                            <i class="menu-icon fa fa-cubes  bg-red"></i>
                            <div class="menu-info">
                                <h5 class="control-sidebar-subheading">Separacion</h5>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="propertiesElements">
                <div class="containerProperties">
                </div>
                <div class="containerPropertiesEspecific">
                </div>
            </div>

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Some information about this general settings option
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Other sets of options are available
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Allow the user to show his name in blog posts
                    </p>
                </div>
                <!-- /.form-group -->

                <h3 class="control-sidebar-heading">Chat Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                    </label>
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>