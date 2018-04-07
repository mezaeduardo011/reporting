Report.StaticText = {}
Report.StaticText = {
    width : '',
    height : '',
    numStaticText : 1,
    idStaticText : '',
    elementCreated :'',
    main : function  (element) {
        this.elementCreated = element;
        this.idStaticText = element+this.numStaticText;
    },
    newStaticText : function (e){

        e.dataTransfer.setData("Text",e.target.id);
        $("div").removeClass("elementSelected");

        var element = document.createElement("div");
        console.log("Se agrega el id creado en el main (this.idBox = 'elementFrame'+this.numBox;)");
        element.setAttribute("id", Report.StaticText.idStaticText);
        console.log("Se indica a la vista que este elemento se esta usando");
        ViewProperties.elementUsed = Report.StaticText.idStaticText;
        console.log("Clase elementText con el dibujo del elementText");
        element.className = "elementText  staticText elementReport "+ Report.StaticText.idStaticText;
        console.log("Se agregan los id de las propiedades que tiene este elemento");
        element.setAttribute("data-idProperties", "15");
        console.log("Se agrega el xml correspondiente de este elemento");
        element.setAttribute("data-xml", '<staticText><reportElement x="'+Report.StaticText.numStaticText+'7" y="2'+Report.StaticText.numStaticText+'" width="100" height="20" /><text><![CDATA[Static text]]></text></staticText>');
        console.log("Se agrega el nombre de la etiqueta del xml correspondiente");
        element.setAttribute("data-nameTag",'staticText');
        Report.addIconsResize(element);



        element.onmousedown = function (e)
        {
            Report.StaticText.idStaticText = $(this).attr('id');
            Report.StaticText.getMouseDown(e, $(this));
            ViewProperties.containmentFather = element.parentNode.id;
            e.stopPropagation();
        }

        element.onmouseup = function (ev) {
            ViewProperties.ShowProperties();
        }




        e.target.appendChild(element);
        ViewProperties.containmentFather = element.parentNode.id;

        if(this.elementCreated == 'staticText')
        {
            $( "#"+Report.StaticText.idStaticText ).attr("contenteditable","true");
            //$('.ui-resizable-handle').hide();
            $( "#"+Report.StaticText.idStaticText ).append('Text');

            console.log("Se aplica el evendo keyup para modificar el xml cuando se escribe el texto");

            document.querySelector("#"+Report.StaticText.idStaticText).addEventListener("keyup", function(event){
                console.log( $(this).text() );
                var xml = $.parseXML($(this).attr("data-xml"));
                $(xml).find('text').empty();
                $(xml).find('text').append('<![CDATA['+$(this).text()+']]>');
                $(this).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
            });

        }else
        {
            $( "#"+Report.StaticText.idStaticText ).attr("contenteditable","false");
            $( "#"+Report.StaticText.idStaticText ).append('<div id="spanTd"><span>'+this.elementCreated+'</span><div>');
        }


        var selectedShape = undefined;

        Report.StaticText.addMouseUpStaticText();

        Report.StaticText.numStaticText += 1;
        Report.resizableElements();
    },getMouseDown : function (e,t){
        if(!t.hasClass('elementPanelSelected')) {
            $("div").removeClass("elementPanelSelected");
            t.addClass('elementPanelSelected');
            Report.PanelRight.cleanDivProperties();
            ViewProperties.ShowProperties('Texto Estático', t.data("idproperties"));
            ViewProperties.setValuesProperties(Report.StaticText.checkValuesStaticText);
            ViewProperties.ShowProperties();

        }

        setTimeout(function explode(){

            ViewProperties.elementSelected = Report.StaticText.idStaticText ;
            ViewProperties.elementUsed = ViewProperties.elementSelected;
            $('.ui-resizable-handle').each(function () {
                if( $(this).parent().get( 0 ).id ==  ViewProperties.elementSelected){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
        }, 100);
        // }
    },addMouseUpStaticText : function (){
        $('#'+Report.StaticText.idStaticText).mouseup(function(e) {
            selectedShape = undefined;
        });
    },setText : function (){
        var elementText = $('#'+ViewProperties.elementSelected);
        var textArea = $('#textArea');
        var value = textArea.val();
        elementText.empty();
        $( "#"+Report.StaticText.idStaticText ).append('<span>'+value+'</span>');
    },checkValuesStaticText : function (){


        if( $("#"+ViewProperties.elementSelected).css('font-weight') == '700')
        {
            $('input[name=Bold]').prop('checked', true);
        }

        if( $("#"+ViewProperties.elementSelected).css('font-style') == 'italic')
        {
            $('input[name=Italic]').prop('checked', true);
        }

        if($("#"+ViewProperties.elementSelected).css('text-decoration')!=undefined){
            var underline = $("#"+ViewProperties.elementSelected).css('text-decoration').split(' ')[0];
        }

        if(underline == 'underline')
        {
            $('input[name=Underline]').prop('checked', true);
        }
        setTimeout(function(){
            $('.select').each(function() {
                var tag = $(this).data('tag');
                var id = $(this).attr('id');
                switch (tag) {
                    case 'size':
                        (ViewProperties.elementSelected != null) ? $('#'+id).val($("#"+ViewProperties.elementSelected).css("font-size").replace('px', '')) : "";
                        break;
                    case 'textAlignment':
                        $('#'+id).val(Report.StaticText.tradc($("#"+ViewProperties.elementSelected).css("text-align")));
                        break;
                    case 'verticalAlignment':
                        $('#'+id).val(Report.StaticText.tradc($("#"+ViewProperties.elementSelected).css("vertical-align")));
                        break;
                }
            });
        }, 700);
    },tradc : function (text){
        var response = 'Izquierda';
        switch (text) {
            case 'left':
                response = 'Izquierda';
                break;
            case 'center':
                response = 'Centrado';
                break;
            case 'right':
                response = 'Derecha';
                break;
            case 'justify':
                response = 'Justificado';
                break;
            case 'text-top':
                response = 'Superior';
                break;
            case 'middle':
                response = 'Medio';
                break;
            case 'bottom':
                response = 'Inferior';
                break;
        }

        return response;
    },setValuesXML : function (t){
        console.log("victoria");
    }
}