<!-- MODAL PARA EDITAR EXPRESIONES -->

<!-- Modal -->
<div class="modal fade" id="modalEditor" tabindex="-1" role="dialog" aria-labelledby="modalCoreLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" >Expression editor</h4>
            </div>
            <div class="modal-body" >
                <div id="condicionalString" contenteditable="true" style="width: 100%; max-width: 100%;height: 200px; max-height: 200px;border: 1px solid;"></div>

                <div style="padding-top: 2%;max-width: 100%;">
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
                    <button type="button" class="btn btn-sm btn-default"  id="aplicarExpresion">Apply</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
