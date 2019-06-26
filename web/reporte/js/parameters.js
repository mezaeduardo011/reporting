Report.Parameters = {}
Report.Parameters = {
    width : '',
    height : '',
    numParameters : 1,
    idParameters : '',
    main : function  () {
        this.idParameters = 'elementFrame'+this.numParameters;
    },
    newParameters : function (){


        /************************************SE CREA LA FORMA DEL ELEMENTO****************************************************************************/
        var element = document.createElement("div");
        console.log("Se agrega el id creado en el main (this.idParameters = 'elementFrame'+this.numParameters;)");
        element.setAttribute("id", Report.Parameters.idParameters);
        console.log("Se indica a la vista que este elemento se esta usando");
        ViewProperties.elementUsed = Report.Parameters.idParameters;
        console.log("Clase elementFrame con el dibujo del Parameters");
        element.className = "elementFrame  elementReport ";
        console.log("Se agregan los id de las propiedades que tiene este elemento");
        element.setAttribute("data-idProperties", "4,11");
        element.setAttribute("style", "display: none;");
        console.log("Se agrega el xml correspondiente de este elemento");
        element.setAttribute("data-xml", '<Parameters name="'+Report.Parameters.idParameters+'"></Parameters>');
        console.log("Se agrega el nombre de la etiqueta del xml correspondiente");
        element.setAttribute("data-nameTag",'frame');
        console.log("Con addEventesMove se agregan todos los iconos resize al elemento");
        Report.addIconsResize(element);

        console.log("Se aplica el evendo onmousedown al elemento");
        element.onmousedown = function (e)
        {

            console.log("Se indica a la vista el id del div padre del elemento que se esta usando actualmente");
            ViewProperties.containmentFather = element.parentNode.id;
            console.log("Se hace el llamado a Report.Parameters.getMouseDown(e,$(this));");
            Report.Parameters.getMouseDown(e, $(this));
            console.log("Se aplica e.stopPropagation() para evitar que choque con otros eventos click ");
            e.stopPropagation();


        }
        console.log("e.target.appendChild(element); AGREGA EL ELEMENTO DIBUJADO AL DIV DE ESTILOS");    
        $('#ulParameters').append(element);
        /************************************FIN SE CREA LA FORMA DEL ELEMENTO****************************************************************************/
    },getMouseDown : function (e,t){
        console.log("Se reinician todos los div quitandole elementSelected $(\"div\").removeClass(\"elementSelected\");");
        $("div").removeClass("elementSelected");
        console.log("Se indica el id del Parameters actual Report.Parameters.idParameters = t.attr('id');");
        Report.Parameters.idParameters = t.attr('id');
        console.log("Se indica el elemento seleccionado actualmente ViewProperties.elementSelected = Report.Parameters.idParameters;");
        ViewProperties.elementSelected = Report.Parameters.idParameters;
        console.log("Se indica a la vista el id del div padre del elemento creado  ViewProperties.containmentFather = $(\"#\"+ViewProperties.elementSelected).parent().get( 0 ).id;");
        ViewProperties.containmentFather = $("#"+ViewProperties.elementSelected).parent().get( 0 ).id;
        console.log("Se obtienen las propiedades  var idProperties = t.data(\"idproperties\")\n ");
        var idProperties = t.data("idproperties")

        if(!t.hasClass('elementPanelSelected')) {
            $("div").removeClass("elementPanelSelected");
            t.addClass('elementPanelSelected');
            console.log("Se borran las propieades que estan mostrandose Report.PanelRight.cleanDivProperties();")
            Report.PanelRight.cleanDivProperties();
            console.log("Se muestran las propiedades por defecto ViewProperties.ShowProperties();")
            ViewProperties.ShowProperties();
            console.log("Se muestran las propieedades especificas");
            ViewProperties.ShowProperties('Caja',idProperties);
            console.log("Se actualiza los valores de las propiedades");
            ViewProperties.setValuesProperties(Report.Parameters.checkValuesParameters);
        }

        $("#"+ViewProperties.elementSelected).addClass("elementSelectedTrue");

        setTimeout(function explode(){

            ViewProperties.elementSelected = Report.Parameters.idParameters;
            ViewProperties.elementUsed = Report.Parameters.idParameters;
            $('.ui-resizable-handle').each(function () {
                if( $(this).parent().get( 0 ).id ==  ViewProperties.elementSelected){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
        }, 100);

    },checkValuesParameters : function (){

    }
}