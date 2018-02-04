ControllerProperties = {}
ControllerProperties = {
	main : function (){},
	/*Acciones por defecto*/
	actionHeiht : function (i){
		$('#'+ViewProperties.elementSelected).height(i.value+'px');
	},actionWidth : function (i){
		$('#'+ViewProperties.elementSelected).width(i.value+'px');
	},actionLeft : function (i) {
		$("#"+ViewProperties.elementSelected).css("left",i.value+'px');
	},actionTop : function (i) {
		$("#"+ViewProperties.elementSelected).css("top",i.value+'px');
	},actionBackgroundColor : function (i) {
		$("#"+ViewProperties.elementSelected).css("background-color",i.value);
	},actionForeColor : function (i) {
		$("#"+ViewProperties.elementSelected).css("color",i.value);
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

	/*ACCIONES DE TEXTO ESTATICO*/
	actionFontSize : function (i) {
		$("#"+ViewProperties.elementSelected).css("font-size",i.value+"px");
	},actionAlignment : function (i) {
		switch (i.value) {
		    case 'Izquierda': 
			  	$("#"+ViewProperties.elementSelected).css("text-align","left");
		    break;	    
		    case 'Centrado': 
			  	$("#"+ViewProperties.elementSelected).css("text-align","center");
		    break;  
		    case 'Derecha': 
			  	$("#"+ViewProperties.elementSelected).css("text-align","right");
		    break;  		    	    		    		       	      	    
		    case 'Justificado': 
			  	$("#"+ViewProperties.elementSelected).css("text-align","justify");
		    break;	    		    
		}	
	},actionVerticalAlignment : function (i) {
		switch (i.value) {
		    case 'Superior': 
			  	$("#"+ViewProperties.elementSelected).css("vertical-align","text-top");
		    break;	    
		    case 'Medio': 
			  	$("#"+ViewProperties.elementSelected).css("vertical-align","middle");
		    break;  
		    case 'Inferior': 
			  	$("#"+ViewProperties.elementSelected).css("vertical-align","bottom");
		    break;  		    	    		    		       	      	       		    
		}	
	},actionBold : function (i) {


            if (i.checked) 
            {
            	$("#"+ViewProperties.elementSelected).css('font-weight', 'bold');            	
            }
            else
            {
            	$("#"+ViewProperties.elementSelected).css('font-weight', 'normal');            	
            } 


	},actionItalic: function (i) {            
            if (i.checked) 
            	$("#"+ViewProperties.elementSelected).css('font-style', 'italic');
            else 
            $("#"+ViewProperties.elementSelected).css('font-style', 'normal');
	},actionUnderline : function (i) {
            
            if (i.checked) 
            	$("#"+ViewProperties.elementSelected).css('text-decoration', 'underline');
            else 
            $("#"+ViewProperties.elementSelected).css('text-decoration', 'none');
	},actionStrikeThorugh : function (i) {
            if (i.checked) 
            	$("#"+ViewProperties.elementSelected).css('text-decoration', 'line-through');
            else 
            $("#"+ViewProperties.elementSelected).css('text-decoration', 'none');
	},actionSpaceLines : function (i) {
           	$("#"+ViewProperties.elementSelected).css('line-height',i.value+"px");
	}
}