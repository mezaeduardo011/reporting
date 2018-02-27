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
/*SE MODIFICO*/
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
/* NUEVO */
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
/* NUEVO */
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
/*SE MODIFICO*/
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
/*SE MODIFICO*/
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

/*SE MODIFICO*/
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
/*SE MODIFICO*/
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
            "<a data-field=\'"+val+"\' data-quien="+addUl+" id='li"+val+index+"' data-element='Texto Estático' "+attr+">" +
            "<i class='fa fa-circle-o'> "+val+" </i>" +
            "</a>" +

            "</li>"
        );

        Report.Style.idStyle = val;
        Report.Style.newStyle();
        $('#li'+val).click(function() {
            $('#'+val+index).trigger('mousedown');
        });
    });
    eventElement();
}
/*SE MODIFICO*/
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
                Report.Style.idStyle = val;
                Report.Style.newStyle();
            }else
            {
                Report.Parameters.idParameters = val;
                Report.Parameters.newParameters();
            }


            $('#li'+val).click(function() {
                $('#'+val).trigger('mousedown');
            });

        });
    });
    eventElement();
}
/*NUEVO*/
function listsubElement(nameField){

    namesub = "subli"+nameField+"";
    $("#"+namesub).empty();
    sublist = $(".sub"+nameField);

    sublist.append('<ul class="treeview-menu " id="'+namesub+'" style="display: block;"></ul>' );

    sublistadointerno = $("#"+namesub);

    listUlelement = JSON.parse(localStorage.getItem(nameField))
    $.each(listUlelement, function(index, val) {
        sublistadointerno.append(
            '<li class="contlisub'+nameField+'" onclick="ExpresionEditor()"><a href="#"><i class="fa fa-plus"></i>'+val+'</a></li>'
        );
    });
}
/*NUEVO*/
function ExpresionEditor(){
    $('#modalEditor').modal('show');
}

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