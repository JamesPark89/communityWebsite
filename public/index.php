<?php include_once('../private/initialize.php')?>


<?php include_once(PRIVATE_PATH .'/header.php')?>
<div class="contents">
  <div class="intro">
    <h3>Welcome! <?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}?></h3>    
    <p> This is a website for sharing information about accommdaions and jobs that you can get in Melbourne.</p>
  </div>
</div>
<?php include_once(PRIVATE_PATH .'/footer.php')?>