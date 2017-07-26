<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
     <title><?php echo $page_title;  ?></title>
     <?php echo View::factory('common/header') ?>
     </head>

<body>
<div class="container">
<?php  echo $body ?>
 </div>   
</body>
<?php echo View::factory('common/js');  ?>
</html>