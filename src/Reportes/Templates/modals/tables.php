
<!-- CSS Extends-->
<?=$this->section('addCss')?>
    <div class="col-md-12">
        <div class="box box-solid">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="box-group" id="accordion">
                    <!-- Cada <div class="panel box box-primary"> es un accordion-->
                    <!-- Primer foreach recorre las tablas -->
                    <?php if($data): ?>
                        <?php foreach ($data as $t): ?>

                        <div class="panel box box-primary">
                            <div class="box-header with-border" style="text-align: center">
                                <h4 class="box-title">
                                    <!-- Se muestra nombre de la tabla-->
                                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $t['table']; ?>">
                                        <?php echo $t['table']; ?>
                                    </a>
                                </h4>
                            </div>

                            <div id="<?php echo $t['table']; ?>" class="panel-collapse collapse">
                                <div class="box-body">
                                    <!-- Segundo foreach recorre los campos -->
                                    <?php foreach ($t['fields'] as $f): ?>
                                        <!-- Se muestran los campos-->
                                        <!-- Aca se asignan valores para poder identificar cada div.-->
                                        <!-- $fieldSelected: Campos que estan seleccionados -->
                                        <!-- field: Campo -->
                                        <!-- idField: identificador del campo generado en el controlador-->
                                        <!-- statusSelected: estado del div para saber si esta seleccionado o no-->
                                        <!-- field+idField: valor para poder identificar los div en caso de que se repitan los nombres de los campos se usa idField para diferenciar.-->
                                        <!-- icon: Dependiendo del valor de statusSelected se muestra un icono u otro (check/minus).-->

                                        <?php $statusSelected = (array_search( $f['field'], $fieldSelected) != false)? 'fieldSelected':'unselected' ;?>
                                        <?php $statusSelected = (array_search( $f['idField'], $fieldSelected) != false && $statusSelected != 'unselected')? 'fieldSelected':'unselected' ;?>

                                        <?php $icon = ($statusSelected == 'fieldSelected')? 'fa fa-check-square':'fa fa-minus-square' ;?>

                                        <div class="col-md-3 col-sm-6 col-xs-12 <?php echo $statusSelected;?>" data-idField = "<?php echo $f['idField'];?>" data-field="<?php echo $f['field'];?>" id="<?php echo $f['field'].$f['idField'];?>" onclick="selectFields(this)">
                                            <div class="info-box bg-aqua"  style="display:table;cursor: pointer">
                                                <span class="info-box-icon" ><i class="<?php echo $icon;?>" id="icon<?php echo $f['field'].$f['idField'];?>"></i></span>

                                                <div class="info-box-content"  style="display:table-cell;vertical-align:middle" data-tag='<field name="<?php echo $f['field'];?>" class="java.lang.<?php echo $f['type'];?>"><fieldDescription><![CDATA[]]></fieldDescription></field>"'>
                                                    <span class="info-box-text" ><?php echo $f['field'];?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Se reinicia el estado de statusSelected-->
                                        <?php $statusSelected = 'unselected';?>

                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                        <script>
                            $('.cancelTables').show();
                            $('.addTables').show();
                            $('.okTables').hide();
                        </script>
                    <?php else: ?>
                        <div class="alert alert-warning alert-dismissible">
                            No se econtraron tablas con esta conexión.
                        </div>
                        <script>
                            $('.cancelTables').hide();
                            $('.addTables').hide();
                            $('.okTables').show();
                        </script>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>

<!-- /.row -->