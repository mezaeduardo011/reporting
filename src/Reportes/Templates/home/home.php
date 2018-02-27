<?php $this->layout('base')?>


    <div id="reglas_reporte"></div>

    <div class="borderHoja">
        <div class="row hoja" ondragover="Report.EventsDragDrop.allowDrop(event)" ondrop="Report.EventsDragDrop.hojaDrop(event)">
            <!--      <div id="divQuery"></div>-->
            <div id="title" data-typeelement = 'seccion' data-nameTag="title" data-xml="<title><band height='79' status='noVisited' splitType='Stretch'/></title>" class="split split-vertical title" style="border: 1px solid #C0C0C0;height: 50px;" >
                <div id="cl"></div>
            </div>
            <div id="detail" data-typeelement = 'seccion' data-nameTag="detail" data-xml="<detail><band height='79' status='noVisited' splitType='Stretch'/></detail>" class="split split-vertical">
            </div>
            <div id="footer" data-typeelement = 'seccion' data-nameTag="pageFooter" data-xml="<pageFooter><band height='79' status='noVisited' splitType='Stretch'/></pageFooter>" class="split split-vertical" style="border: 1px solid #C0C0C0;">
            </div>
        </div>
    </div>

<?php $this->push('addJs')?>

    <!-- Notificciones toastr -->
    <script type="text/javascript">
        var dataConnection;

        function editText() {
            $.confirm({
                content: 'url:/reportes.php/staticTextModal',
                columnClass: 'col-md-offset-3 col-md-6',
                title:false,
                buttons: {
                    Agregar: function () {
                        var elementText = $('#'+ViewProperties.elementSelected);
                        var textArea = $('#textArea');
                        var value = textArea.val();
                        elementText.empty();
                        elementText.append(value);
                    },
                    Cancelar: {
                        text: 'Cancelar', // With spaces and symbols
                        action: function () {

                        }
                    }
                }
            });
        }


        function createConnection() {
            $.confirm({
                content: 'url:/reportes.php/createConnection',
                columnClass: 'col-md-offset-3 col-md-6',
                title:false,
                buttons: {
                    formSubmit:
                        {
                            text: 'Ok',
                            btnClass: 'btn-blue',
                            action: function () {

                                var driverSend = $('#driver').val();
                                var hostSend = $('#host').val();
                                var databaseSend = $('#database').val();
                                var userSend = $('#user').val();
                                var passwordSend = $('#password').val();
                                var idOption = hostSend+'_'+databaseSend;

                                var data = { 'driver':driverSend,'host':hostSend,'users':userSend,'password':passwordSend,'db':databaseSend};
                                $.post( "/reportes.php/saveConnection",data, function( response ){
                                    //En caso de  ser correcto el save devuelve un numero
                                    if(!isNaN(Number(response)))
                                    {

                                        $('#listConnections').append($('<option>', {
                                            value: 3,
                                            text:hostSend+"."+databaseSend,
                                            id:idOption
                                        }));
                                        $('#'+idOption).attr('data-driver', driverSend);
                                        $('#'+idOption).attr('data-host', hostSend);
                                        $('#'+idOption).attr('data-database', databaseSend);
                                        $('#'+idOption).attr('data-user', userSend);
                                        $('#'+idOption).attr('data-password', passwordSend);

                                    }else
                                    //Si no devuelve el id numerico es porque ocurrio un error al registrar los datos
                                    {
                                        $.alert('Ocurrio un error al guardar la conexión');
                                    }

                                });

                            }
                        },Test: function ()
                    {
                        var driverTest = $('#driver').val();
                        var hostTest = $('#host').val();
                        var databaseTest = $('#database').val();
                        var userTest = $('#user').val();
                        var passwordTest = $('#password').val();
                        var data = { 'driver':driverTest,'host':hostTest,'user':userTest,'password':passwordTest,'database':databaseTest};
                        $.post( "/reportes.php/testConnection",data, function( response ) {
                            // $.alert(response);

                        });
                        return false;
                    },Cancelar: function ()
                    {
                    }
                }
            });
        }

        function useConnection(t) {

            var driver = event.target.options[event.target.selectedIndex].dataset.driver;
            var host = event.target.options[event.target.selectedIndex].dataset.host;
            var database = event.target.options[event.target.selectedIndex].dataset.database;
            var user = event.target.options[event.target.selectedIndex].dataset.user;
            var password = event.target.options[event.target.selectedIndex].dataset.password;
            dataConnection = { 'driver':driver,'host':host,'user':user,'password':password,'database':database};
            $.post( "/reportes.php/useConnection",dataConnection, function( response ) {
                //  $.alert('Ocurrio un error al usar la conexión');

            });
            return false;
        }

        function showTables() {

            if(dataConnection != undefined)
            {

                var fields = [];
                fields.push('22');
                //Se recorre el menu para obtener los campos que estan seleccionados y pasarlos a la vista tables
                $('#ulCampos li').each(function(i)
                {
                    fields.push($.trim($(this).text()));
                });
                $.confirm({
                    content: 'url:/reportes.php/tables?fieldsSelecteds='+fields+
                    '&driver='+dataConnection.driver+
                    '&database='+dataConnection.database+
                    '&user='+dataConnection.user+
                    '&password='+dataConnection.password+
                    '&host='+dataConnection.host,
                    columnClass:'col-md-12',
                    title:false,
                    buttons: {
                        Agregar: {
                            btnClass: 'addTables',
                            action : function () {
                                $("#ulCampos").empty();

                                $( ".fieldSelected" ).each(function() {
                                    //se agregan los elementos seleccionados en el menu opcion Campos
                                    //Los valores vienen de la vista tables
                                    $("#ulCampos").append(
                                        "<li data-idfield='"+$( this ).data('idfield')+"'>" +
                                        "<a data-field='"+$( this ).data('field')+"' id='li"+$( this ).data('field')+$( this ).data('idfield')+"' data-element='Campo'  draggable='true' ondragstart='Report.EventsDragDrop.drag(event)'>" +
                                        "<i class='fa fa-circle-o'> "+$( this ).data('field')+" </i>" +
                                        "</a>" +
                                        "</li>"
                                    );
                                });
                            }
                        },
                        Cancelar: {
                            btnClass: 'cancelTables',
                            text: 'Cancelar',
                            action: function () {

                            }
                        },
                        Ok: {
                            btnClass: 'okTables',
                            text: 'Ok',
                            action: function () {

                            }
                        }

                    }
                });
            }else
            {
                // $.alert('No se econtro una conexión');
                $.confirm({
                    title: 'Report Query',
                    columnClass:'col-md-12',
                    content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<textarea cols="500" rows="10" style="width:100%;" name="query" class="query"></textarea>' +
                    '</div>' +
                    '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function () {
                                var query = this.$content.find('.query').val();
                                if(!query){
                                    $.alert('provide a valid name');
                                    return false;
                                }

                                var q = query.toUpperCase();
                                var sq = q.match("SELECT(.*)FROM");
                                //var table = q.match("FROM(.*)");
                                var fields = sq[1].split(',');
                                $.each(fields, function( index, value ) {
                                    var data = {'column':$.trim(value) ,'table':'elements'};

                                    $.post( "/reportes.php/getTypeColumn",data, function( response ) {
                                        console.log(response['datos'][0].DATA_TYPE);
                                    });
                                });

                                $.alert('QUERY ' + fields);
                            }
                        },
                        cancel: function () {
                            //close
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    }
                });
            }

        }

        $('html').keyup(function(e){
            if(e.keyCode == 46) {
                $('#'+ViewProperties.elementSelected).remove();
                $('#i'+ViewProperties.elementSelected).remove();
            }
        });

        function autosize(o){
            $(this).height(0).height(this.scrollHeight);
        }
        var ind;
        function saveXml(t)
        {

            t.classList.add("buttonClick");
            setTimeout(function () {t.classList.remove("buttonClick");}, 150);


            ind = 1;
            $.post('/reporte/baseXml.xml', function(xml) {
                var jasperBasic = $(xml);

                var xmlDiv = undefined;


                $( ".ulStyle" ).find('div').find('.elementFrame').children().each(function( index ) {
                    console.log(1);
                });


                $( "#ulStyle" ).find('.elementFrame[data-xml]').each(function( index ) {
                    jasperBasic.find('jasperReport').find('background').before((new XMLSerializer()).serializeToString($.parseXML($(this).attr("data-xml"))));

                    //jasperBasic.find('jasperReport').append((new XMLSerializer()).serializeToString());
                });

                console.log(xml);
                //  return;

                $( ".hoja" ).children().each(function( index ) {
                    if($(this).data("xml") != undefined)
                    {

                        if(xmlDiv == undefined) {
                            xmlDiv = $.parseXML($(this).data("xml"));
                        }
                        xmlDiv = $.parseXML($(this).data("xml"));
                        console.log("XML BASE xmlDiv:  "+(new XMLSerializer()).serializeToString(xmlDiv));
                        travelChildren($(this),xmlDiv);
                        $(xmlDiv).find('reportElement').removeAttr('status');
                        $(xmlDiv).find('reportElement').removeAttr('used');
                        $(xmlDiv).find('band').removeAttr('status');
                        $(xmlDiv).find('band').removeAttr('used');
                        console.log("XML AGREGADO xmlDiv:  "+(new XMLSerializer()).serializeToString(xmlDiv));
                        if($(this).data('nametag') == 'title')
                        {
                            //jasperBasic.find('jasperReport').append((new XMLSerializer()).serializeToString(xmlDiv));

                            jasperBasic.find('jasperReport').find('background').after((new XMLSerializer()).serializeToString(xmlDiv));
                        }else if($(this).data('nametag') == 'detail')
                        {
                            jasperBasic.find('jasperReport').find('columnHeader').after((new XMLSerializer()).serializeToString(xmlDiv));
                        }else if($(this).data('nametag') == 'pageFooter')
                        {
                            jasperBasic.find('jasperReport').find('columnFooter').after((new XMLSerializer()).serializeToString(xmlDiv));
                        }else
                        {
                            jasperBasic.find('jasperReport').append((new XMLSerializer()).serializeToString(xmlDiv));
                        }

                    }
                });

                var data = { 'xml':(new XMLSerializer()).serializeToString(xml)};
                $.post( "/reportes.php/addTag",data, function( response ) {
                    console.log(response);
                });

            });

        }

        function  travelChildren(currentElement,xmlPattern) {
            console.log("Se ejecuta travelChildren() Se recibe por parametro currentElement :"+currentElement+" Y xmlPattern: "+(new XMLSerializer()).serializeToString(xmlPattern));
            console.log("currentElement es el this del elemento padre (El primer elemento creado en la hoja.)");
            console.log("por lo cual el each reacorre los hijos de currentElement");
            console.log("Si hay 3 frame  y 2 textos padres en la hoja esto recorrera cada uno de los hijos de estos xml.");

            var nameTag = currentElement.data("nametag");

            console.log("nameTag : "+nameTag);
            console.log("Se recorren los hijos del div con id = "+currentElement.attr('id'));

            var xPatterhn = $(xmlPattern).find('reportElement').attr("x");
            console.log("Sel almacena en xPatterhn el valor del tag x del padre (xmlPattern)");
            console.log("Si el valor del tag x del padre (xmlPattern) no existe se busca en otra etiqueta (band)");
            xPatterhn = (xPatterhn == undefined) ? $(xmlPattern).find('band').attr("height"):xPatterhn;
            console.log("xPatterhn :"+xPatterhn);
            var yPatterhn = $(xmlPattern).find('reportElement').attr("y");
            console.log("Se almacena en yPatterhn el valor del tag y del padre (xmlPattern)");
            console.log("Si el valor del tag x del padre (xmlPattern) no existe se busca en otra etiqueta (band)");
            yPatterhn = (yPatterhn == undefined) ? xPatterhn:yPatterhn;
            console.log("yPatterhn :"+yPatterhn);

            var typeElement = currentElement.data("typeelement");
            console.log('valor de typeElement ' + typeElement);
            currentElement.find('.elementReport').each(function (i) {
                var xmlChildren = $(this).attr("data-xml");

                console.log("Con el valor de xmlChildren se verifica si los elementos internos del padre tienen etiqueta xml");
                if(xmlChildren != undefined)
                {
                    console.log("Existe hijo con el valor de xmlChildren :"+xmlChildren);
                    console.log($(this).css("width").replace('px',''));
                    $(xmlChildren).find('reportElement').attr("x",$(this).css("width"));

                    var xChildren = $($.parseXML(xmlChildren)).find('reportElement').attr("x");
                    console.log("Sel almacena en xChildren el valor del tag x del padre (xChildren)");
                    console.log("Si el valor del tag x del padre (xChildren) no existe se busca en otra etiqueta (band)");
                    xChildren = (xChildren == undefined) ? $($.parseXML(xmlChildren)).find('band').attr("height"):xChildren;
                    console.log("xChildren :"+xChildren);
                    var yChildren = $($.parseXML(xmlChildren)).find('reportElement').attr("y");
                    console.log("Se almacena en yChildren el valor del tag y del padre (yChildren)");
                    console.log("Si el valor del tag x del padre (xmlPattern) no existe se busca en otra etiqueta (band)");
                    yChildren = (yChildren == undefined) ? xChildren:yChildren;
                    console.log("yChildren :"+yChildren);




                    if($(xmlPattern).find('reportElement[x="'+xChildren+'"]').attr("used") == 'agregado')
                    {
                        console.log("No se agrega elemento porque ya fue agregado")
                    }else
                    {
                        console.log("xmlPattern  "+(new XMLSerializer()).serializeToString(xmlPattern));
                        console.log("xmlChildren  "+(new XMLSerializer()).serializeToString($.parseXML(xmlChildren)));
                        console.log("Seteando valores xml");
                        var xmlC = $.parseXML(xmlChildren);


                        addAttrDefaultXml(xmlC,$(this));
                        //var elementC = $(this).data("nameTag");
                        // Report.elementC.setValuesXML($(this));
                        // $(xmlC).find('reportElement').attr("width", $(this).width());
                        console.log("xmlC  "+(new XMLSerializer()).serializeToString(xmlC));


                        console.log("Se agrega xmlChildren al xmlPattern");
                        if(typeElement == 'seccion')
                        {
                            console.log("Se agrega xml a seccion (title/detail/footer)");
                            $(xmlPattern).find(nameTag).find('band').append((new XMLSerializer()).serializeToString(xmlC));
                        }else
                        {
                            console.log("Se agrega xml a xml padre");
                            $(xmlPattern).find(nameTag).append((new XMLSerializer()).serializeToString(xmlC));
                        }
                        console.log("xmlPattern  DESPUES DE AGREGAR CHILDREN "+(new XMLSerializer()).serializeToString(xmlPattern));

                        console.log("xmlChildren  "+(new XMLSerializer()).serializeToString($.parseXML(xmlChildren)));
                        console.log("Se cambia el estado (statusUsed) de "+(new XMLSerializer()).serializeToString($.parseXML(xmlChildren))+" a agregado ");

                        console.log("Cambiando "+$(xmlPattern).find('reportElement[x="'+xChildren+'"]').attr("used","agregado") );

                        console.log("Cambio de status queda = "+(new XMLSerializer()).serializeToString(xmlPattern)+" agregado ");

                    }

                }

                console.log("Se cambia el estado (status) de "+(new XMLSerializer()).serializeToString(xmlPattern)+" a visitado ");
                console.log("Asi debe cambiar el status del elemento specifico"+$(xmlPattern).find('band[height="'+xPatterhn+'"]').attr("status","visited") );
                console.log("Asi debe cambiar el status del elemento specifico"+$(xmlPattern).find('reportElement[x="'+xPatterhn+'"]').attr("status","visited") );
                console.log("Cambio de status queda = "+(new XMLSerializer()).serializeToString(xmlPattern)+" a visitado ");
                console.log("Se Finaliza recorrido");
                console.log("Se verifica si este div actual ("+xmlPattern+") posee hijos  y se agregan ejecuntando de nuevo travelChildren()");
                travelChildren($(this),xmlPattern);
            });

        }


        function addAttrDefaultXml(xmlC,t) {
            console.log("Se agrega top al xml");
            $(xmlC).find('reportElement').attr("y", parseInt(t.css('top')));

            console.log("Se agrega left al xml");
            $(xmlC).find('reportElement').attr("x", parseInt(t.css('left')));

            console.log("Se agrega ancho al xml");
            $(xmlC).find('reportElement').attr("width", parseInt(t.width()));

            console.log("Se agrega alto al xml");
            $(xmlC).find('reportElement').attr("height", parseInt(t.height()));

            console.log("Se agrega color de fondo al xml");
            $(xmlC).find('reportElement').attr("backcolor", t.css('background-color'));

            console.log("Se agrega color superior al xml");
            $(xmlC).find('reportElement').attr("forecolor", t.css('color'));


        }

        function selectFields(t) {
            var field = t.id;
            var icon = $('#icon'+field);
            var divField = $('#'+field);
            if(divField.hasClass('unselected'))
            {
                divField.removeClass('unselected');
                divField.addClass('fieldSelected');
                icon.removeAttr('class');
                icon.attr('class', 'fa fa-check-square');
            }else
            {
                icon.removeAttr('class');
                divField.removeClass('fieldSelected');
                divField.addClass('unselected');
                icon.attr('class', 'fa fa-minus-square');
            }


        }

        $( document ).ready(function() {
            Report.main();
            loadElements()
        });

        var logger = function()
        {
            var oldConsoleLog = null;
            var pub = {};

            pub.enableLogger =  function enableLogger()
            {
                if(oldConsoleLog == null)
                    return;

                window['console']['log'] = oldConsoleLog;
            };

            pub.disableLogger = function disableLogger()
            {
                oldConsoleLog = console.log;
                window['console']['log'] = function() {};
            };

            return pub;
        }();


        Split(['#title', '#detail','#footer'], {
            direction: 'vertical',
            gutterSize: 8,
            cursor: 'col-resize'
        })

        function  zoomOut (t) {
            t.classList.add("buttonClick");
            setTimeout(function () {t.classList.remove("buttonClick");}, 150);
            $(".borderHoja").height(
                $(".borderHoja").height() * 0.8
            );
        }

        function zoomIn (t) {
            t.classList.add("buttonClick");
            setTimeout(function () {t.classList.remove("buttonClick");}, 150);
            $(".borderHoja").height(
                $(".borderHoja").height() * 1.1
            );
        }

        /*
          agregar, editar nuevos elementos segun su eleccion click derecho
         */

        $(document).on('mousedown', '.optElement', function(e) {
            //inabilitar menu opciones de click derecho
            document.oncontextmenu = function(){return false}

            if(e.which == 3)
            {
                addUl = $(this).attr('data-ul');

                $.confirm({
                    title:false,
                    escapeKey: true,
                    closeIcon: false,
                    backgroundDismiss: true,
                    content:false,
                    buttons: {
                        agregar: {
                            text: 'Agregar',

                            action: function(heyThereButton){
                                addNewElemento(addUl)
                            }
                        }
                    },
                    onContentReady:function(){
                        this.buttons.agregar.addClass('btn-block')
                        $('.jconfirm-content-pane').css({
                            height: 0,
                            'margin-bottom': 0,
                            display:'none'
                        });
                        $('.jconfirm-buttons').css({float: 'none'});
                    }
                });
            }

        });

        $(document).on('mousedown', '.editOptionElemet', function(e) {
            //inabilitar menu opciones de click derecho
            document.oncontextmenu = function(){return false}

            if(e.which == 3)
            {
                nameField = $(this).attr('data-field');
                nameUl = $(this).attr('data-quien');

                $.confirm({
                    title:false,
                    escapeKey: true,
                    closeIcon: false,
                    backgroundDismiss: true,
                    content:false,
                    buttons: {
                        rename: {
                            text: 'Renombrar...',

                            action: function(heyThereButton){
                                renameElemento(nameField,nameUl)
                            }
                        },
                        conditional: {
                            text: 'Agregar Conditional Style',

                            action: function(heyThereButton){

                                conditionElemento(nameField)
                            }
                        },
                        trash: {
                            text: 'Suprimir',

                            action: function(heyThereButton){
                                deletedElement(nameField,nameUl)
                            }
                        }
                    },
                    onContentReady:function(){
                        this.buttons.rename.addClass('btn-block')

                        if (nameUl == 'ulStyle') {
                            this.buttons.conditional.addClass('btn-block')

                        }else{
                            this.buttons.conditional.addClass('hidden')

                        }

                        this.buttons.trash.addClass('btn-block')
                        $('.jconfirm-content-pane').css({
                            height: 0,
                            'margin-bottom': 0,
                            display:'none',
                            'text-align':'left'
                        });
                        $('.jconfirm-buttons').css({float: 'none'});
                    }
                });

            }
        });

        function conditionElemento(nameField)
        {

            n = $(".contlisub"+nameField).length;
            numli = new Number( n + 1 );
            if (localStorage.getItem(nameField))
            {
                addsubvalArray(nameField, "nameCondition"+numli+"");
            }else{
                subvalor = [];
                subvalor.push("nameCondition"+numli+"");
                // console.log(JSON.stringify(subvalor));
                localStorage.setItem(nameField, JSON.stringify(subvalor));
                listsubElement(nameField)
            }

        }
        function addsubvalArray(nameField,content){
            n = $(".contlisub"+nameField).length;
            numli = new Number( n + 1 );
            addArray = [];
            listArray = JSON.parse(localStorage.getItem(nameField))
            $.each(listArray, function(index, val) {

                if (val == content)
                {
                    $.alert('Ya ese valor exite');
                    return false;
                }else{
                    addArray.push(val)
                }

            });
            addArray.push("nameCondition"+numli+"")
            localStorage.setItem(nameField, JSON.stringify(addArray));
            listsubElement(nameField)
        }

        function renameElemento(nameField,nameUl){
            $.confirm({
                escapeKey: true,
                closeIcon: false,
                content:  '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<input type="text" placeholder="Editar el nombre" class="renameElement form-control" value="'+nameField+'" required />' +
                '</div>' +
                '</form>',
                backgroundDismiss: true,
                title:'Editar Elemento',
                buttons:
                    {
                        formSubmit:
                            {
                                text: 'Aceptar',
                                btnClass: 'btn  ink-reaction btn-blue',
                                action: function () {
                                    var renameElement = this.$content.find('.renameElement').val();
                                    if(!renameElement)
                                    {
                                        $.alert('Debes rellenar el campo');
                                        return false;
                                    }
                                    listArray = JSON.parse(localStorage.getItem(nameUl))
                                    $.each(listArray, function(index, val) {

                                        if (val == renameElement)
                                        {
                                            $.alert('Ya ese valor exite');
                                            return false;
                                        }else{

                                            edditArray2 = [];
                                            ArraysvalInternos = JSON.parse(localStorage.getItem(nameUl))

                                            $.each(ArraysvalInternos, function(index, val) {

                                                if (val == nameField)
                                                {
                                                    edditArray2.push(renameElement)

                                                    edditArray3 = [];
                                                    valconditions = JSON.parse(localStorage.getItem(val))

                                                    $.each(valconditions, function(index, valcond) {

                                                        if (valcond == renameElement)
                                                        {
                                                            edditArray3.push(renameElement)
                                                        }else{
                                                            edditArray3.push(valcond)
                                                        }

                                                    });

                                                    localStorage.setItem(renameElement, JSON.stringify(edditArray3));
                                                }else{
                                                    edditArray2.push(val)
                                                }

                                            });

                                            localStorage.setItem(nameUl, JSON.stringify(edditArray2));

                                        }
                                    });
                                    loadElements()

                                }

                            },

                        Cancelar: {
                            btnClass: 'cancelTables',
                            text: 'Cancelar',
                            action: function () {

                            }
                        }

                    }
            });
        }
        function addNewElemento(addUl)
        {
            cantUl = $('.'+addUl).length;
            num = new Number(cantUl + 1);
            $.confirm({
                content:  '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<input type="text" placeholder="Ingrese el nombre" class="nameElement form-control" value="'+addUl+''+num+'" required />' +
                '</div>' +
                '</form>',
                columnClass: 'col-md-offset-3 col-md-6',
                title:'Agregar Parametro',
                buttons:
                    {
                        formSubmit:
                            {
                                text: 'Agregar',
                                btnClass: 'btn  ink-reaction btn-blue',
                                action: function () {
                                    var nameElement = this.$content.find('.nameElement').val();
                                    actuales = localStorage.getItem(addUl)
                                    if(!nameElement)
                                    {
                                        //localStorage.clear();
                                        $.alert('Debes rellenar el campo');
                                        return false;
                                    }

                                    if (localStorage.getItem(addUl))
                                    {
                                        addvalArray(addUl, nameElement);



                                    }else{
                                        valor = [];
                                        valor.push(nameElement);
                                        // console.log(JSON.stringify(valor));
                                        localStorage.setItem(addUl, JSON.stringify(valor));
                                        $("#"+addUl).empty();
                                        loadElements()
                                        listElement(addUl)
                                    }

                                }
                            },

                        Cancelar: {
                            text: 'Salir',
                            action: function () {

                            }
                        }
                    }
            });
        }
        function deletedElement(nameField,nameUl){
            $.confirm({
                title:'<strong style="font-size:14px;">Confirmación de eliminación de Objeto</strong>',
                icon:'fa fa-warning',
                closeIcon: false,
                content:  '<center> ¿seguro que quieres eliminar '+nameField+'? </center  >',
                buttons:
                    {
                        formSubmit:
                            {
                                text: 'Si',
                                btnClass: 'btn  ink-reaction btn-blue',
                                action: function () {
                                    deleteItem = [];
                                    listArray = JSON.parse(localStorage.getItem(nameUl))
                                    $.each(listArray, function(index, val) {

                                        if (val != nameField)
                                        {
                                            deleteItem.push(val)
                                        }

                                    });

                                    localStorage.setItem(nameUl, JSON.stringify(deleteItem));
                                    listElement(nameUl)
                                }

                            },

                        Cancelar: {

                            text: 'No',
                            action: function () {

                            }
                        }

                    }
            });
        }


        function addvalArray(addUl, nameElement)
        {

            addArray = [];
            listArray = JSON.parse(localStorage.getItem(addUl))
            $.each(listArray, function(index, val) {

                if (val == nameElement)
                {
                    $.alert('Ya ese valor exite');
                    return false;
                }else{
                    addArray.push(val)
                }

            });
            addArray.push(nameElement)
            localStorage.setItem(addUl, JSON.stringify(addArray));
            $("#"+addUl).empty();
            loadElements()

        }
        function listElement(addUl)
        {
            ulElements = $("#"+addUl);
            ulElements.empty();
            listArray = JSON.parse(localStorage.getItem(addUl))
            $.each(listArray, function(index, val)
            {
                var attr = "";
                if(addUl == 'ulStyle')
                {
                    attr = "data-id='15'";
                }else
                {
                    attr = 'data-id=\'15\' draggable=\'true\' ondragstart=\'Report.EventsDragDrop.drag(event)\'';
                }

                ulElements.append(
                    "<li class='"+addUl+"'>" +
                    "<a data-field=\'"+val+"\' data-quien="+addUl+" id='li"+val+index+"' data-element='Campo'  draggable='true'   class='editOptionElemet'  draggable='true' ondragstart='Report.EventsDragDrop.drag(event)'>" +
                    "<i class='fa fa-circle-o'> "+val+" </i>" +
                    "</a>" +

                    "</li>"
                );
                //Report.Style.idStyle = val;
                //Report.Style.newStyle();
                $('#li'+val).click(function() {
                    $('#'+val+index).trigger('mousedown');
                });
            });

            eventElement();
        }
        function loadElements(){
            arrayListElement = ["ulParameters","ulStyle"];

            $.each(arrayListElement, function(index, nameUL) {
                ulElements = $("#"+nameUL);
                ulElements.empty();
                listArray = JSON.parse(localStorage.getItem(nameUL))
                $.each(listArray, function(index, val) {
                    var attr = "";
                    if(nameUL == 'ulStyle')
                    {
                        attr = "data-id='15' data-element='Estilos'";
                    }else
                    {
                        attr = 'data-id=\'15\' draggable=\'true\' ondragstart=\'Report.EventsDragDrop.drag(event)\' data-element=\'Texto Estático\'';
                    }
                    ulElements.append(
                        "<li class='"+nameUL+" treeview menu-open sub"+val+"' >" +
                        "<a data-field=\'"+val+"\' data-quien="+nameUL+"  id='li"+val+"' class='editOptionElemet elementPanel' "+attr+">" +
                        "<i class='fa fa-circle-o'> "+val+" </i>" +
                        "</a>" +
                        "</li>"
                    );
                    listsubElement(val);

                    if(nameUL == 'ulStyle')
                    {
                        //Report.Style.idStyle = val;
                        //Report.Style.newStyle();
                    }else
                    {
                        //Report.Parameters.idParameters = val;
                        //Report.Parameters.newParameters();
                    }


                    $('#li'+val).click(function() {
                        $('#'+val).trigger('mousedown');
                    });

                });
            });
            eventElement();
        }
        function listsubElement(nameField){

            namesub = "subli"+nameField+"";
            $("#"+namesub).empty();
            sublist = $(".sub"+nameField);

            sublist.append('<ul class="treeview-menu " id="'+namesub+'" style="display: block;"></ul>' );

            sublistadointerno = $("#"+namesub);

            listUlelement = JSON.parse(localStorage.getItem(nameField))
            $.each(listUlelement, function(index, val) {
                sublistadointerno.append(
                    '<li class="contlisub'+nameField+' ExpresionEditor" ><a href="#"><i class="fa fa-plus"></i>'+val+'</a></li>'
                );
            });
        }


        /*NUEVO*/


        $(document).on('mousedown', '.ExpresionEditor', function(e) {
            document.oncontextmenu = function(){return false}

            if(e.which == 3)
            {
                $('#modalEditor').modal('show');
            }
        });



        function eventElement() {
            var eventFrame = $('.elementPanel');


            eventFrame.click(function(){
                if(!$(this).hasClass('elementPanelSelected'))
                {

                    $("a").removeClass("elementPanelSelected");
                    $(this).addClass('elementPanelSelected');
                    var id = $(this).data("id");
                    var typeElement = $(this).data('element');
                    switch (typeElement) {
                        case 'Texto Estático': ViewProperties.setValuesProperties(Report.StaticText.checkValuesStaticText);
                            break;
                        case 'Caja': ViewProperties.setValuesProperties(Report.Box.checkValuesBox);
                            break;
                        case 'Estilos': ViewProperties.setValuesProperties(Report.Box.checkValuesBox);
                            break;
                    }

                    ViewProperties.cleanDivProperties();
                    ModelProperties.getPropertiesDefault();
                    ModelProperties.getPropertiesById(typeElement, id);
                }

            });
        }

        parametros = ["REPORT_CONTEXT","REPORT_PARAMETERS_MAP","JASPER_REPORT_CONTEXT","JASPER_REPORT","REPORT_CONNECTION","REPORT_MAX_COUNT","REPORT_DATA_SOURCE","REPORT_SCRIPTLET","REPORT_LOCALE","REPORT_RESOURCE_BUNDLE"];
        listadoUnoCol3 = ["getId()","getParameterValue(String) ","containsParameter(String)"];


        /*campos de base de datos*/
        fields= ["campo1","campo2","campo3"];
        listFielCol3 = ["numberOfLeadingZeros( int )","numberOfTrailingZeros( int )","bitCount( int )","equals( Object ) boolean","toString()","toString( int, int )","toString( int )","hashCode()","reverseBytes( int )","compareTo( Object )","compareTo( Integer )","byteValue() byte","shortValue() short","intValue()","longValue() long","floatValue()","doubleValue()","valueOf( int )","valueOf( String )","valueOf( String, int )","toHexString( int )","compare( int, int )","decode( String )","reverse( int )","parseInt( String )","parseInt( String, int )","getInteger( String )","getInteger( String, int )","getInteger( String, Integer )","highestOneBit( int )","lowestOneBit( int )","rotateLeft( int, int )","rotateRight( int, int )","signum( int )","toBinaryString( int )","toOctalString( int )","getClass()"];

        variables = ["PAGE_NUMBER","COLUMN_NUMBER","REPORT_COUNT","PAGE_COUNT","COLUNM_COUNT"];


        $("#listParametros").click(function(event) {
            $("#columnados").empty();
            $("#columnatres").empty();
            $.each(parametros, function(index, val) {
                $("#columnados").append('<option class="textCondition" data-qi="P" data-color="red" value="'+val+'" >'+val+'</option>')
            });
            $.each(listadoUnoCol3, function(index, val) {
                $("#columnatres").append('<option class="textfunction">'+val+'</option>')
            });
        });
        $("#listFields").click(function(event) {
            $("#columnados").empty();
            $("#columnatres").empty();

            $.each(fields, function(index, val) {
                $("#columnados").append('<option class="textCondition"  data-qi="F" data-color="blue" value="'+val+'" >'+val+'</option>')
            });
            $.each(listFielCol3, function(index, val) {
                $("#columnatres").append('<option class="textfunction">'+val+'</option>')
            });
        });

        $("#listVariables").click(function(event) {
            $("#columnados").empty();
            $("#columnatres").empty();

            $.each(variables, function(index, val) {
                $("#columnados").append('<option class="textCondition"  data-qi="V" data-color="green" value="'+val+'" >'+val+'</option>')
            });
            $.each(listFielCol3, function(index, val) {
                $("#columnatres").append('<option class="textfunction">'+val+'</option>')
            });
        });

        $(document).on('dblclick', '.textCondition', function(e) {
            string = $(this).text();
            qi = $(this).attr('data-qi');
            color = $(this).attr('data-color');

            textarea = $("#condicionalString");
            var divtest = document.createElement("b");
            divtest.setAttribute("style", 'color:'+color+'');
            divtest.innerHTML = '$'+qi+'{'+string+'} ';
            textarea.append(divtest)

        });

        $(document).on('dblclick', '.textfunction', function(e) {

            opt = $(this).text();

            $("select[name^='columnados'] option:selected").each(function(index, stringv) {
                if ($("select[name^='columnados'] option:selected"))
                {
                    if (index == 0) {

                        textarea = $("#condicionalString");
                        var divtest = document.createElement("b");
                        color = $("select[name^='columnados'] option:selected").attr('data-color');
                        string=$("select[name^='columnados'] option:selected").val();
                        qi = $("select[name^='columnados'] option:selected").attr('data-qi');
                        divtest.innerHTML = '<b style="color:'+color+'">$'+qi+'{'+string+'}</b>'+'.'+opt;
                        textarea.append(divtest)

                    }
                }

            });


        });

        $(document).on('click', '#aplicarExpresion', function(e) {
            expresion = $("#condicionalString").text();
            alert(expresion);
        });

    </script>
<?php $this->end()?>