ControllerProperties = {}
ControllerProperties = {
	main : function (){},
	/*Acciones por defecto*/
	actionHeiht : function (i){
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        $(xml).find('reportElement').attr("height", parseInt(i.value));
		$('#'+ViewProperties.elementSelected).height(i.value+'px');
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionWidth : function (i){
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        $(xml).find('reportElement').attr("width", parseInt(i.value));
        $('#'+ViewProperties.elementSelected).width(i.value+'px');
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionLeft : function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        $(xml).find('reportElement').attr("x", parseInt(i.value));
        $("#"+ViewProperties.elementSelected).css("left",i.value+'px');
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionTop : function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        $(xml).find('reportElement').attr("y", parseInt(i.value));
		$("#"+ViewProperties.elementSelected).css("top",i.value+'px');
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionBackgroundColor : function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        if($(xml).find('style').length > 0)
        {
            $(xml).find('style').attr("backcolor", i.value);
        }else
        {
            $(xml).find('reportElement').attr("backcolor", i.value);
        }

        $("#"+ViewProperties.elementSelected).css("background-color",i.value);
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionForeColor : function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        if($(xml).find('style').length > 0)
        {
            $(xml).find('style').attr("forecolor", i.value);
        }else
        {
            $(xml).find('reportElement').attr("forecolor", i.value);
        }

		$("#"+ViewProperties.elementSelected).css("color",i.value);
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
    },actionBorderRadius : function (i) {
		$("#"+ViewProperties.elementSelected).css("border-radius",i.value+'px');
	},actionPen : function (i) {
		$("#"+ViewProperties.elementSelected).css({"border-width":"5px","border-style":i.value});
	},rgb2hex : function (rgb){
		 rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
		 return (rgb && rgb.length === 4) ? 
		  ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
		  ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
		  ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
	},

	actionFontSize : function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
		$("#"+ViewProperties.elementSelected).css("font-size",i.value+"px");
        //XML PARA ESTILOS
		if($(xml).find('style').length > 0)
        {
            $(xml).find('style').attr("fontSize",i.value);
        }else if($(xml).find('textElement').find('font').length > 0)
        {
            $(xml).find('textElement').find('font').attr("size",i.value);
        }else
        {
            $(xml).find('staticText').find('reportElement').after( '<textElement><font size="'+i.value+'"/></textElement>');
        }
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionAlignment : function (i) {
		var position ;
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
		switch (i.value) {
		    case 'Izquierda':
                position = 'Left';
			  	$("#"+ViewProperties.elementSelected).css("text-align","left");
		    break;	    
		    case 'Centrado':
                position = 'Center';
		    	$("#"+ViewProperties.elementSelected).css("text-align","center");
		    break;  
		    case 'Derecha':
                position = 'Right';
		    	$("#"+ViewProperties.elementSelected).css("text-align","right");
		    break;  		    	    		    		       	      	    
		    case 'Justificado':
                position = 'Justified';
		    	$("#"+ViewProperties.elementSelected).css("text-align","justify");
		    break;	    		    
		}
		console.log(xml);
        console.log($(xml).find('staticText').find('textElement').length);

        if($(xml).find('style').length > 0)
        {
            $(xml).find('style').attr("hAlign",position)
        }else if($(xml).find('staticText').find('textElement').length > 0)
		{
            $(xml).find('staticText').find('textElement').attr("textAlignment",position);
		}else
		{
            $(xml).find('staticText').find('reportElement').after( '<textElement textAlignment="'+position+'"/>');
		}
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionVerticalAlignment : function (i) {
        var position ;
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
		switch (i.value) {
		    case 'Superior':
                position = 'Top';
			  	$("#"+ViewProperties.elementSelected).css("vertical-align","text-top");
		    break;	    
		    case 'Medio':
                position = 'Middle';
                $("#"+ViewProperties.elementSelected).css("vertical-align","middle");
		    break;  
		    case 'Inferior':
                position = 'Bottom';
                $("#"+ViewProperties.elementSelected).css("vertical-align","bottom");
		    break;  		    	    		    		       	      	       		    
		}
        console.log(xml);
		console.log($(xml).find('staticText').find('textElement').length);
        if($(xml).find('style').length > 0)
        {
            $(xml).find('style').attr("vAlign",position)
        }else if($(xml).find('staticText').find('textElement').length > 0)
        {
            $(xml).find('staticText').find('textElement').attr("verticalAlignment",position);
        }else
        {
            $(xml).find('staticText').find('reportElement').after('<textElement verticalAlignment="'+position+'"/>');
        }
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionBold : function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
		var type;
            if (i.checked) 
            {
            	type = 'true';
            	$("#"+ViewProperties.elementSelected).css('font-weight', 'bold');            	
            }
            else
            {
            	type = 'false';
            	$("#"+ViewProperties.elementSelected).css('font-weight', 'normal');            	
            }

        if($(xml).find('style').length > 0)
        {
            $(xml).find('style').attr("isBold",type)
        }else if($(xml).find('textElement').find('font').length > 0)
        {
            $(xml).find('textElement').find('font').attr("isBold",type);
        }else
        {
            $(xml).find('staticText').find('reportElement').after('<textElement><font isBold="'+type+'"/></textElement>');
        }
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionItalic: function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        var type;

            if (i.checked)
            {
                type = 'true';
                $("#"+ViewProperties.elementSelected).css('font-style', 'italic');
            }
			else
			{
                type = 'false';
                $("#"+ViewProperties.elementSelected).css('font-style', 'normal');
            }



        if($(xml).find('style').length > 0)
        {
            $(xml).find('style').attr("isItalic",type);
        }else if($(xml).find('textElement').find('font').length > 0)
        {
            $(xml).find('textElement').find('font').attr("isItalic",type);
        }else
        {
            $(xml).find('staticText').find('reportElement').after('<textElement><font isItalic=="'+type+'"/></textElement>');
        }
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionUnderline : function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        var type;
            if (i.checked)
			{
				type='true';
				$("#"+ViewProperties.elementSelected).css('text-decoration', 'underline');
            }else
			{
                type='false';
				$("#"+ViewProperties.elementSelected).css('text-decoration', 'none');
            }
        if($(xml).find('style').length > 0)
        {
            $(xml).find('style').attr("isUnderline",type);
        }else if($(xml).find('textElement').find('font').length > 0)
        {
            $(xml).find('textElement').find('font').attr("isUnderline",type);
        }else
        {
            $(xml).find('staticText').find('reportElement').after('<textElement><font isUnderline=="'+type+'"/></textElement>');
        }
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionStrikeThorugh : function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        var type;
			if (i.checked)
			{
				type = 'true';
				$("#"+ViewProperties.elementSelected).css('text-decoration', 'line-through');
            }else
			{
				type = false;
				$("#"+ViewProperties.elementSelected).css('text-decoration', 'none');
            }

        if($(xml).find('style').length > 0)
        {
            $(xml).find('style').attr("isStrikeThrough",type);
        }else if($(xml).find('textElement').find('font').length > 0)
        {
            $(xml).find('textElement').find('font').attr("isStrikeThrough",type);
        }else
        {
            $(xml).find('staticText').find('reportElement').after('<textElement><font isStrikeThrough=="'+type+'"/></textElement>');
        }
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
	},actionSpaceLines : function (i) {

        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        var size = i.value;

        $("#"+ViewProperties.elementSelected).css('line-height',i.value+"px");

        if($(xml).find('style').length > 0)
        {
            if($(xml).find('style').find('paragraph').length > 0)
            {
                $(xml).find('style').find('paragraph').attr("lineSpacingSize",size);
            }else
            {
                $(xml).find('style').append('<paragraph lineSpacing="Proportional" lineSpacingSize="'+size+'"/>');
            }
        }else if($(xml).find('textElement').length > 0)
        {
            if($(xml).find('textElement').find('paragraph').length > 0)
            {
                $(xml).find('textElement').find('paragraph').attr("lineSpacingSize",size);
            }else
            {
                $(xml).find('staticText').find('textElement').append('<paragraph lineSpacing="Proportional" lineSpacingSize="'+size+'"/>');
            }

        }else
        {
            $(xml).find('staticText').find('reportElement').after('<textElement><paragraph lineSpacing="Proportional" lineSpacingSize="'+size+'"/></textElement>');
        }
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
    },actionName : function (i) {
        var xml = $.parseXML($("#"+ViewProperties.elementSelected).attr("data-xml"));
        //$(xml).find('reportElement').attr("height", parseInt(i.value));
        $('#'+ViewProperties.elementSelected).text(i.value);
        $("#"+ViewProperties.elementSelected).attr("data-xml",(new XMLSerializer()).serializeToString(xml));
    }
}