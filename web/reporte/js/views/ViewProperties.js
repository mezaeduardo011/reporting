ViewProperties = {}
ViewProperties = {
	elementSelected : (ViewProperties.elementSelected != undefined) ? ViewProperties.elementSelected:null,
	elementUsed : (ViewProperties.elementUsed != undefined) ? ViewProperties.elementUsed:null,
    elementFatherUsed : (ViewProperties.elementFatherUsed != undefined) ? ViewProperties.elementFatherUsed:null,
	titleProperties : '<h5 class="titleProperties">Propiedades</h5>',
	divMd12 : '<div class="col-md-12">',
	divBoxMd6 : '<div class="boxPropertie col-md-6">',
	nameProperty : 'TEST',
	divBoxMd6Close : '</div>',
	divBoxMd6 : '<div class="boxPropertie col-md-6">',
	inputProperty : '',
	divBoxMd6Close : '</div>',		    
	divMd12Close : '</div>',
	divProperty : '',
	setValues : undefined,
	containerProperties : $('.containerProperties'),
	containerPropertiesEspecific: $('.containerPropertiesEspecific'),
	main : function  () {
		var eventFrame = $('.elementPanel');

		eventFrame.click(function(){
		    var id = $(this).data("id");
	        var typeElement = $(this).data('element');  
			switch (typeElement) {
			    case 'Texto Estático': ViewProperties.setValuesProperties(Report.StaticText.checkValuesStaticText);
			    break;				
			    case 'Caja': ViewProperties.setValuesProperties(Report.Box.checkValuesBox);
			    break;			        
			}	
	        

			ViewProperties.cleanDivProperties();
			ModelProperties.getPropertiesDefault();
			ModelProperties.getPropertiesById(typeElement, id);
		});
	},cleanDivProperties : function (){
		ViewProperties.containerProperties.empty();
		ViewProperties.containerPropertiesEspecific.empty();
	},cutOutText : function (text){
		var limit   = 9;
		var lengthText = text.length;      
		if (limit < lengthText) { 
			 text = text.substring(0, limit)+'...';
	    }
	    return text;
	},addEventsInput : function (){
		$(".Fondo").val("#FFFFF");
		$(".Fondo").trigger('change');
		$(".Superficial").val("#000000");
		$(".Superficial").trigger('change');
		 
		$('.color').colorpicker();
		$(".numeric").keypress(function (e) {
		     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
             return false;
		});
		 $('.color').prop('type', 'text');
	},	ShowProperties : function (typeElement,id) {
		var route = "";
		var jsonId = {};
		var container = '';
		if(typeElement != undefined)
		{
			//para mostrar propiedades especificas
			route = "/reportes.php/getPropertiesByFatherId";
			jsonId  = {'id':id};	
			container = Report.PanelRight.containerPropertiesEspecific;
		}else 
		{	
			//Para mostrar propiedades por defecto
			route = "/reportes.php/getPropertiesDefault";
			container = Report.PanelRight.containerProperties;
		}
		
		$.get( route,jsonId,function( response ) {
			$.each(response.datos, function(i, data) {
				ViewProperties.writeProperty(data);
				ViewProperties.showProperty(container);
			}); 		
		});				



	},writeProperty : function (data) {
		Report.PanelRight.divProperty  = Report.PanelRight.divMd12;
		Report.PanelRight.divProperty  += Report.PanelRight.divBoxMd6;
		Report.PanelRight.divProperty  += '<small title="'+data.name_property+'">'+ViewProperties.cutOutText(data.name_property)+'</small>';
		Report.PanelRight.divProperty  += Report.PanelRight.divBoxMd6Close; 
		Report.PanelRight.divProperty  += Report.PanelRight.divBoxMd6;  
		Report.PanelRight.inputProperty = ViewProperties.buildInput(data);
		Report.PanelRight.divProperty  += Report.PanelRight.inputProperty; 
		Report.PanelRight.divProperty  += Report.PanelRight.divBoxMd6Close;
		Report.PanelRight.divProperty  += Report.PanelRight.divMd12Close;
	},showProperty : function (container) {
		container.append(Report.PanelRight.divProperty);
		Report.PanelRight.addEventsInput();
		ViewProperties.setValuesProperties();
	},cutOutText : function (text){
		var limit   = 9;
		var lengthText = text.length;      
		if (limit < lengthText) { 
			 text = text.substring(0, limit)+'...';
	    }

	    return text;
	},buildInput : function (data){
		switch (data.type_input) {
		    case 'color': return ViewProperties.buildInputText(data)
		    break;
		    case 'checkbox': return ViewProperties.buildInputCheck(data)
		    break;
		    case 'select': return ViewProperties.buildInputSelect(data)
		    break;
		    case 'numeric': return ViewProperties.buildInputText(data)
		    break;
		    case 'text': return ViewProperties.buildInputText(data.type_input)
		    break;
		    case 'dropdown-static': return ViewProperties.buildInputPen(data)
		    break;	
		    case 'button': return ViewProperties.buildButton(data)
		    break;
		    case 'NULL': return ViewProperties.buildInputText(data.type_input)
		    break;			        
		}	
	},buildInputText : function (data){
		var action = '';
		var value = '';
		var selected = (ViewProperties.elementSelected != undefined) ? true:false;
		switch (data.name_property) {
		    case 'Alto': 
		     value = (selected) ? 'value = "'+$('#'+ViewProperties.elementSelected).height()+'"':'';
		     action = 'onkeyup="ControllerProperties.actionHeiht(this)"';
		    break;
		    case 'Ancho': 
		    value = (selected) ? 'value = "'+$('#'+ViewProperties.elementSelected).width()+'"':'';
		    action = 'onkeyup="ControllerProperties.actionWidth(this)"';
		    break;
			case 'Color De Fondo':
			value = (selected) ? 'value = "'+ControllerProperties.rgb2hex($('#'+ViewProperties.elementSelected).css('backgroundColor'))+'"':'';
			action = 'onchange="ControllerProperties.actionBackgroundColor(this)"';
		    break;	
			case 'Color Superficial':
			value = (selected) ? 'value = "'+ControllerProperties.rgb2hex($('#'+ViewProperties.elementSelected).css('color'))+'"':'';
			action = 'onchange="ControllerProperties.actionForeColor(this)"';
		    break;			 
			case 'Izquierda':
			value = (selected) ? 'value = "'+$('#'+ViewProperties.elementSelected).css('left').replace('px', '')+'"':'';	
			action = 'onkeyup="ControllerProperties.actionLeft(this)"';
		    break;	
			case 'Superior':
		    value = (selected) ? 'value = "'+$('#'+ViewProperties.elementSelected).css('top').replace('px', '')+'"':'';
			action = 'onkeyup="ControllerProperties.actionTop(this)"';
		    break;			 
			case 'Borde Redondeado':
			value = (selected) ? 'value = "'+$('#'+ViewProperties.elementSelected).css('border-radius').replace('px', '')+'"':'';
			action = 'onkeyup="ControllerProperties.actionBorderRadius(this)"';
		    break;
			case 'Espacios En Líneas':
			value = (selected) ? 'value = "'+$('#'+ViewProperties.elementSelected).css('line-height').replace('px', '')+'"':'';
			action = 'onkeyup="ControllerProperties.actionSpaceLines(this)"';
		    break;		    
	    		    		       	      	    
		}	

		var disabled = (selected) ? '':'disabled';
		
		return '<input '+value+' '+disabled+' class="inputPropertie '+data.type_input+' '+data.name_property+'  '+ViewProperties.elementSelected+'" '+action+' type="text" name="">';		
	},buildInputCheck : function (data){
		var action = '';
		var value = '';
		var selected = (ViewProperties.elementSelected != undefined) ? true:false;		
		switch (data.name_property) {
		    case 'Bold': 
		     value = (selected) ? 'value = "Bold"':'';
		     action = 'onchange="ControllerProperties.actionBold(this)"';
		    break;
		    case 'Italic': 
		     value = (selected) ? 'value = "Italic"':'';
		     action = 'onchange="ControllerProperties.actionItalic(this)"';
		    break;
		    case 'Underline': 
		     value = (selected) ? 'value = "Underline"':'';
		     action = 'onchange="ControllerProperties.actionUnderline(this)"';
		    break;		
		    case 'Tachado': 
		     value = (selected) ? 'value = "Tachado"':'';
		     action = 'onchange="ControllerProperties.actionStrikeThorugh(this)"';
		    break;				        		    
	    		    	
	    		    		       	      	    
		}	
		var disabled = (selected) ? '':'disabled';

		return '<input '+disabled+' class="inputPropertie"' +ViewProperties.elementSelected+'"  '+action+' type="checkbox" name="'+data.name_property+'">';
		
	},buildInputPen : function (type){		
			var disabled = (ViewProperties.elementSelected != undefined) ? '':'disabled';
		    var select = '<select onchange="ControllerProperties.actionPen(this)" class="select '+ViewProperties.elementSelected+'" '+disabled+' style="color:black" id="selectPen">';
			select += '<option value="dashed">---------------</option>';
			select += '<option value="solid">_________</option>';
			select += '<option value="double">=========</option></select>';
			return select;			
	},buildInputSelect : function (data){


		var id = data.id;
		var action = '';
		var selected = (ViewProperties.elementSelected != undefined) ? true:false;

		    $.get( "/reportes.php/getValuesSelectById",{'id':id} ,function( response ) {
				var values  = response.datos[0].value;
				values = $.parseJSON(values);
				$.each(values, function(i, data) {
						$('#select_'+id).append($('<option>', {
						    value: data.option,
						    text: data.option
						}));				
			});	

		});			
		switch (data.name_property) {
		    case 'Tamaño': 
			    if (selected) 
		     	{
					$('#select_'+id).val($('#'+ViewProperties.elementSelected).css('font-size'));
		     	} 
		    	action = 'onchange="ControllerProperties.actionFontSize(this)"';
		    break;
		   
		    case 'Alineación Horizontal': 
			    if (selected) 
		     	{
					$('#select_'+id).val($('#'+ViewProperties.elementSelected).css('font-size'));
		     	} 
		    	action = 'onchange="ControllerProperties.actionAlignment(this)"';
		    break;		 

		    case 'Alineación Vertical': 
			    if (selected) 
		     	{
					$('#select_'+id).val($('#'+ViewProperties.elementSelected).css('font-size'));
		     	} 
		    	action = 'onchange="ControllerProperties.actionVerticalAlignment(this)"';
		    break;			       
	    		    		       	      	    
		}	


		var disabled = (selected) ? '':'disabled';
		return '<select class="select" data-tag="'+data.xml_tag+'" '+disabled+' style="color:black" '+action+' id="select_'+id+'"></select>';
	},buildButton : function () {
		return '<span onclick="editText()"><small class="label bg-red" style = "margin-left: 25%;height: 12px;cursor:pointer;">..................<small></span>';
	},setValuesProperties  : function (setValues){
		if (setValues != undefined) 
		{
			ViewProperties.setValues = setValues;
		}else   
		{
			ViewProperties.setValues();
		}
		
	}
}