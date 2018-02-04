<?php
        //set content type and xml tag
        header("Content-type:text/json");
 

        //define variables from incoming values
        if(isset($_GET["posStart"]))
            $posStart = $_GET['posStart'];
        else
            $posStart = 0;
        if(isset($_GET["count"]))
            $count = $_GET['count'];
        else
            $count = 100;
 
        // Configuracion de la conexion
        $serverName = "localhost"; //serverName\instanceName
		$connectionInfo = array( "Database"=>"test_crud2", "UID"=>"sa", "PWD"=>"s3rv3r..*");
		$link = sqlsrv_connect( $serverName, $connectionInfo);

		// Primero extraer la cantidad de registros
		$sqlCount = "Select count(*) as items FROM tipo_servicio";
	    $resCount = sqlsrv_query ($link,$sqlCount);
	    $rowCount=sqlsrv_fetch_object($resCount);


        //create query to products table
        $sql = " descripcion FROM tipo_servicio";
 
        //if this is the first query - get total number of records in the query result
        $sqlCount = "SELECT * FROM (
				SELECT ROW_NUMBER() OVER( ORDER BY id ASC ) AS row, ".$rowCount->items." AS cnt, $sql ) AS sub";
        $resCount =sqlsrv_query($link,$sqlCount);
        $rowCount=sqlsrv_fetch_object($resCount);
        $totalCount = $rowCount->cnt;
 
        //add limits to query to get only rows necessary for the output
        $sqlCount.= " WHERE row>=".$posStart." AND row<=".$count;
 
 		$sqlCount;
      
        $res = sqlsrv_query($link,$sqlCount);
 
        //output data in XML format   
        $items = array();
        while($row=sqlsrv_fetch_object($res)){
        	//$tmp['id'] = $row->id;
        	$tep = array();
        	foreach ($row as $key => $value) {
        		if($key!='id' AND $key!='cnt' AND $key!='row'){
        			$tep[] = $value;
        		}
        	}
        	//print_r($row);
        	//die();
        	$tmp['data'] = $tep;
            array_push($items,$tmp);
        } 
        
        $config[] = array('id' =>"descripcion", 'width'=>400, 'type' =>"ed" ,'align' =>"center" ,'sort' =>"str" ,'value' =>"Descripcion"  );
    

        $valor['head']=$config;
        $valor['rows']=$items;
        echo json_encode($valor);

        /*
			{ id:10910,
		 data:[
			  "400",
			  "Cousin Bette",
			  "Honore de Balzac",
			  "0",
			  "1",
			  "12/01/1991"] }
			  ]
		}
			   head:[
			      { id:"sales",    width:70,  type:"dyn",   align:"right",  sort:"int", value:"Sales" },
			      { id:"title",    width:150, type:"ed",    align:"left",   sort:"str", value:"Book Title" },
			      { id:"author",   width:100, type:"ed",    align:"left",   sort:"str", value:"Author" },
			      { id:"price",    width:80,  type:"price", align:"right",  sort:"str", value:"Price" },
			      { id:"instore",  width:80,  type:"ch",    align:"center", sort:"str", value:"In Store" },
			      { id:"shipping", width:100, type:"co",    align:"left",   sort:"str", value:"Shipping" }
   				],

   				,
		   

        */
?>

