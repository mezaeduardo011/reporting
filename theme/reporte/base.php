<!-- Base del sistema plantilla-->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JRH+<?=$this->section('title')?></title>
  <!-- Tell the browser to be responsive to screen width -->

    <!-- NoScript Extends-->
    <?=$this->insert('section/noscript')?>
    <!-- CSS Main-->
    <?php $this->insert('section/link') ?>
  


</head>
<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">
  <?=$this->insert('section/header')?>
  <?=$this->insert('section/inside') ?>
   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background: #008abf6e;">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class="content" style="position: relative;">
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
