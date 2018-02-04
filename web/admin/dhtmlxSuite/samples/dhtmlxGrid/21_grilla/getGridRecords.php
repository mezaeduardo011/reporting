<?php
//set content type and xml tag
//header("Content-type:text/xml");
//print("<?xml version="1.0">");

        //define variables from incoming values
if(isset($_GET["posStart"]))
	$posStart = $_GET['posStart'];
else
	$posStart = 0;
if(isset($_GET["count"]))
	$count = $_GET['count'];
else
	$count = 100;
	
$serverName = "localhost"; //serverName\instanceName
$connectionInfo = array( "Database"=>"test_crud2", "UID"=>"sa", "PWD"=>"s3rv3r..*");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
	$sql = 'SELECT * FROM tipo_servicio';
	$stmt = sqlsrv_query( $conn, $sql);

	$datos = array();

	while( $obj = sqlsrv_fetch_object( $stmt)) {
		$datos[]=(array)$obj;
	}
	print_r($datos);

	//if this is the first query - get total number of records in the query result
	if($posStart==0){
	    $sqlCount = "Select count(*) as cnt FROM tipo_servicio";
	    $resCount = sqlsrv_query ($sqlCount);
	    $rowCount=sqlsrv_fetch_array($resCount);
	    $totalCount = $rowCount["cnt"];
	}

	//add limits to query to get only rows necessary for the output
    $sql.= " LIMIT ".$posStart.",".$count;
 
        //query database to retrieve necessary block of data
    echo $res = sqlsrv_query($sql);
}else{
	echo "Conexión no se pudo establecer.<br />";
	die( print_r( sqlsrv_errors(), true));
}
?>

