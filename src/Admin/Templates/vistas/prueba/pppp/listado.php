<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Lista de Pppp</h3>
    </div>
    <div div="listaPppp" class="listFiltros">
        <input type="text" id="search_nm" placeholder="Name" onKeyDown="Core.VistaGrid.myGrid['Pppp'].doSearch(arguments[0]||event)">

        <input type="text" id="search_cd" placeholder="Code" onKeyDown="Core.VistaGrid.myGrid['Pppp'].doSearch(arguments[0]||event)">
        <button onClick="Core.VistaGrid.myGrid['Pppp'].reloadGrid()" id="submitButton" style="margin-left:30px;">Search</button>
        <input type="checkbox" id="autosearch" onClick="Core.VistaGrid.myGrid['Pppp'].enableAutosubmit(this.checked)"> Enable Autosearch
    </div>
    <div class="box-body">
        <div id="dataJPHPppp" style="width:100%; height:450px; margin-top:20px; margin-bottom:10px;"></div>
        <div id='pagingAreaPppp'></div>
        <div id='recfoundPppp'></div>
    </div>
</div>
