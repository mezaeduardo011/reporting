Report.PanelRight = {}
Report.PanelRight = {
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
	containerProperties : $('.containerProperties'),
	containerPropertiesEspecific: $('.containerPropertiesEspecific'),
	main : function  () {
		this.getEventPanel();
	},
	getEventPanel : function () {

		var eventFrame = $('.elementPanel');
		eventFrame.click(function(){
		Report.PanelRight.cleanDivProperties();
		Report.Properties.ShowProperties();
	    var id = $(this).data("id");
        var typeElement = $('#'+id).data('element');                
  		Report.Properties.ShowProperties(typeElement,id);
		});
				
	},desabledClcikElement : function (){
		element.removeClass("active");
		element.addClass("disabled");
	},cleanDivProperties : function (){
		Report.PanelRight.containerProperties.empty();
		Report.PanelRight.containerPropertiesEspecific.empty();
	},cutOutText : function (text){
		var limit   = 9;
		var lengthText = text.length;      
		if (limit < lengthText) { 
			 text = text.substring(0, limit)+'...';
	    }
	    return text;
	},addEventsInput : function (){
		

		if($("#"+ViewProperties.elementSelected).css('background-color') == 'rgb(0, 0, 0)'){
			$("#"+ViewProperties.elementSelected).css('background-color','rgb(255, 255, 255)');
		}

		if($("#"+ViewProperties.elementSelected).css('color') == 'rgb(0, 0, 0)'){
			$("#"+ViewProperties.elementSelected).css('color','rgb(255, 255, 255)');
		}

		 
		$('.color').colorpicker();
		$(".numeric").keypress(function (e) {
		     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
             return false;
		});
		 $('.color').prop('type', 'text');
	}
}