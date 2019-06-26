$( document ).ready(function() {

  function onElementHeightChange(elm, callback){
  	var lastHeight = elm.clientHeight, newHeight;
  	(function run(){
  		newHeight = elm.clientHeight;
  		if( lastHeight != newHeight )
  			callback();
  		lastHeight = newHeight;

          if( elm.onElementHeightChangeTimer )
            clearTimeout(elm.onElementHeightChangeTimer);

  		elm.onElementHeightChangeTimer = setTimeout(run, 200);
  	})();
  }

  onElementHeightChange(document.getElementById('detail'), function(){
    var y = $(".line_vertical").parent().height();
    $(".line_vertical").height(y);
  });

  function createRulerReport(){
    var cm_div_number = 10;
    var mm_div_number = 9 * cm_div_number;
    var count = 0;
    var cm_array = new Array();
    var ruler_div = document.createElement("div");
    ruler_div.className = "ruler";

    for (var i = 0; i < cm_div_number; i++) {
      var cm_element = document.createElement("div");
      cm_element.className = "cm";
      cm_array.push(cm_element);
    }

    for(var i = 0; i < cm_array.length; i++){
      for (var j = 0; j < 9; j++) {
        count++
        var mm_element = document.createElement("div");
        mm_element.className = "mm";

        mm_element.onclick = function() {
          posicion = $(this).offset();
          createLineVertical(posicion);
        };

        cm_array[i].appendChild(mm_element);
      }
    }

    for (var i = 0; i < cm_array.length; i++) {
      ruler_div.appendChild(cm_array[i]);
    }

    var cm_element_last = document.createElement("div");
    cm_element_last.className = "cm";
    ruler_div.appendChild(cm_element_last);
    document.getElementById("reglas_reporte").appendChild(ruler_div);
  }

  function createRulerReportVertical(){
    var cm_div_number = 10;
    var mm_div_number = 9 * cm_div_number;
    var count = 0;
    var cm_array = new Array();
    var ruler_div = document.createElement("div");
    ruler_div.className = "ruler ruler-vertical";

    for (var i = 0; i < cm_div_number; i++) {
      var cm_element = document.createElement("div");
      cm_element.className = "cm";
      cm_array.push(cm_element);
    }

    for(var i = 0; i < cm_array.length; i++){
      for (var j = 0; j < 9; j++) {
        count++
        var mm_element = document.createElement("div");
        mm_element.className = "mm";

        mm_element.onclick = function() {
          posicion = $(this).offset();
          createLineVertical(posicion);
        };

        cm_array[i].appendChild(mm_element);
      }
    }

    for (var i = 0; i < cm_array.length; i++) {
      ruler_div.appendChild(cm_array[i]);
    }

    var cm_element_last = document.createElement("div");
    cm_element_last.className = "cm";
    ruler_div.appendChild(cm_element_last);
    document.getElementById("reglas_reporte").appendChild(ruler_div);
  }

  createRulerReport();
  createRulerReportVertical();

  function createLineHorizontal(posicion){
    var count_lines = document.getElementsByClassName('line_horizontal').length;
    var element_base = document.getElementById("detail");
    var line_horizontal_div = document.createElement("div");
    var x = $(".line_horizontal").parent().width();

    line_horizontal_div.className = "line_horizontal";
    line_horizontal_div.id = 'line_horizontal_' + (count_lines+1);
    element_base.parentNode.insertBefore(line_horizontal_div, element_base);

    console.log(line_horizontal_div);

    $("#line_horizontal_" + (count_lines+1)).css({
      "width": (x+65) + "px",
      "border": "1px dashed black",
      "height": 0 + "px",
      "position": "absolute",
      "top" : posicion.top + "px",
      "left" : "310px"
    });

    $("#line_horizontal_" + (count_lines+1)).draggable({
      start: function (event, ui) {
        $(".line_horizontal").css({
          "left": "310px",
          "height": 0 + "px"
        });
      },
      stop: function (event, ui){
        $(".line_horizontal").css({
          "left": "310px",
          "height": 0 + "px"
        });
      },
      containment: "parent"
    });
  }

  function createLineVertical(posicion){
    var count_lines = document.getElementsByClassName('line_vertical').length;
    var element_base = document.getElementById("detail");
    var line_vertical_div = document.createElement("div");
    var y = $("#detail").parent().height();

    line_vertical_div.className = "line_vertical";
    line_vertical_div.id = 'line_vertical_' + (count_lines+1);
    element_base.parentNode.insertBefore(line_vertical_div, element_base);


    $("#line_vertical_" + (count_lines+1)).css({
      "width": 0 + "px",
      "border-left": "2px dashed black",
      "height": (y-15) + "px",
      "left": posicion.left + "px",
      "top": "119px",
      "position": "absolute"
    });

    $("#line_vertical_" + (count_lines+1)).draggable({
        start: function (event, ui) {},
        stop: function (event, ui){
          $(".line_vertical").css({
            "top": "119px"
          });
        },
        containment: "parent"
    });
  }
});
