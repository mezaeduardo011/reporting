var Report = {}
Report = {
	main : function(){
		//Report.Elements.main();
		Report.EventsDragDrop.main();
		//Report.PanelRight.main();
		Report.PanelLeft.main();		
		ViewProperties.main();

		$('.borderHoja').click(function(e){
            $('.ui-resizable-handle').hide();
            ViewProperties.elementSelected = null;
            ViewProperties.elementUsed = null;
            e.stopPropagation();
        });
	},addIconsResize : function (element) {
        var divArrow = document.createElement("div");
        divArrow.className= "ui-resizable-handle ui-resizable-n customRes";
        divArrow.style = "width: 10px;top: -13px;";
        element.appendChild(divArrow);
        var divArrow = document.createElement("div");
        divArrow.className= "ui-resizable-handle ui-resizable-e";
        divArrow.style = "height: 10px;right: -13px;";
        element.appendChild(divArrow);
        var divArrow = document.createElement("div");
        divArrow.className= "ui-resizable-handle ui-resizable-s";
        divArrow.style = "width: 10px;bottom: -13px;";
        element.appendChild(divArrow);
        var divArrow = document.createElement("div");
        divArrow.className= "ui-resizable-handle ui-resizable-w";
        divArrow.style = "height: 10px;left: -13px;";
        element.appendChild(divArrow);
        var divArrow = document.createElement("div");
        divArrow.className= "ui-resizable-handle ui-resizable-ne";
        divArrow.style = "width: 10px;right: -13px;";
        element.appendChild(divArrow);

        var divArrow = document.createElement("div");
        divArrow.className= "ui-resizable-handle ui-resizable-se";
        divArrow.style = "width: 10px;bottom: -5px;height: 10px;right: -13px;";
        element.appendChild(divArrow);

        var divArrow = document.createElement("div");
        divArrow.className= "ui-resizable-handle ui-resizable-sw";
        divArrow.style = "width: 10px;left: -13px;";
        element.appendChild(divArrow);

        var divArrow = document.createElement("div");
        divArrow.className= "ui-resizable-handle ui-resizable-nw";
        divArrow.style = "width: 10px;top: -13px;";
        element.appendChild(divArrow);

    },resizableElements : function () {
        if (typeof String.prototype.start_with != 'function') {
            String.prototype.start_with = function (str){
                return this.slice(0, str.length) == str;
            };
        }
        function inspect(e, options) {
            if(options==null){
                options = {};
            }
            var onlykey = options['onlykey']==null ? false : options['onlykey']
            var prefix = options['prefix']==null ? '' : options['prefix']
            var msg = new Array();
            for (prop in e) {
                if(prop.start_with(prefix)){
                    if(onlykey==true){
                        msg.push(prop);
                    }else{
                        msg.push(prop + ": " + e[prop]);
                    }
                }

            };

            if(onlykey==true){
                $("#cl").html(msg.join(', '));
            }else{
                $("#cl").html(msg.join('\n'));
            }

        }
        var set_position = function(width, height){

            $('.ui-resizable-n').each(function () {
                if( $(this).parent().get( 0 ).id ==  ViewProperties.elementSelected){
                    $(this).css('left', (width/2-4)+'px');
                }
            });

            $('.ui-resizable-e').each(function () {
                if( $(this).parent().get( 0 ).id ==  ViewProperties.elementSelected){
                    $(this).css('top', (height/2-4)+'px');
                }
            });

            $('.ui-resizable-s').each(function () {
                if( $(this).parent().get( 0 ).id ==  ViewProperties.elementSelected){
                    $(this).css('left', (width/2-4)+'px');
                }
            });

            $('.ui-resizable-w').each(function () {
                if( $(this).parent().get( 0 ).id ==  ViewProperties.elementSelected){
                    $(this).css('top', (height/2-4)+'px');
                }
            });
        };

        $( "#"+ViewProperties.elementUsed).resizable({
            containment: $('#'+ViewProperties.containmentFather),
            handles: {
                'n':'.ui-resizable-n',
                'e':'.ui-resizable-e',
                's':'.ui-resizable-s',
                'w':'.ui-resizable-w',
                'ne': '.ui-resizable-ne',
                'se': '.ui-resizable-se',
                'sw': '.ui-resizable-sw',
                'nw': '.ui-resizable-nw'
            },
            grid: [ 10, 10 ],
            //helper: "ui-resizable-helper",
            create: function( event, ui ) {
                //alert(ui.element);
                //inspect(event.target, {'onlykey':true});

                var width = $(event.target).width();
                var height = $(event.target).height();
                    set_position(width, height);

            },
            resize: function(event, ui){
                var width = $(event.target).width();
                var height = $(event.target).height();
                set_position(width, height);
            },
            alsoResize: "#rect1"
        });
        console.log(ViewProperties.containmentFather);
        $( "#"+ViewProperties.elementUsed).draggable({
            containment: $('#'+ViewProperties.containmentFather),
            grid: [ 5, 5 ]
        });
    }
}

document.write('<script src="/reporte/js/panelRight.js"></script>')
document.write('<script src="/reporte/js/panelLeft.js"></script>')

//Drag and Drop
document.write('<script src="/reporte/js/eventsDragDrop.js"></script>')

//Properties
document.write('<script src="/reporte/js/properties.js"></script>')


document.write('<script src="/reporte/js/views/ViewProperties.js"></script>')
document.write('<script src="/reporte/js/controllers/ControllerProperties.js"></script>')
document.write('<script src="/reporte/js/models/ModelProperties.js"></script>')




//Elements
document.write('<script src="/reporte/js/elements.js"></script>')

document.write('<script src="/reporte/js/box.js"></script>')
document.write('<script src="/reporte/js/staticText.js"></script>')
document.write('<script src="/reporte/js/style.js"></script>')
document.write('<script src="/reporte/js/parameters.js"></script>')
