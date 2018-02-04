ModelProperties = {}  
ModelProperties = {
	main : function  () {

	},getPropertiesDefault : function () {
		//Metodo para obtener propiedades por defecto
		var route = "";
		var jsonId = {};
		var container = '';
		route = "/reportes.php/getPropertiesDefault";
		container = Report.PanelRight.containerProperties;
		$.get( route,jsonId,function( response ) {
			$.each(response.datos, function(i, data) {
				ViewProperties.writeProperty(data);
				ViewProperties.showProperty(container);
			}); 		
		});				

	},getPropertiesById : function (typeElement,id) {
		//Metodo para obtener propiedades por id
		var route = "";
		var jsonId = {};
		var container = '';
		//para mostrar propiedades especificas
		route = "/reportes.php/getPropertiesByFatherId";
		jsonId  = {'id':id};	
		container = Report.PanelRight.containerPropertiesEspecific;
		$.get( route,jsonId,function( response ) {
			$.each(response.datos, function(i, data) {
				ViewProperties.writeProperty(data);
				ViewProperties.showProperty(container);
			}); 		
		});			
	}
}