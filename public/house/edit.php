<?php include_once('../../private/initialize.php')?>

<?php require_login();?>

<?php include_once(PRIVATE_PATH .'/header.php')?>

<?php 

$id = $_GET['id'] ?? '1';

if(is_post_request()){
  $subject = [];
  $subject['id'] = $id;
  $subject['title'] = $_POST['title'] ?? '';
  $subject['writer'] = $_POST['writer'] ?? '';
  $subject['contents'] = $_POST['contents'] ?? '';

  $result = update_subject($subject);
  if($result === true) {
  redirect_to(url_for('/house/view.php?id='. $id));
  } else {
  $errors = $result;
  // var_dump($errors);
}

} else{

$subject = find_subject_by_id($id);

}
?>

<div class="contents">
  <?php echo display_errors($errors); ?>
  <form action="<?php echo url_for('house/edit.php?id='. $id);?>"method="post">
  <dl>
    <dt>title</dt>
    <dd><input type="text" name="title" value="<?php echo $subject['title'];?>"></dd>
  </dl>
  <dl>
    <dt>writer</dt>
    <input type="text" name="writer" value="<?php echo $subject['writer'];?>"></dd>
  </dl>
  <dl>
    <dt>contents</dt>
    <textarea name="contents"><?php echo $subject['contents'];?></textarea></dd>
  </dl>
    <div class="edit-btn">
      <button type="submit" class="btn btn-primary submit-btn">Edit</button>
    </div>
  </form>
</div>

<?php include_once(PRIVATE_PATH .'/footer.php')?>