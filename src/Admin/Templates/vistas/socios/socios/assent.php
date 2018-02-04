    // Definicion de las variables necesarias para la grilla y validacion de mascaras
    var Config = {};
    Config.colums = [
        { 'id':'tipo_documento', 'type':'ed', 'align':'left', 'sort':'str', 'value':'tipo_documento' },
        { 'id':'documento', 'type':'ed', 'align':'left', 'sort':'str', 'value':'documento' },
        { 'id':'nombres', 'type':'ed', 'align':'left', 'sort':'str', 'value':'nombres' },
        { 'id':'apellidos', 'type':'ed', 'align':'left', 'sort':'str', 'value':'apellidos' },
        { 'id':'fecha_nacimiento', 'type':'ed', 'align':'left', 'sort':'str', 'value':'Nacimiento' },
        { 'id':'created_usuario_id', 'type':'ed', 'align':'left', 'sort':'str', 'value':'created_usuario_id' },
        { 'id':'updated_usuario_id', 'type':'ed', 'align':'left', 'sort':'str', 'value':'updated_usuario_id' },
    ];

    // Configuracion de visual de la grilla
    // #text_filter, #select_filter, #combo_filter, #text_search, #numeric_filter
    Config.show = {
        'module':'Socios',
        'tableTitle':'Listado de Registros.',
        'filter':'&nbsp;,#text_filter,#text_filter,#text_filter,&nbsp;,&nbsp;,&nbsp;',
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
