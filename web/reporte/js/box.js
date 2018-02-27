Report.Box = {}
Report.Box = {
	width : '',
	height : '',
	numBox : 1,
	idBox : '',
	main : function  () {
		this.idBox = 'elementFrame'+this.numBox;
	},
    newBox : function (e){

        e.dataTransfer.setData("Text",e.target.id);
        $("div").removeClass("elementSelected");

        /************************************SE CREA LA FORMA DEL ELEMENTO****************************************************************************/
        var element = document.createElement("div");
        console.log("Se agrega el id creado en el main (this.idBox = 'elementFrame'+this.numBox;)");
        element.setAttribute("id", Report.Box.idBox);
        console.log("Se indica a la vista que este elemento se esta usando");
        ViewProperties.elementUsed = Report.Box.idBox;
        console.log("Clase elementFrame con el dibujo del box");
        element.className = "elementFrame elementReport";
        console.log("Se agregan los id de las propiedades que tiene este elemento");
        element.setAttribute("data-idProperties", "4,11");
        console.log("Se agrega el xml correspondiente de este elemento");
        element.setAttribute("data-xml", '<rectangle><reportElement mode="Opaque" x="1'+Report.Box.numBox +'" y="'+Report.Box.numBox +'40" width="100" height="20" used="no" status="notVisited"/></rectangle>');
        console.log("Se agrega el nombre de la etiqueta del xml correspondiente");
        element.setAttribute("data-nameTag",'frame');
        console.log("Con addEventesMove se agregan todos los iconos resize al elemento");
        Report.addIconsResize(element);

        console.log("Se aplica el evendo onmousedown al elemento");
        element.onmousedown = function (e)
        {

                console.log("Se indica a la vista el id del div padre del elemento que se esta usando actualmente");
                ViewProperties.containmentFather = element.parentNode.id;
                console.log("Se hace el llamado a Report.Box.getMouseDown(e,$(this));");
                Report.Box.getMouseDown(e, $(this));
                console.log("Se aplica e.stopPropagation() para evitar que choque con otros eventos click ");
                e.stopPropagation();


        }

        console.log("e.target.appendChild(element); AGREGA EL ELEMENTO DIBUJADO AL DIV HOJA");
        e.target.appendChild(element);
        /************************************FIN SE CREA LA FORMA DEL ELEMENTO****************************************************************************/
        console.log("Una vez creado el elemento se obtiene el id del padre con element.parentNode.id");
        console.log("Se guarda en ViewProperties.containmentFather");
        ViewProperties.containmentFather = element.parentNode.id;
        console.log("Se agregan eventos de mouseUp Report.Box.addMouseUpBox();");
        Report.Box.addMouseUpBox();
        console.log("Se suma uno al numBox para actualizar el contador de box creados Report.Box.numBox += 1;");
        Report.Box.numBox += 1;
        console.log("Se aplican los eventos resizable Report.resizableElements();");
        Report.resizableElements();
    },getMouseDown : function (e,t){
	    console.log("Se reinician todos los div quitandole elementSelected $(\"div\").removeClass(\"elementSelected\");");
        $("div").removeClass("elementSelected");
        console.log("Se indica el id del box actual Report.Box.idBox = t.attr('id');");
        Report.Box.idBox = t.attr('id');
        console.log("Se indica el elemento seleccionado actualmente ViewProperties.elementSelected = Report.Box.idBox;");
        ViewProperties.elementSelected = Report.Box.idBox;
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
            ViewProperties.setValuesProperties(Report.Box.checkValuesBox);
        }

		$("#"+ViewProperties.elementSelected).addClass("elementSelectedTrue");

        setTimeout(function explode(){

            ViewProperties.elementSelected = Report.Box.idBox;
            ViewProperties.elementUsed = Report.Box.idBox;
            $('.ui-resizable-handle').each(function () {
                if( $(this).parent().get( 0 ).id ==  ViewProperties.elementSelected){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
        }, 100);

	},addMouseUpBox : function (){
	    //Se verifican los iconos ui-resisable que sean solo de ViewProperties.elementSelected (elemento que recibe el mouseUp)
	    $('#'+Report.Box.idBox).mouseup(function(e) {
            $('.ui-resizable-handle', $("#"+ViewProperties.elementSelected)).each(function () {
                //Se muestra el icono
                $(this).show();
            });
	    });
	},checkValuesBox : function (){

	}
}