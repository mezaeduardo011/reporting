//######
//## This work is licensed under the Creative Commons Attribution-Share Alike 3.0
//## United States License. To view a copy of this license,
//## visit http://creativecommons.org/licenses/by-sa/3.0/us/ or send a letter
//## to Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
//## Desarrollado por JPH - Ing. - Gregorio Jose Bolivar
//######
/**
 * Esto es un namespace que hace parte de otro. Encargado de controlar los elementos de la Grid contiene todas las configuraciones
 * necesaria para el funcionamiento de la grid principal del sistema
 *
 * @namespace VistaGrid
 * @memberOf Core
 */
Core.VistaGrid = {
    myGrid: [],
    main: function (temp,rows,show) {
        Core.VistaGrid.run(temp,rows,show);
    },
    /**
     * Esto es una función que permite ejecutar la configuración de la grid principal para levantar su funcionamiento
     * @param string temp, Ruta temporal de donde se procesaran los datos
     * @param object rows, Campo definidos en el assent del cliente
     * @param object show, Objetos definidos en la vista del cliente
     * @memberof Core.VistaGrid.run
     */
    run: function (temp,rows,show) {
        /* START DE GRILLA DHTML */
        var camp = '';
        var colHeadTmp = '';
        var colAlingTmp ='';
        var colSortingTmp = '';
        var colWidthsTmp = '';
        var colColTypesTmp = '';
        /* Procedemos a crear una cadena de texto paa enviar al procesador de la vista en el controlador */
        $.each(rows, function (index,value) {
            camp+='id:'+value.id+'|type:'+value.type+'|value:'+value.value+'#';

            // Setear valores del titulo de la GRIR, definido en la configuracion local de la vista.
            colHeadTmp+= '<label>'+value.value+'</label>'+',';

            // Setear valores del alinacion de la cabecera de la GRIR, definido en la configuracion local de la vista.
            colAlingTmp+=value.align+',';

            // Valores de Ordenamiento donde lo busca en la GRIR, definido en la configuracion local de la vista.
            colSortingTmp+=value.sort+',';

            // Valores del tamanio de los header de la GRIR, definido en la configuracion local de la vista.
            colWidthsTmp+=value.widths+',';

            // Valores del tipo de datos de cada valor de columna de la GRIR, definido en la configuracion local de la vista.
            colColTypesTmp+=value.type+',';
        });
        // Quitamos el ultimo caracter de la cadena
        var tmp = camp.substring(0,camp.length-1);
        var colHead = colHeadTmp.substring(0,colHeadTmp.length-1);
        var colAling = colAlingTmp.substring(0,colAlingTmp.length-1);
        var colSorting = colSortingTmp.substring(0,colSortingTmp.length-1);
        var colWidths = colWidthsTmp.substring(0,colWidthsTmp.length-1);
        var colColTypes = colColTypesTmp.substring(0,colColTypesTmp.length-1);

        // Ref: https://docs.dhtmlx.com/grid__basic_initialization.html
        Core.VistaGrid.myGrid[show.module] = new dhtmlXGridObject('dataJPH'+show.module);

        // Ref: https://docs.dhtmlx.com/api__dhtmlxwindows_setimagepath.html
        Core.VistaGrid.myGrid[show.module].setImagePath("/admin/dhtmlxSuite/codebase/imgs/");

        // Header del Grid
        // Ref: https://docs.dhtmlx.com/api__link__dhtmlxtreegrid_setheader.html
        Core.VistaGrid.myGrid[show.module].setHeader(colHead);

        // Alinacion del contenido de la GRID
        // Ref: https://docs.dhtmlx.com/api__link__dhtmlxtreegrid_setcolalign.html
        Core.VistaGrid.myGrid[show.module].setColAlign(colAling);

        // Filtrado de datos del ladodel servidor
        // Ref: https://docs.dhtmlx.com/api__link__dhtmlxtreegrid_setcolsorting.html
        Core.VistaGrid.myGrid[show.module].setColSorting(colSorting);

        // Tipo de los campos
        // Ref : https://docs.dhtmlx.com/api__link__dhtmlxtreegrid_setcoltypes.html
        Core.VistaGrid.myGrid[show.module].setColTypes(colColTypes);

        // Acccion para ordenar campos
        //available in pro version only
        if (Core.VistaGrid.myGrid[show.module].setColspan){
            Core.VistaGrid.myGrid[show.module].attachEvent("onBeforeSorting",Core.VistaGrid.customColumnSort);
        }

        // Tamanio del campo
        // Ref: https://docs.dhtmlx.com/api__link__dhtmlxtreegrid_setinitwidths.html
        Core.VistaGrid.myGrid[show.module].setInitWidths(colWidths);

        // Filtro de la tabla
        //Core.VistaGrid.myGrid[show.module].attachHeader(show.filter);

        // Campos id Mostrar
        // Ref: https://docs.dhtmlx.com/api__link__dhtmlxtreegrid_enableautowidth.html
        Core.VistaGrid.myGrid[show.module].enableAutoWidth(show.autoWidth);

        // Permite activar si la grid se puede seleccionar varios item de la table
        // Ref: https://docs.dhtmlx.com/api__dhtmlxtree_enablemultiselection.html
        Core.VistaGrid.myGrid[show.module].enableMultiselect(show.multiSelect);

        // Evento que permite cuando seleccionar el registro te permite hacer la consulta del registro
        // Ref: https://docs.dhtmlx.com/api__common_attachevent.html
        Core.VistaGrid.myGrid[show.module].attachEvent("onRowSelect", Core.Vista.doOnRowSelected);

        //Core.Vista.myGrid.submitOnlyRowID(true);
        //Core.Vista.myGrid.attachEvent("onBeforeSorting",Core.Vista.sortGridOnServer);

        // link dataprocessor al component
        // Ref: https://docs.dhtmlx.com/api__dataprocessor_init.html
        Core.VistaGrid.myGrid[show.module].init();

        // Paginado cambiando el idioma
        // Ref: https://docs.dhtmlx.com/grid__paging.html
        Core.VistaGrid.myGrid[show.module].i18n.paging={
            results:"Resultados",
            records:"Registros de ",
            to:" a ",
            page:"Página ",
            perpage:"filas por página",
            first:"Para la primera página",
            previous:"Pagina anterior",
            found:"Registros encontrados",
            next:"Siguiente página",
            last:"Para la última página",
            of:" de ",
            notfound:"No se encontrarón archivos"
        };
        // Permite activar el paginado de la grid
        // Ref: https://docs.dhtmlx.com/api__link__dhtmlxtreegrid_enablepaging.html
        Core.VistaGrid.myGrid[show.module].enablePaging(true,show.pageSize,show.pagesInGrp,"pagingArea"+show.module,true,"infoArea"+show.module);

        // Disenio de paginador
        // Ref: https://docs.dhtmlx.com/api__link__dhtmlxtreegrid_setpagingskin.html
        Core.VistaGrid.myGrid[show.module].setPagingSkin("bricks");

        //code below written to support standard edtiton
        //it written especially for current sample and may not work
        //in other cases, DON'T USE it if you have pro version
        Core.VistaGrid.myGrid[show.module].sortField_old=myGrid.sortField;
        Core.VistaGrid.myGrid[show.module].sortField=function(){
            Core.VistaGrid.myGrid[show.module].setColSorting("str,str,str");
            if (Core.VistaGrid.customColumnSort(arguments[0])) Core.VistaGrid.myGrid[show.module].sortField_old.apply(this,arguments);
        };

        // habilita el modo de renderizado inteligente
        // Ref: https://docs.dhtmlx.com/api__link__dhtmlxtreegrid_enablesmartrendering.html
        Core.VistaGrid.myGrid[show.module].enableSmartRendering(true);

        // Variable para ser enviado por parametros al controlador del modulo activo
        var gridQString = '/'+show.module.toLowerCase()+'Listar?obj='+window.btoa(tmp)+''; // save query string to global variable (see step 5)

        // Ponerlo en local store
        localStorage.setItem('gridQString-'+show.module,gridQString);

        // Antes de cargar los datos
        // Ref: https://docs.dhtmlx.com/api__dataloading_onxls_event.html
        Core.VistaGrid.myGrid[show.module].attachEvent("onXLS",function(){
            Core.VistaGrid.showLoading(true,show.module)}
        );

        // Después de finalizar la carga y datos procesados ​​(antes de la devolución de llamada del usuario)
        // Ref: https://docs.dhtmlx.com/api__dataloading_onxle_event.html
        Core.VistaGrid.myGrid[show.module].attachEvent("onXLE",function () {
            Core.VistaGrid.showLoading(false,show.module);
        });

        // Cargas los valores en el controlador
        // Ref: https://docs.dhtmlx.com/api__dhtmlxgrid_load.html
        Core.VistaGrid.myGrid[show.module].load(gridQString);

    },
    /**
     * Esto es una función que permite ejecutar un loadin cargando en la parte del footer de la tabla
     * @memberof Core.VistaGrid.showLoading
     */
    showLoading: function (fl,modulo) {

        var span = document.getElementById("recfound"+modulo);
        if (!span) return;
        if(!Core.VistaGrid.myGrid[modulo]._serialise){
            span.innerHTML = "<i>Loading... available in Professional Edition of dhtmlxGrid</i>";
            return;
        }
        span.style.color = "red";
        if(fl===true)
            span.innerHTML = "loading...";
        else
            span.innerHTML = "";
    },
    /**
     * Esto es una función que permite ejecutar el search de los campos de la grid
     * @memberof Core.VistaGrid.doSearch
     */
    doSearch:function () {
        
    },
    /**
     * Esto es una función que permite ejecutar el reload de la grid
     * @memberof Core.VistaGrid.reloadGrid
     */
    reloadGrid:function () {
        var nm_mask = document.getElementById("search_nm").value;
        var cd_mask = document.getElementById("search_cd").value;
        showLoading(true);
        myGrid.clearAndLoad("php/50000_load_grid.php?nm_mask="+nm_mask+"&cd_mask="+cd_mask+"&orderBy="+window.s_col+"&direction="+window.a_direction);
        if (window.a_direction)
            myGrid.setSortImgState(true,window.s_col,window.a_direction);
    },
    /**
     * Esto es una función que permite activar la acciones de autosearch
     * @memberof Core.VistaGrid.enableAutosubmit
     */
    enableAutosubmit: function () {

    },
    /**
     * Esto es una función que permite efectuar el ordenamiento de la tabla A
     * @memberof Core.VistaGrid.customColumnSort
     */
    customColumnSort:function (ind) {
    if (ind==1) {
        alert("Table can't be sorted by this column.");
        if (window.s_col)
            myGrid.setSortImgState(true,window.s_col,window.a_direction);
        return false;
    }
    var a_state = myGrid.getSortingState();
    window.s_col=ind;
    window.a_direction = ((a_state[1] == "des")?"asc":"des");
    reloadGrid();
    return true;
    }
}
