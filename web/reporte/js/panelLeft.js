Report.PanelLeft = {}
Report.PanelLeft = {
	main : function  () {
		
	},addTitle : function (elementSelected) {
        var li = document.createElement("li");
        var a = document.createElement("a");
        var i = document.createElement("i");        
        li.id = "i"+elementSelected;
        i.className = "fa fa-circle-o";
        a.append(i);        
        a.append(elementSelected);
        li.onclick = function () {
		   $('#'+elementSelected).trigger('mousedown');
		};  
        li.append( a );
        $('#ulTitle').append(li);
	}

}