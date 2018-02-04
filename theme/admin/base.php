<!-- Base del sistema plantilla-->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JRH+<?=$this->section('title')?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- NoScript Extends-->
    <?=$this->insert('section/noscript')?>
    <!-- CSS Main-->
    <?php $this->insert('section/link') ?>
    <!-- CSS Extends-->
    <?=$this->section('addCss')?>



</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
<div class="wrapper">
  <?=$this->insert('section/header',['usuario'=>$usuario])?>
  <?=$this->insert('section/inside',['usuario'=>$usuario]) ?>
   

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?=$this->insert('section/breadcrumb',['breadcrumb'=>$breadcrumb]) ?>

        <!-- Main content -->
        <section class="content">
           <?=$this->section('content')?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
	<?=$this->insert('section/footer') ?>
    <?=$this->insert('section/modal') ?>
</div>
<!-- ./wrapper -->

<!-- javascript files -->
<?php $this->insert('section/script') ?>

<!-- javascript extra -->

<?=$this->section('addJs')?>
</body>
</html>
