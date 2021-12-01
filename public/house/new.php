<?php include_once('../../private/initialize.php')?>

<?php require_login();?>

<?php $page_title = 'Create subject'; ?>
<?php include_once(PRIVATE_PATH .'/header.php')?>
<?php

  // Declare general variables initial states for upload image
  $directory = PUBLIC_PATH . "/uploads";
  $uploadOk = 1;
  $the_message = '';

  // Declare PHP Upload Error Scenarios
  $phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
  );

  if(is_post_request()){

  // Save upload data to variables
  $temp_name = $_FILES['fileToUpload']['tmp_name'];
  $target_file = $_FILES['fileToUpload']['name'];
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $my_url = $directory . DIRECTORY_SEPARATOR . $target_file;

  // PHP Custom Errors
  $the_error = $_FILES['fileToUpload']['error'];
  if($_FILES['fileToUpload']['error'] != 0){
    $the_message_ext = $phpFileUploadErrors[$the_error];
    $uploadOk = 0;
  }

  // Set Custom Errors
  // (1) FILE ALREADY EXISTS
  if($the_message_ext == "" && file_exists($my_url)){
    $the_message_ext = "The file already exists, please save as a different name or upload a different file";
    $uploadOk = 0;
  }

  // (2) INCORRECT FILE EXTENSION
  if($the_message_ext == "" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
    $the_message_ext = "File type is not allowed, please choose a jpg";
    $uploadOk = 0;
  }
  
  // Set our Main Error Capture & Success Upload Case
  if($uploadOk == 0){
    $the_message = "<p>Sorry, your file was not uploaded.</p>" . "<strong>Eorror: </strong>" . $the_message_ext;
    echo '<div class="alert alert-danger">' . $the_message .'</div>';
  } else {
    if(move_uploaded_file($temp_name, $directory . "/" . $target_file)){
      $the_message = "File Uploaded Successfully";
        // Save values to DB
      $subject = [];
      $subject['title'] = $_POST['title'] ??'';
      $subject['writer'] = $_POST['writer'] ??'';
      $subject['date'] = date("Y-m-d");
      $subject['contents'] = $_POST['contents'] ??'';
      $subject['image'] = $target_file;   

      $result = insert_subject($subject);
      if($result === true) {
        $new_id = mysqli_insert_id($db);
        redirect_to(url_for('/house/view.php?id=' . $new_id));
      } else{
        $errors = $result;
      }
      } else{

      }
    }
  }


?>

<div class="contents">
  <?php echo display_errors($errors);?>
  <form action="<?php echo url_for('house/new.php');?>" method="post" enctype="multipart/form-data">
    <table class="new-table">
      <tr>
        <th>Title</th>
        <div><td><input type="text" name="title"value=""></td></div>
      </tr>
      <tr>
        <th>writer</th>
        <td><input type="text" name="writer" value="<?php echo $_SESSION['username'];?>" readonly></td>
      </tr>
      <tr>
        <th>contents</th>
        <td class="td-textarea"><textarea name="contents"></textarea></td>
      </tr>
      <tr>
        <th>upload</th>
        <td><input type="file" class="form-control" id="inputGroupFile" name="fileToUpload"></td>
      </tr>
    </table> 
    <div class="bottom-btn">
      <button type="submit" class="btn btn-primary submit-btn">submit</button>
    </div>
  </form>
</div>

<?php include_once(PRIVATE_PATH .'/footer.php')?>