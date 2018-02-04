<!-- Base de sistema para login-->
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
    <?php $this->insert('section/link2') ?>

    <!-- CSS Extends-->
    <?=$this->section('addCss')?>


  </head>
<body class="hold-transition <?=$this->section('option')?>">
<?=$this->section('content')?>
<?=$this->insert('section/footer2') ?>
<!-- javascript files -->
<?php $this->insert('section/script2') ?>

<!-- javascript extra -->
<?=$this->section('addJs')?>
</body>
</html>
