    // Definicion de las variables necesarias para la grilla y validacion de mascaras
    var Config = {};
    Config.colums = [
        { 'id':'apellido', 'type':'ed', 'align':'left', 'sort':'str', 'value':'apellido' },
        { 'id':'nombre', 'type':'ed', 'align':'left', 'sort':'str', 'value':'nombre' },
    ];

    // Configuracion de visual de la grilla
    // #text_filter, #select_filter, #combo_filter, #text_search, #numeric_filter
    Config.show = {
        'module':'Gggg',
        'tableTitle':'Listado de Registros.',
        'filter':'&nbsp;,&nbsp;',
        'autoWidth':true,
        'multiSelect':false
    }

    // Configuracion de relacion de entidad
    Config.relacionPadre = {
        "field":"",
        "value": ""
    }

    Core.Vista.Select = {
        priListaLoad: function (){ 
        },
     }
<?php
       $fies = file_get_contents(__DIR__.'/mascaras.json');
       $dataJson = json_decode($fies);
 ?>
Core.Vista.Mascara = [
<?php
foreach ($dataJson->mascaras AS $key => $val){
    echo "{'type':'".$val->type."','mascara':'".base64_decode($val->mascaraJS)."','mensaje':'".$val->mensaje."','input':'".$val->input."','campo':'".$val->campo."'},".PHP_EOL;
}
?>
];
