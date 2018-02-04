<?php $this->layout('base')?>



<div class="borderHoja">
  <div class="row hoja" ondragover="Report.EventsDragDrop.allowDrop(event)" ondrop="Report.EventsDragDrop.hojaDrop(event)">
<!--      <div id="divQuery"></div>-->
      <div id="title" data-nameTag="title" data-xml="<title><band height='79' status='noVisited' splitType='Stretch'/></title>" class="split split-vertical title" style="border: 1px solid #C0C0C0;height: 50px;" >
          <div id="cl"></div>
      </div>
      <div id="detail" class="split split-vertical">
      </div>
      <div id="footer" class="split split-vertical" style="border: 1px solid #C0C0C0;">
      </div>
  </div>
</div>

<?php $this->push('addJs')?>

<!-- Notificciones toastr -->
<script type="text/javascript">
    var dataConnection;

function editText() {
  $.confirm({
      content: 'url:/reportes.php/staticTextModal',
      columnClass: 'col-md-offset-3 col-md-6',
      title:false,
      buttons: {
          Agregar: function () {
            var elementText = $('#'+ViewProperties.elementSelected);
            var textArea = $('#textArea');
            var value = textArea.val();
            elementText.empty();
            elementText.append(value);
          },
          Cancelar: {
              text: 'Cancelar', // With spaces and symbols
              action: function () {
                  
              }
          }
      }
  });
}


function createConnection() {
  $.confirm({
      content: 'url:/reportes.php/createConnection',
      columnClass: 'col-md-offset-3 col-md-6',
      title:false,
      buttons: {
          formSubmit: 
          {
            text: 'Ok',
            btnClass: 'btn-blue',
            action: function () {

                var driverSend = $('#driver').val();
                var hostSend = $('#host').val();
                var databaseSend = $('#database').val();
                var userSend = $('#user').val();
                var passwordSend = $('#password').val();
                var idOption = hostSend+'_'+databaseSend;

                var data = { 'driver':driverSend,'host':hostSend,'users':userSend,'password':passwordSend,'db':databaseSend};
                $.post( "/reportes.php/saveConnection",data, function( response ){
                    //En caso de  ser correcto el save devuelve un numero
                    if(!isNaN(Number(response)))
                    {

                        $('#listConnections').append($('<option>', {
                            value: 3,
                            text:hostSend+"."+databaseSend,
                            id:idOption
                        }));
                        $('#'+idOption).attr('data-driver', driverSend);
                        $('#'+idOption).attr('data-host', hostSend);
                        $('#'+idOption).attr('data-database', databaseSend);
                        $('#'+idOption).attr('data-user', userSend);
                        $('#'+idOption).attr('data-password', passwordSend);

                    }else
                    //Si no devuelve el id numerico es porque ocurrio un error al registrar los datos
                    {
                        $.alert('Ocurrio un error al guardar la conexión');
                    }

                });

            }
          },Test: function () 
          {
              var driverTest = $('#driver').val();
              var hostTest = $('#host').val();
              var databaseTest = $('#database').val();
              var userTest = $('#user').val();
              var passwordTest = $('#password').val();
              var data = { 'driver':driverTest,'host':hostTest,'user':userTest,'password':passwordTest,'database':databaseTest};
              $.post( "/reportes.php/testConnection",data, function( response ) {
                 // $.alert(response);

              });
              return false;
          },Cancelar: function ()
          {
          }
      }
  });
}

function useConnection(t) {

    var driver = event.target.options[event.target.selectedIndex].dataset.driver;
    var host = event.target.options[event.target.selectedIndex].dataset.host;
    var database = event.target.options[event.target.selectedIndex].dataset.database;
    var user = event.target.options[event.target.selectedIndex].dataset.user;
    var password = event.target.options[event.target.selectedIndex].dataset.password;
    dataConnection = { 'driver':driver,'host':host,'user':user,'password':password,'database':database};
    $.post( "/reportes.php/useConnection",dataConnection, function( response ) {
          //  $.alert('Ocurrio un error al usar la conexión');

    });
    return false;
}

function showTables() {

    if(dataConnection != undefined)
    {

        var fields = [];
        fields.push('22');
        //Se recorre el menu para obtener los campos que estan seleccionados y pasarlos a la vista tables
        $('#ulCampos li').each(function(i)
        {
            fields.push($.trim($(this).text()));
        });
        $.confirm({
            content: 'url:/reportes.php/tables?fieldsSelecteds='+fields+
            '&driver='+dataConnection.driver+
            '&database='+dataConnection.database+
            '&user='+dataConnection.user+
            '&password='+dataConnection.password+
            '&host='+dataConnection.host,
            columnClass:'col-md-12',
            title:false,
            buttons: {
                Agregar: {
                    btnClass: 'addTables',
                    action : function () {
                        $("#ulCampos").empty();

                        $( ".fieldSelected" ).each(function() {
                            //se agregan los elementos seleccionados en el menu opcion Campos
                            //Los valores vienen de la vista tables
                            $("#ulCampos").append(
                                "<li data-idfield='"+$( this ).data('idfield')+"'>" +
                                "<a data-field='"+$( this ).data('field')+"' id='li"+$( this ).data('field')+$( this ).data('idfield')+"' data-element='Campo'  draggable='true' ondragstart='Report.EventsDragDrop.drag(event)'>" +
                                "<i class='fa fa-circle-o'> "+$( this ).data('field')+" </i>" +
                                "</a>" +
                                "</li>"
                            );
                        });
                    }
                },
                Cancelar: {
                    btnClass: 'cancelTables',
                    text: 'Cancelar',
                    action: function () {

                    }
                },
                Ok: {
                    btnClass: 'okTables',
                    text: 'Ok',
                    action: function () {

                    }
                }

            }
        });
    }else
    {
        $.alert('No se econtro una conexión');
    }

}

    $('html').keyup(function(e){
        if(e.keyCode == 46) {
            $('#'+ViewProperties.elementSelected).remove();
        $('#i'+ViewProperties.elementSelected).remove();
        }
    });

  function autosize(o){
    $(this).height(0).height(this.scrollHeight);
  }
    var ind;
  function saveXml(t)
  {

      t.classList.add("buttonClick");
      setTimeout(function () {t.classList.remove("buttonClick");}, 150);


      ind = 1;
      $.post('/reporte/baseXml.xml', function(xml) {
          var jasperBasic = $(xml);

          var xmlDiv ;
        $( ".hoja" ).children().each(function( index ) {
            if($(this).data("xml") != undefined)
            {

                xmlDiv = $.parseXML($(this).data("xml"));
                console.log("XML BASE xmlDiv:  "+(new XMLSerializer()).serializeToString(xmlDiv));
                travelChildren($(this),xmlDiv);
                $(xmlDiv).find('reportElement').removeAttr('status');
                $(xmlDiv).find('reportElement').removeAttr('used');
                $(xmlDiv).find('band').removeAttr('status');
                $(xmlDiv).find('band').removeAttr('used');
                console.log("XML AGREGADO xmlDiv:  "+(new XMLSerializer()).serializeToString(xmlDiv));


            }
        });
          jasperBasic.find('jasperReport').append((new XMLSerializer()).serializeToString(xmlDiv));
          var data = { 'xml':(new XMLSerializer()).serializeToString(xml)};
          $.post( "/reportes.php/addTag",data, function( response ) {
              console.log(response);
          });

      });

  }

  function  travelChildren(currentElement,xmlPattern) {
      console.log("Se ejecuta travelChildren() Se recibe por parametro currentElement :"+currentElement+" Y xmlPattern: "+(new XMLSerializer()).serializeToString(xmlPattern));
      console.log("currentElement es el this del elemento padre (El primer elemento creado en la hoja.)");
      console.log("por lo cual el each reacorre los hijos de currentElement");
      console.log("Si hay 3 frame  y 2 textos padres en la hoja esto recorrera cada uno de los hijos de estos xml.");

      var nameTag = currentElement.data("nametag");

      console.log("nameTag : "+nameTag);
      console.log("Se recorren los hijos del div con id = "+currentElement.attr('id'));

      var xPatterhn = $(xmlPattern).find('reportElement').attr("x");
      console.log("Sel almacena en xPatterhn el valor del tag x del padre (xmlPattern)");
      console.log("Si el valor del tag x del padre (xmlPattern) no existe se busca en otra etiqueta (band)");
      xPatterhn = (xPatterhn == undefined) ? $(xmlPattern).find('band').attr("height"):xPatterhn;
      console.log("xPatterhn :"+xPatterhn);
      var yPatterhn = $(xmlPattern).find('reportElement').attr("y");
      console.log("Se almacena en yPatterhn el valor del tag y del padre (xmlPattern)");
      console.log("Si el valor del tag x del padre (xmlPattern) no existe se busca en otra etiqueta (band)");
      yPatterhn = (yPatterhn == undefined) ? xPatterhn:yPatterhn;
      console.log("yPatterhn :"+yPatterhn);


          currentElement.find('.elementReport').each(function (i) {
          var xmlChildren = $(this).data("xml");

          console.log("Con el valor de xmlChildren se verifica si los elementos internos del padre tienen etiqueta xml");
          if(xmlChildren != undefined)
          {
              console.log("Existe hijo con el valor de xmlChildren :"+xmlChildren);
               console.log($(this).css("width").replace('px',''));
              $(xmlChildren).find('reportElement').attr("x",$(this).css("width"));

              var xChildren = $($.parseXML(xmlChildren)).find('reportElement').attr("x");
              console.log("Sel almacena en xChildren el valor del tag x del padre (xChildren)");
              console.log("Si el valor del tag x del padre (xChildren) no existe se busca en otra etiqueta (band)");
              xChildren = (xChildren == undefined) ? $($.parseXML(xmlChildren)).find('band').attr("height"):xChildren;
              console.log("xChildren :"+xChildren);
              var yChildren = $($.parseXML(xmlChildren)).find('reportElement').attr("y");
              console.log("Se almacena en yChildren el valor del tag y del padre (yChildren)");
              console.log("Si el valor del tag x del padre (xmlPattern) no existe se busca en otra etiqueta (band)");
              yChildren = (yChildren == undefined) ? xChildren:yChildren;
              console.log("yChildren :"+yChildren);




                     if($(xmlPattern).find('reportElement[x="'+xChildren+'"]').attr("used") == 'agregado')
                     {
                         console.log("No se agrega elemento porque ya fue agregado")
                     }else
                     {
                         console.log("xmlPattern  "+(new XMLSerializer()).serializeToString(xmlPattern));
                         console.log("xmlChildren  "+(new XMLSerializer()).serializeToString($.parseXML(xmlChildren)));
                         console.log("Seteando valores xml");
                         var xmlC = $.parseXML(xmlChildren);


                         addAttrDefaultXml(xmlC,$(this));
                         //var elementC = $(this).data("nameTag");
                        // Report.elementC.setValuesXML($(this));
                        // $(xmlC).find('reportElement').attr("width", $(this).width());
                        console.log("xmlC  "+(new XMLSerializer()).serializeToString(xmlC));


                         console.log("Se agrega xmlChildren al xmlPattern");
                         $(xmlPattern).find(nameTag).append((new XMLSerializer()).serializeToString(xmlC));
                         console.log("xmlPattern  DESPUES DE AGREGAR CHILDREN "+(new XMLSerializer()).serializeToString(xmlPattern));

                         console.log("xmlChildren  "+(new XMLSerializer()).serializeToString($.parseXML(xmlChildren)));
                         console.log("Se cambia el estado (statusUsed) de "+(new XMLSerializer()).serializeToString($.parseXML(xmlChildren))+" a agregado ");

                         console.log("Cambiando "+$(xmlPattern).find('reportElement[x="'+xChildren+'"]').attr("used","agregado") );

                         console.log("Cambio de status queda = "+(new XMLSerializer()).serializeToString(xmlPattern)+" agregado ");

                     }

          }

              console.log("Se cambia el estado (status) de "+(new XMLSerializer()).serializeToString(xmlPattern)+" a visitado ");
              console.log("Asi debe cambiar el status del elemento specifico"+$(xmlPattern).find('band[height="'+xPatterhn+'"]').attr("status","visited") );
              console.log("Asi debe cambiar el status del elemento specifico"+$(xmlPattern).find('reportElement[x="'+xPatterhn+'"]').attr("status","visited") );
              console.log("Cambio de status queda = "+(new XMLSerializer()).serializeToString(xmlPattern)+" a visitado ");
              console.log("Se Finaliza recorrido");
              console.log("Se verifica si este div actual ("+xmlPattern+") posee hijos  y se agregan ejecuntando de nuevo travelChildren()");
              travelChildren($(this),xmlPattern);
      });

  }


  function addAttrDefaultXml(xmlC,t) {
      console.log("Se agrega top al xml");
      $(xmlC).find('reportElement').attr("y", parseInt(t.css('top')));

      console.log("Se agrega left al xml");
      $(xmlC).find('reportElement').attr("x", parseInt(t.css('left')));

      console.log("Se agrega ancho al xml");
      $(xmlC).find('reportElement').attr("width", parseInt(t.width()));

      console.log("Se agrega alto al xml");
      $(xmlC).find('reportElement').attr("height", parseInt(t.height()));

      console.log("Se agrega color de fondo al xml");
      $(xmlC).find('reportElement').attr("backcolor", t.css('background-color'));

      console.log("Se agrega color superior al xml");
      $(xmlC).find('reportElement').attr("forecolor", t.css('color'));
  }

  function selectFields(t) {
      var field = t.id;
      var icon = $('#icon'+field);
      var divField = $('#'+field);
      if(divField.hasClass('unselected'))
      {
          divField.removeClass('unselected');
          divField.addClass('fieldSelected');
          icon.removeAttr('class');
          icon.attr('class', 'fa fa-check-square');
      }else
      {
          icon.removeAttr('class');
          divField.removeClass('fieldSelected');
          divField.addClass('unselected');
          icon.attr('class', 'fa fa-minus-square');
      }


  }

  $( document ).ready(function() {
     Report.main();

  });

    var logger = function()
    {
        var oldConsoleLog = null;
        var pub = {};

        pub.enableLogger =  function enableLogger()
        {
            if(oldConsoleLog == null)
                return;

            window['console']['log'] = oldConsoleLog;
        };

        pub.disableLogger = function disableLogger()
        {
            oldConsoleLog = console.log;
            window['console']['log'] = function() {};
        };

        return pub;
    }();


    Split(['#title', '#detail','#footer'], {
        direction: 'vertical',
        gutterSize: 8,
        cursor: 'col-resize'
    })

    function  zoomOut (t) {
        t.classList.add("buttonClick");
        setTimeout(function () {t.classList.remove("buttonClick");}, 150);
        $(".borderHoja").height(
            $(".borderHoja").height() * 0.8
        );
    }

    function zoomIn (t) {
        t.classList.add("buttonClick");
        setTimeout(function () {t.classList.remove("buttonClick");}, 150);
        $(".borderHoja").height(
            $(".borderHoja").height() * 1.1
        );
    }


</script>
<?php $this->end()?>
  