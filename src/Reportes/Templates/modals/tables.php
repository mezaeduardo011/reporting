<!-- REPORT QUERY -->
<div class=" " id="ReportQuery" tabindex="-1" role="dialog" aria-labelledby="CoreLabel">
    <div class="-dialog -lg" role="document">
        <div class="-content">
            <div class="-header">
                <button type="button" class="close" data-dismiss="" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p class="-title" >Report Query</p>
            </div>
            <div class="-body" style="padding: 0">

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
                            content: "\f0c7 Save query";
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
                                            <option value="">plsql</option>
                                        </select>
                                        <input type="file" class="file-input queryfile" id="queryfile" />
                                        <input type="file" class="file-input savequery"/>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                            <table style="width: 100%">
                                <thead>

                                <tr>
                                    <th style="width: 600px;max-width: 650px;">
                                        <div id="contenido-archivo" contenteditable="true" style="width: 100%; max-width: 100%;height: 270px;border: 1px solid;overflow-y: auto;font-size: 12px;font-weight: 100;    min-width: 600px;"></div>
                                    </th>
                                    <th  style="min-width: 150px">
                                        <table style="width: 100%;margin-left: 5px;position: absolute;top: 0;">
                                            <tbody style="height: 200px;">
                                            <tr>
                                                <td>
                                                    <div contenteditable="true" style="width: 100%; max-width: 100%;height: 80px; border: 1px solid;background:#d29f0b42;pointer-events:none;font-size: 10px;">
                                                        Drag a parameter into the query to add a parameter.
                                                        Hold CLT to add the parameter as query chunk.
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 5px;"><p style="font-size: 10px">Available parameters</p></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div contenteditable="false" style="width: 100%; max-width: 100%;height: 158px; border: 1px solid;">
                                                        <ul style="list-style: none;padding:0"  class="ulParameters">

                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td style="padding-top: 6px;">
                                                    <button class="btn btn-xs optElementM">New parameter</button>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <td  style="padding-top: 6px;">
                                        <input type="checkbox"> Automatically Retrive Fields <button class="btn btn-xs">Read Fields</button> <button class="btn btn-xs">Query designer</button>
                                        <button class="btn btn-xs pull-right">Send to clipboard</button>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div id="menu1" class="container tab-pane "   style="width: 100%"><br>
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
                        <div id="menu2" class="container tab-pane "   style="width: 100%;height: 270px;"><br>
                            <center><button class="btn btn-xs">Get fields datasource</button></center>
                        </div>
                    </div>
                </div>

            </div>
            <div class="-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-sm btn-default">Filter expression...</button>
                    <button type="button" class="btn btn-sm btn-default">Sort options..</button>
                    <button type="button" class="btn btn-sm btn-default btn-xs" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Preview data <i class="more-less fa fa-sort-down fa-2x"></i></button>
                </div>

                <div class="pull-right">
                    <!--    data-dismiss=""   para ocultar  -->
                    <button type="button"  class="btn btn-sm btn-default"  id="" >OK</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="">Cancel</button>
                </div>
                <div class="col-lg-12 panel-group" style="padding: 0">
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">

                        <table class="tabladatos" style="width: 100%;margin-top: 2rem;">
                            <tbody>

                            <tr>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>


                            </tr>
                            <tr>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>


                            </tr>
                            <tr>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                            </tr>
                            <tr>
                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                                <td style="border: 1px solid #ccc;text-align: left">campo 1</td>

                            </tr>
                            <tr>
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

    /*funcion encargada de leer archivo e insrtar en contenedor*/
    function leerArchivo(e) {

        extensionesPermitidas = new Array(".text",".sql");
        var archivo = e.target.files[0];
        archivoExt = $("#queryfile").val();

        if (!archivo) {
            return;
        }
        extension = (archivoExt.substring(archivoExt.lastIndexOf("."))).toLowerCase();
        permitida = false;

        for (var i = 0; i < extensionesPermitidas.length; i++)
        {
            if (extensionesPermitidas[i] == extension)
            {
                permitida = true;
                var lector = new FileReader();
                lector.onload = function(e) {
                    var contenido = e.target.result;
                    mostrarContenido(contenido);
                };
                lector.readAsText(archivo);
            }
        }
        if (!permitida)
        {
            alert("Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extension: " + extensionesPermitidas.join());
            $("#queryfile").val('');
        }
    }

    function mostrarContenido(contenido) {
        var elemento = document.getElementById('contenido-archivo');
        elemento.innerHTML = contenido;
    }

    document.getElementById('queryfile').addEventListener('change', leerArchivo, false);

</script>