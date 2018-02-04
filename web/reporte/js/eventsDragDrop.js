Report.EventsDragDrop = {}
Report.EventsDragDrop = {
	main : function  () {
		
	},
	drag : function (e){
		e.dataTransfer.setData("Text",e.target.id);
	},
	hojaDrop : function (e){
	   e.preventDefault();
	   var id =e.dataTransfer.getData("Text");
	   console.log(id);
       var text = $('#'+id).data('element');                 
	   var textnode = document.createTextNode(text);
		switch (text) {
		    case 'Caja': 
		    	Report.Box.main();
		    	Report.Box.newBox(e);
		    	Report.PanelLeft.addTitle(Report.Box.idBox);

		    break;
		    case 'Texto Estático': 
		    	Report.StaticText.main('staticText');
		    	Report.StaticText.newStaticText(e);
		    	Report.PanelLeft.addTitle(Report.StaticText.idStaticText);
		    break;
            case 'Campo':
                Report.StaticText.main($.trim($('#'+id).text()));
                Report.StaticText.newStaticText(e);
                Report.PanelLeft.addTitle(Report.StaticText.idStaticText);
                break;
		}	     	   
	}, elementDrop : function (e,father){
        e.preventDefault();
        ViewProperties.containmentFather = father;
    },
    allowDrop : function (e){
		e.preventDefault();
	}
}