<section class="content-header">
    <h1>
	<?php echo $breadcrumb->actual ?>
        <small><?php echo $breadcrumb->titulo ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <?php 
        
            if (strpos($breadcrumb->ruta, '/') !== false) {
                $split=explode('/',$breadcrumb->ruta);
                $cant = count($split)-1;
                foreach ($split AS $key => $value){
                    if($cant==$key){
                        echo '<li class="active">'.$value.'</li>';
                    }else{
                         echo '<li>'.$value.'</li>';
                    }
                }
            }elseif(strlen($breadcrumb->ruta)>0){
                echo '<li class="active">'.$breadcrumb->ruta.'</li>';
            }
           
        ?>
        
    </ol>
</section>
