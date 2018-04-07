
<!-- CSS Extends-->
<?=$this->section('addCss')?>

<!-- Modal -->
<div class="modal fade" id="modalCore" tabindex="-1" role="dialog" aria-labelledby="modalCoreLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalCoreLabel">Inspector de Elementos</h4>
            </div>
            <div class="modal-body" id="modalBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarVentana">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL PARA EDITAR EXPRESIONES -->

<!-- Modal -->
<div class="modal fade" id="modalEditor" tabindex="-1" role="dialog" aria-labelledby="modalCoreLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p class="modal-title" >Expression editor</p>
            </div>
            <div class="modal-body" >
                <div id="condicionalString" contenteditable="true" style="width: 100%; max-width: 100%;height: 200px; max-height: 200px;border: 1px solid;"></div>

                <div style="padding-top: 2%;max-width: 100%;">
                    <input type="hidden" id="namecondition">
                    <table style="width: 100%;">
                        <tbody>
                        <tr>
                            <td>
                                <ul style="list-style-type: none;width: 180px;padding-left: 0;height: 189px; max-height: 190px; overflow-y: auto;overflow-x: auto;">
                                    <li id="listParametros">Parameters</li>
                                    <li id="listFields">Fields</li>
                                    <li id="listVariables">Variables</li>
                                    <li><i class="fa fa-folder"></i> User Defined Expressions</li>
                                    <li><i class="fa fa-folder"></i> Recent Expressions</li>
                                    <li><i class="fa fa-folder"></i> Expression Wizards</li>
                                </ul>
                            </td>
                            <td>
                                <div style="list-style-type: none;width: 180px;padding-left: 0;height: 189px; max-height: 190px; overflow-y: auto;overflow-x: auto;" >
                                    <select name="columnados" id="columnados" multiple="" style="height: 100%;width: 100%; overflow: hidden;">
                                    </select>
                                    <div>
                            </td>
                            <td>
                                <div style="list-style-type: none;width: 180px;padding-left: 0;height: 189px; max-height: 190px; overflow-y: auto;overflow-x: auto;">
                                    <select   id="columnatres" multiple="" style="height: 100%;width: 100%; overflow: hidden;">
                                    </select>
                                    <div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-sm btn-default">Import...</button>
                    <button type="button" class="btn btn-sm btn-default">Export..</button>
                </div>

                <div class="pull-right">
                    <!--    data-dismiss="modal"   para ocultar modal -->
                    <button type="button" onclick="loadElements()" class="btn btn-sm btn-default"  id="aplicarExpresion" >Apply</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- REPORT QUERY -->
<div class="modal fade" id="ReportQuery" tabindex="-1" role="dialog" aria-labelledby="modalCoreLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p class="modal-title" >Report Query</p>
            </div>
            <div class="modal-body" style="padding: 0">

                <div  style="width: 100%">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link active" data-toggle="tab" href="#home" style="padding: 4px 15px;">Report query</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu1" style="padding: 4px 15px;">JavaBean Datasources</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu2" style="padding: 4px 15px;">Datasources provider</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu2" style="padding: 4px 15px;">CSV Datasources</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu2" style="padding: 4px 15px;">Excel Datasources</a>
                        </li>
                    </ul>
                    <style>
                        .file-input {
                            visibility: hidden;
                            width: 100px;
                            position: relative;

                            padding-bottom: 5px;
                        }
                        .queryfile::before{
                            content: "\f07c Load query";
                            float: none;
                        }
                        .savequery::before{
                            content: "\f07c Save query";
                            float: none;
                        }
                        .file-input::before {

                            font: normal normal normal 14px/1 FontAwesome;
                            display: inline-block;
                            background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
                            border: 1px solid #999;
                            padding: 5px 8px;
                            outline: none;
                            white-space: nowrap;
                            -webkit-user-select: none;
                            cursor: pointer;
                            text-shadow: 1px 1px #fff;
                            font-size: 10pt;
                            visibility: visible;
                            position: absolute;
                        }
                        input[type=file].file-input {
                            display: initial;
                        }
                        .file-input:hover::before {
                            border-color: black;
                        }
                        .file-input:active::before {
                            background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
                        }
                    </style>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="home" class="container tab-pane active"   style="width: 100%"><br>
                            <table style="width: 100%">
                                <thead>
                                <tr>
                                    <td style="padding-bottom: 5px;">
                                        Query language &nbsp;
                                        <select name="" id="">
                                            <option value=""></option>
                                            <option value="">SQL</option>
                                            <option value="">Hibernate Query Language (HQL)</option>
                                            <option value="">XPath</option>
                                            <option value="">EJBQL</option>
                                            <option value="">MDX</option>
                                            <option value="">XMLA-MDX</option>
                                            <option value="">xpath2</option>
                                            <option value="">json</option>
                                        </select>
                                        <input type="file" accept="image/*"   class="file-input queryfile"/>
                                        <input type="file" accept="image/*"   class="file-input savequery"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 600px;max-width: 650px;">
                                        <div id="" contenteditable="false" style="width: 100%; max-width: 100%;height: 270px;border: 1px solid;"></div>
                                    </th>
                                    <th  style="min-width: 150px">
                                        <table style="width: 100%;margin-left: 5px;">
                                            <tbody style="height: 200px;">
                                            <tr>
                                                <td>
                                                    <div contenteditable="true" style="width: 100%; max-width: 100%;height: 100px; border: 1px solid;background:#d29f0b42;pointer-events:none;"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 5px;"><p style="font-size: 10px">Available parameters</p></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div contenteditable="true" style="width: 100%; max-width: 100%;height: 140px; border: 1px solid;"></div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <td>
                                        <input type="check">
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div id="menu1" class="container tab-pane fade"   style="width: 100%"><br>
                            <table style="width: 100%">
                                <tr>
                                    <label>class name</label>
                                    <input type="text" style="width: 78%;margin-left: 5px;"> <button class="btn btn-xs" style="margin: 5px;margin-bottom: 10px;">Read attributes</button>
                                </tr>

                            </table>
                            <table style="width: 100%">
                                <thead>
                                <tr>
                                    <th style="width: 600px;max-width: 650px;">
                                        <div id="" contenteditable="false" style="width: 100%; max-width: 100%;height: 270px;border: 1px solid;"></div>
                                    </th>
                                </tr>
                                </thead>

                            </table>

                        </div>
                        <div id="menu2" class="container tab-pane fade"   style="width: 100%;height: 270px;"><br>
                            <center><button class="btn btn-xs">Get fields datasource</button></center>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-sm btn-default">Filter expression...</button>
                    <button type="button" class="btn btn-sm btn-default">Sort options..</button>
                    <button type="button" class="btn btn-sm btn-default " data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Preview data <i class="more-less glyphicon glyphicon-plus"></i></button>
                </div>

                <div class="pull-right">
                    <!--    data-dismiss="modal"   para ocultar modal -->
                    <button type="button"  class="btn btn-sm btn-default"  id="" >OK</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                </div>
                <div class="col-lg-12 panel-group" style="padding: 0">
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">

                        <table class="tabladatos" style="width: 100%;margin-top: 2rem;">
                            <tbody>

                            <tr>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /*CAMBIAR TAMAÑO DE TABLE*/
    (function () {
        var thElm;
        var trElm;
        var startOffset;

        Array.prototype.forEach.call(
            document.querySelectorAll("table th"),
            function (th) {
                th.style.position = 'relative';

                var grip = document.createElement('div');
                grip.innerHTML = "&nbsp;";
                grip.style.top = 0;
                grip.style.right = 0;
                grip.style.bottom = 0;
                grip.style.width = '5px';
                grip.style.position = 'absolute';
                grip.style.cursor = 'e-resize';
                grip.addEventListener('mousedown', function (e) {
                    thElm = th;
                    startOffset = th.offsetWidth - e.pageX;
                });

                th.appendChild(grip);
            });


        document.addEventListener('mousemove', function (e) {
            if (thElm) {
                thElm.style.width = startOffset + e.pageX + 'px';
            }
        });

        document.addEventListener('mouseup', function () {
            thElm = undefined;
        });

    })();
    /*FIN CAMBIAR TAMAÑO DE TABLE*/


</script>
