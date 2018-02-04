
Core.Menu = {};
Core.Menu = {
    html:'',
    main: function () {
        this.crearMenu();
    },
    crearMenu: function () {
        $.post('/refreshMenu',function (dataJson) {
            Core.Menu.html = '';
            Core.Menu.html += '<li class="header">MENU DE DATOS</li>';
            //Core.Menu.html += '<li class="header">MENU DE '+dataJson.app+'</li>';
            $.each(dataJson.menu.ADMIN, function (ind0,val0) {
            	//alert(ind0+'----'+val0);
            	 Core.Menu.html += '<li class="treeview">';
                 Core.Menu.html += '<a href="#">';
                 Core.Menu.html += '<i class="fa '+val0.item.icon_fa+'" aria-hidden="true"></i>';
                 Core.Menu.html += '<span class="capit"> '+val0.item.nombre.toLowerCase()+'</span>';
                 Core.Menu.html += '<span class="pull-right-container">';
                 var cant=0;
                 $.each(val0.submenu, function (inx1,val1) {
                     //alert(inx1+'----'+val1);
                     if(val1!='') {
                         cant++;
                     }
                 });
                 Core.Menu.html += '<span class="label label-primary pull-right">'+cant +'</span>';
                 Core.Menu.html += '</span>';
                 Core.Menu.html += '</a>';
                 Core.Menu.html += '<ul class="treeview-menu">';
            	$.each(val0.submenu,function (inx1,val1) {
                	 //alert(inx1+'----'+val1);
                    if(val1!=''){
                       
                       // $.each(val1.submenu, function (ind2,val2) {
                            Core.Menu.html += '<li class="dropdown capit">';
                            Core.Menu.html += '   <a href="/'+val1.vista+'Index"  class="fa '+val1.icon_fa+'" target="'+val1.targe+'"> '+val1.nombre+'</a>';
                            Core.Menu.html += '</li>';
                       //})
                   }
                });
            	 Core.Menu.html += '</ul>';
            	Core.Menu.html += '</li>';
            });
            $('#menu').html(Core.Menu.html);
        })
    }

}
