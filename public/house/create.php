<?php include_once('../../private/initialize.php')?>

<?php include_once(PRIVATE_PATH .'/header.php')?>

<?php
if(is_post_request()){

  $subject = [];
  $subject['title'] = $_POST['title'] ??'';
  $subject['writer'] = $_POST['writer'] ??'';
  $subject['date'] = date("Y-m-d");
  $subject['contents'] = $_POST['contents'] ??'';

  $result = insert_subject($subject);
  $new_id = mysqli_insert_id($db);

  redirect_to(url_for('/house/view.php?id=' . $new_id));
} else{
  redirect_to(url_for('house/new.php'));
}

?>

<?php include_once(PRIVATE_PATH .'/footer.php')?>