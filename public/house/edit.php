<?php include_once('../../private/initialize.php')?>

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
  redirect_to(url_for('/house/view.php?id='. $id));

} else{

$subject = find_subject_by_id($id);

}
?>

<div class="contents">
  <form action="<?php echo url_for('house/edit.php?id='. $id);?>"method="post">
    <table>
      <tr>
        <td>Title</td>
        <td><input type="text" name="title" size="90"value="<?php echo $subject['title'];?>"></td>
      </tr>
      <tr>
        <td>writer</td>
        <td><input type="text" name="writer" size="90" value="<?php echo $subject['writer'];?>"></td>
      </tr>
      <tr>
        <td>contents</td>
        <td><textarea name="contents" rows="17" cols="100"><?php echo $subject['contents'];?></textarea></td>
      </tr>
    </table>
    <div class="edit-btn">
      <button type="submit" class="btn btn-primary submit-btn">Edit</button>
    </div>
  </form>
</div>

<?php include_once(PRIVATE_PATH .'/footer.php')?>