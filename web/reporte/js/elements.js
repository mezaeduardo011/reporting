Report.Elements = {} 
Report.Elements = {
	color : "red",
	main : function  () {
		//this.getEventPanel();
		//this.capturarEventosHoja();
	},
	capturarEventosHoja : function () {

		var hoja = $('.hoja');

		hoja.click(function(e){
			//Report.Elements.hideButtonsElement();
			//hoja.prop('onclick',null).off('click');
		});

				
	},	
	getEventPanel : function () {
		var eventFrame = $('.eventFrame');

		eventFrame.click(function(){
			//Report.Elements.ShowProperties(id);
		});
				
	},	
	capturarEventosFrame : function (element) {
		var eventFrame = element;

		var moveElement = $('.moveElement');
		moveElement.click(function(){
			Report.Elements.moveElement('elementFrame','arrowsFrame');
		});

		var addWidth = $('.addWidth');
		addWidth.click(function(){
			Report.Elements.addWidth('elementFrame','arrowsFrame');
		});

		var removeWidth = $('.removeWidth');
		removeWidth.click(function(){
			Report.Elements.removeWidth('elementFrame','arrowsFrame');
		});


		var addHeight = $('.addHeight');
		addHeight.click(function(){
			Report.Elements.addHeight('elementFrame','arrowsFrame');
		});

				
	},
	createElement : function  (nameElement) {
          var arrowsFrame = '<div class="arrowsFrame">';
            var iTop = '<i class="fa fa-plus-square addHeight" aria-hidden="true"></i>';
            var iRight = '<i class="fa fa-plus-square addWidth" aria-hidden="true"></i>';
            var iLeft = '<i class="fa fa-minus-square removeWidth" aria-hidden="true"></i>';
            var iDown = '<i class="fa fa-minus-square arrowDown" aria-hidden="true"></i>';
            var elementFrame = '<div class="elementFrame">';
                var iCenter = '<i class="fa fa-arrows moveElement" aria-hidden="true"></i>';
                    iCenter += '<i class="fa fa-stop-circle-o stopMove" aria-hidden="true"></i>';
            var elementFrameCl = '</div>';
          var arrowsFrameCl = '</div>';
          var element = arrowsFrame+iTop+iRight+iLeft+iDown+elementFrame+iCenter+elementFrameCl+arrowsFrameCl;
       $('.hoja').append(element);
       var ul = $('.elementsAdded');
       var li = 'elementFrameLi';
       ul.append('<li class="active '+li+'" style="cursor:pointer;background:#1269A7;"><a><i class="fa fa-circle-o"></i>'+nameElement.toUpperCase()+'</a></li>');
       Report.Elements.capturarEventosFrame($('.eventFrame'));
       Report.Elements.eventLi(ul,li);
	},
	addWidth : function (nameElement,nameParent){
		   
		   $('.removeWidth').show();
		   $('.moveElement').show();
		   var newWidth = parseInt($('.elementFrame').width()) + 100;
		   if(newWidth > 570)
		   	newWidth = 570;
		   $( '.'+nameElement ).animate({
		    width: newWidth+"px"
		  }, 100 );	


		   var currentWidthParent = (parseInt($('.'+nameParent).width()) <= 0)? 30 : parseInt($('.'+nameParent).width());
		   var newWidthAdd = currentWidthParent + 100;
		   if(newWidthAdd > 599)
		   {
			newWidthAdd = 599;
			$('.arrowsFrame').css('margin-left','0');
		   }
		   	
		   			   		   
		   $( '.'+nameParent ).animate({
		    width: newWidthAdd+"px"
		  }, 100 );				  	


		   var newMarginLeftTop = (newWidthAdd / 2) - 5;
		   $( '.addHeight' ).animate({
		    marginLeft: newMarginLeftTop+"px"
		  }, 100 );	
		   
		   var newMarginLeftDown = (newWidthAdd / 2) - 5;
		   $( '.arrowDown' ).animate({
		    marginLeft: newMarginLeftDown+"px"
		  }, 100 );		

		  var newCenterArrows = 49;
		   $( '.moveElement' ).animate({
		    left: newCenterArrows+"%"
		  }, 100 );		

		  var newCenterStopArrows = 49;
		   $( '.stopMove' ).animate({
		    left: newCenterStopArrows+"%"
		  }, 100 );		    

	},
	removeWidth : function (nameElement,nameParent){

		   var newWidth = parseInt($('.elementFrame').width()) - 100;
		   if(newWidth <= 25){
		   		$( '.moveElement' ).hide();
		   }		   	
		   $( '.'+nameElement ).animate({
		    width: newWidth+"px"
		  }, 100 );	



		   var newWidthAdd = parseInt($('.'+nameParent).width()) - 100;
		   if(newWidthAdd < 0){
		   		$( '.moveElement' ).hide();
		   		$('.removeWidth').hide();
		   		newWidthAdd = 30;
		   }
		   			   
		   $( '.'+nameParent ).animate({
		    width: newWidthAdd+"px"
		  }, 100 );				  	


		   var newMarginLeftTop = (newWidthAdd / 2) - 5;
		   $( '.arrowTop' ).animate({
		    marginLeft: newMarginLeftTop+"px"
		  }, 100 );	
		   
		   var newMarginLeftDown = (newWidthAdd / 2) - 5;
		   $( '.arrowDown' ).animate({
		    marginLeft: newMarginLeftDown+"px"
		  }, 100 );		

		   var newMarginLeftTop = (newWidthAdd / 2) - 5;
		   $( '.addHeight' ).animate({
		    marginLeft: newMarginLeftTop+"px"
		  }, 100 );			   

		  var newCenterArrows = 49;
		   $( '.moveElement' ).animate({
		    left: newCenterArrows+"%"
		  }, 100 );		  

		  var newCenterStopArrows = 49;
		   $( '.stopMove' ).animate({
		    left: newCenterStopArrows+"%"
		  }, 100 );			   

	},
	addHeight : function (nameElement,nameParent){
		   
		   var newHeightFrame = parseInt($('.elementFrame').height()) + 100;
		   if(newHeightFrame > 663)
		   {
			newHeightFrame = 663;
			$('.arrowsFrame').css('margin-top','1%');
		   }		   
		   $( '.'+nameElement ).animate({
		    height: newHeightFrame+"px"
		  }, 100 );	


		   var currentHeightParent = (parseInt($('.'+nameParent).height()) <= 0)? 30 : parseInt($('.'+nameParent).height());
		   var newHeightAdd = currentHeightParent + 100;
		   if(newHeightAdd > 693)
		   {
			newHeightAdd = 693;
			$('.arrowsFrame').css('margin-top','0');
		   }
		   	
		   			   		   
		   $( '.'+nameParent ).animate({
		    height: newHeightAdd+"px"
		  }, 100 );				  	

		   
		   var newMarginWidthAdd = (newHeightAdd / 2) - 5;
		   $( '.addWidth' ).animate({
		    marginTop: newMarginWidthAdd+"px"
		  }, 100 );		


		   var newMarginTopRemove = (newHeightAdd / 2) - 5;
		   $( '.removeWidth' ).animate({
		    marginTop: newMarginTopRemove+"px"
		  }, 100 );	

		  var newCenterArrows = 49;
		   $( '.moveElement' ).animate({
		    left: newCenterArrows+"%"
		  }, 100 );

		  var newCenterStopArrows = 49;
		   $( '.stopMove' ).animate({
		    left: newCenterStopArrows+"%"
		  }, 100 );				   

	},hideButtonsElement : function (){
		$('.removeWidth').hide();
		$('.addWidth').hide();
		$('.addHeight').hide();
		$('.removeHeight').hide();
		$('.moveElement').hide();
		$('.arrowDown').hide();
	},
	showButtonsElement : function (){
		/*$('.removeWidth').show();
		$('.addWidth').show();
		$('.addHeight').show();
		$('.removeHeight').show();
		$('.arrowDown').show();*/
		$('.moveElement').show();
		
	},
	eventLi : function (ul,li){
		var li = $('.'+li);
		ul.click(function(){
			if($('.moveElement').is(":visible"))
			{
				Report.Elements.hideButtonsElement();
				ul.css('background', '#222D32');
				li.css('background-color', '#1E282C');
			}else
			{
				Report.Elements.showButtonsElement();
				li.css('background-color', '#1269A7');
				ul.css('background', '#0019d2');
			}
		});
	},
	moveElement : function (){
	 if ($('.moveElement').is(":visible")) 
	 {
			$('div.hoja').mousemove(function(e){
			    var mouseX = e.pageX - 350;
			    var mouseY = e.pageY - 150;
			    var positionTop = $('div.arrowsFrame').position().top;
			    var positionLeft = $('div.arrowsFrame').position().left;

			  console.log("X frame: "+mouseX);
			  console.log("Y frame: "+mouseY);
			  console.log("Position TOP arrowsFrame: "+$('div.arrowsFrame').position().top);
			  console.log("Position LEFT arrowsFrame: "+$('div.arrowsFrame').position().left);

			  if (mouseX < 600) {
			      $('div.arrowsFrame').css({'left':mouseX }); 
			  }else{
			  	 console.log('mayor a 258');
			  	 $('div.arrowsFrame').css({'left': 0});
			  	 console.log("Position LEFT arrowsFrame: "+$('div.arrowsFrame').position().left);
			  }
			  
			  
			  if (mouseY < 150) {
			      $('div.arrowsFrame').css({'top': mouseY }); 
			  }else{
			  	  $('div.arrowsFrame').css({'top': '-43' }); 
			  }      
			});  

		    $('.moveElement').hide();
		  	$('.stopMove').show();

             setTimeout(function () {
		 		var stopMove = $('.elementFrame');
				stopMove.click(function(){
					Report.Elements.stopMove();
					$(this).off('click');
					//Report.Elements.capturarEventosFrame();
				});                 
             }, 100);

				  	

	 }else
	 {
	 	$('.arrowDown').show();
	 }

	},
	stopMove : function (){
		 if ($('.stopMove').is(":visible")) 
		 {
			  $('div.hoja').off("mousemove");
			  $('.stopMove').hide();
			  $('.moveElement').show();

		 }
	}
}
