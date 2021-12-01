<?php include_once('../../private/initialize.php')?>

<?php include_once(PRIVATE_PATH .'/header.php')?>

<?php 

  $id = $_GET['id'] ??'1';

  $subject = find_subject_by_id($id);

?>

<div class="contents">
  <table class="contents-table"> 
    <tr>
      <td class="td-title"><h1><?php echo h($subject['title']);?></h1></td>
    </tr>  
    <tr class="tr-writer-date">
      <td class="td-writer"><?php echo 'Writer : '. h($subject['writer']);?></td>
      <td class="td-date"><?php echo 'date : '. h($subject['date']);?></td>
    </tr>
  </table>
  <table>
    <tr>
      <td>
        <?php echo h($subject['contents']);?>
      </td>
    </tr>
    <tr>
      <td>
        <img class = "image" src="<?php echo '/public/uploads/'. $subject['image']?>"/>
      </td>
    </tr>
  </table>
  <div class="bottom-btn">
    <!-- show edit & delete button to the user who create the post-->
    <?php 
    if($_SESSION['username'] == $subject['writer']){?>
    <a href="<?php echo url_for('/house/edit.php?id='. $id);?>" class="btn btn-primary ">Edit</a>
    <a href="<?php echo url_for('/house/delete.php?id='. $id);?>" class="btn btn-primary delete-btn">Delete</a>
  <?php } ?>
  </div>
</div>

<?php include_once(PRIVATE_PATH .'/footer.php')?>