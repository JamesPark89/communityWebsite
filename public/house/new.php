<?php include_once('../../private/initialize.php')?>

<?php $page_title = 'Create subject'; ?>
<?php include_once(PRIVATE_PATH .'/header.php')?>
<?php
  if(is_post_request()){

  $subject = [];
  $subject['title'] = $_POST['title'] ??'';
  $subject['writer'] = $_POST['writer'] ??'';
  $subject['date'] = date("Y-m-d");
  $subject['contents'] = $_POST['contents'] ??'';

  $result = insert_subject($subject);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    redirect_to(url_for('/house/view.php?id=' . $new_id));
  } else{
    $errors = $result;
  }

  } else{

}
?>

<div class="contents">
  <?php echo display_errors($errors);?>
  <form action="<?php echo url_for('house/new.php');?>"method="post">
    <table class="new-table">
      <tr>
        <th>Title</th>
        <div><td><input type="text" name="title"value=""></td></div>
      </tr>
      <tr>
        <th>writer</th>
        <td><input type="text" name="writer" value=""></td>
      </tr>
      <tr>
        <th>contents</th>
        <td class="td-textarea"><textarea name="contents"></textarea></td>
      </tr>
    </table>
    <div class="bottom-btn">
      <button type="submit" class="btn btn-primary submit-btn">submit</button>
    </div>
  </form>
</div>

<?php include_once(PRIVATE_PATH .'/footer.php')?>