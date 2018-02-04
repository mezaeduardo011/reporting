Report.Properties = {}
Report.Properties = {
		elementSelected : (Report.Properties.elementSelected != undefined) ? Report.Properties.elementSelected:null,
		main : function  () {
		this.getEventPanel();
		this.capturarEventosHoja();
	},
	ShowDefaultProperties : function () {

		$.get( "/reportes.php/getPropertiesDefault",{},function( response ) {

			$.each(response.datos, function(i, data) {
				Report.Properties.writeProperty(data);
				Report.Properties.showProperty(Report.PanelRight.containerProperties);
			}); 		
		});				

	},
	ShowSpecificProperties : function (id) {
		$.get( "/reportes.php/getPropertiesByFatherId",{'id':id} ,function( response ) {
			$.each(response.datos, function(i, data) {
				Report.Properties.writeProperty(data);
				Report.Properties.showProperty(Report.PanelRight.containerPropertiesEspecific);
			}); 		
		});				

	},ShowProperties : function (typeElement,id) {
		var route = "";
		var id = {};
		var container = '';
		if(typeElement != undefined)
		{
			//para mostrar propiedades especificas
			route = "/reportes.php/getPropertiesByFatherId";
			id  = {'id':id};	
			container = Report.PanelRight.containerPropertiesEspecific;
		}else 
		{	
			//Para mostrar propiedades por defecto
			route = "/reportes.php/getPropertiesDefault";
			container = Report.PanelRight.containerProperties;
		}
		
		$.get( route,id,function( response ) {
			$.each(response.datos, function(i, data) {
				Report.Properties.writeProperty(data);
				Report.Properties.showProperty(container);
			}); 		
		});				

	},writeProperty : function (data) {
		Report.PanelRight.divProperty  = Report.PanelRight.divMd12;
		Report.PanelRight.divProperty  += Report.PanelRight.divBoxMd6;
		Report.PanelRight.divProperty  += '<small title="'+data.name_property+'">'+Report.Properties.cutOutText(data.name_property)+'</small>';
		Report.PanelRight.divProperty  += Report.PanelRight.divBoxMd6Close; 
		Report.PanelRight.divProperty  += Report.PanelRight.divBoxMd6;  
		Report.PanelRight.inputProperty = Report.Properties.buildInput(data);
		Report.PanelRight.divProperty  += Report.PanelRight.inputProperty; 
		Report.PanelRight.divProperty  += Report.PanelRight.divBoxMd6Close;
		Report.PanelRight.divProperty  += Report.PanelRight.divMd12Close;
	},showProperty : function (container) {
		container.append(Report.PanelRight.divProperty);
		Report.PanelRight.addEventsInput();
	},cutOutText : function (text){
		var limit   = 9;
		var lengthText = text.length;      
		if (limit < lengthText) { 
			 text = text.substring(0, limit)+'...';
	    }

	    return text;
	},buildInput : function (data){
		switch (data.type_input) {
		    case 'color': return Report.Properties.buildInputText(data)
		    break;
		    case 'checkbox': return Report.Properties.buildInputCheck(data.type_input)
		    break;
		    case 'select': return Report.Properties.buildInputSelect(data)
		    break;
		    case 'numeric': return Report.Properties.buildInputText(data)
		    break;
		    case 'text': return Report.Properties.buildInputText(data.type_input)
		    break;
		    case 'dropdown-static': return Report.Properties.buildInputPen(data)
		    break;
		    case 'NULL': return Report.Properties.buildInputText(data.type_input)
		    break;		    
		}	
	},buildInputText : function (data){
		var action = '';
		var value = '';
		var selected = (Report.Properties.elementSelected != undefined) ? true:false;
		switch (data.name_property) {
		    case 'Alto': 
		     value = (selected) ? 'value = "'+$('#'+Report.Properties.elementSelected).height()+'"':'';
		     action = 'onkeyup="Report.Properties.actionHeiht(this)"';
		    break;
		    case 'Ancho': 
		    value = (selected) ? 'value = "'+$('#'+Report.Properties.elementSelected).width()+'"':'';
		    action = 'onkeyup="Report.Properties.actionWidth(this)"';
		    break;
			case 'Color De Fondo':
			value = (selected) ? 'value = "'+Report.Properties.rgb2hex($('#'+Report.Properties.elementSelected).css('backgroundColor'))+'"':'';
			action = 'onchange="Report.Properties.actionBackgroundColor(this)"';
		    break;	
			case 'Color Superficial':
			value = (selected) ? 'value = "'+Report.Properties.rgb2hex($('#'+Report.Properties.elementSelected).css('color'))+'"':'';
			action = 'onchange="Report.Properties.actionForeColor(this)"';
		    break;			 
			case 'Izquierda':
			value = (selected) ? 'value = "'+$('#'+Report.Properties.elementSelected).css('left').replace('px', '')+'"':'';	
			action = 'onkeyup="Report.Properties.actionLeft(this)"';
		    break;	
			case 'Superior':
		    value = (selected) ? 'value = "'+$('#'+Report.Properties.elementSelected).css('top').replace('px', '')+'"':'';
			action = 'onkeyup="Report.Properties.actionTop(this)"';
		    break;			 
			case 'Borde Redondeado':
			value = (selected) ? 'value = "'+$('#'+Report.Properties.elementSelected).css('border-radius').replace('px', '')+'"':'';
			action = 'onkeyup="Report.Properties.actionBorderRadius(this)"';
		    break;
		    /*CAMPOS DE TEXTO ESTATICO*/
			case 'Tamaño':
			value = (selected) ? 'value = "'+$('#'+Report.Properties.elementSelected).css('border-radius').replace('px', '')+'"':'';
			action = 'onkeyup="Report.Properties.actionBorderRadius(this)"';
		    break;		    		    		       	      	    
		}	

		var disabled = (selected) ? '':'disabled';
		
		return '<input '+value+' '+disabled+' class="inputPropertie '+data.type_input+' '+data.name_property+'  '+Report.Properties.elementSelected+'" '+action+' type="text" name="">';		
	},buildInputCheck : function (type){
		var disabled = (Report.Properties.elementSelected != undefined) ? '':'disabled';
		return '<input '+disabled+' class="inputPropertie '+type+' '+Report.Properties.elementSelected+'"  type="checkbox" name="">';
	},buildInputPen : function (type){		
			var disabled = (Report.Properties.elementSelected != undefined) ? '':'disabled';
		    var select = '<select onchange="Report.Properties.actionPen(this)" class="select '+Report.Properties.elementSelected+'" '+disabled+' style="color:black" id="selectPen">';
			select += '<option value="dashed">---------------</option>';
			select += '<option value="solid">_________</option>';
			select += '<option value="double">=========</option></select>';
			return select;			
	},buildInputSelect : function (data){
		var id = data.id;
		var disabled = (Report.Properties.elementSelected != undefined) ? '':'disabled';

		    $.get( "/reportes.php/getValuesSelectById",{'id':id} ,function( response ) {
				var values  = response.datos[0].value;
				values = $.parseJSON(values);
				$.each(values, function(i, data) {
						$('#select_'+id).append($('<option>', {
						    value: 1,
						    text: data.option
						}));				
			});	

		});				
		
		return '<select class="select" '+disabled+' style="color:black" id="select_'+id+'"></select>';
	},actionHeiht : function (i){
		$('#'+Report.Properties.elementSelected).height(i.value+'px');
	},actionWidth : function (i){
		$('#'+Report.Properties.elementSelected).width(i.value+'px');
	},actionLeft : function (i) {
		$("#"+Report.Properties.elementSelected).css("left",i.value+'px');
	},actionTop : function (i) {
		$("#"+Report.Properties.elementSelected).css("top",i.value+'px');
	},actionBackgroundColor : function (i) {
		$("#"+Report.Properties.elementSelected).css("background-color",i.value);
	},actionForeColor : function (i) {
		$("#"+Report.Properties.elementSelected).css("color",i.value);
	},actionBorderRadius : function (i) {
		$("#"+Report.Properties.elementSelected).css("border-radius",i.value+'px');
	},actionPen : function (i) {
		$("#"+Report.Properties.elementSelected).css({"border-width":"5px","border-style":i.value});
	},rgb2hex : function (rgb){
		 rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
		 return (rgb && rgb.length === 4) ? 
		  ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
		  ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
		  ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
	},

	/*ACCIONES DE TEXTO ESTATICO*/
	actionSize : function (i) {
		$("#"+Report.Properties.elementSelected).css("font-size",i.value);
	}
}