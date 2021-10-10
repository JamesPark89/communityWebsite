<?php include_once('../../private/initialize.php')?>

<?php include_once(PRIVATE_PATH .'/header.php')?>

<div class="contents">
  <form action="<?php echo url_for('house/create.php');?>"method="post">
    <table>
      <tr>
        <td>Title</td>
        <td><input type="text" name="title" size="85"value=""></td>
      </tr>
      <tr>
        <td>writer</td>
        <td><input type="text" name="writer" size="85" value=""></td>
      </tr>
      <tr>
        <td>contents</td>
        <td><textarea name="contents" rows="20" cols="90"></textarea></td>
      </tr>
    </table>
    <div class="bottom-btn">
      <button type="submit" class="btn btn-primary submit-btn">submit</button>
    </div>
  </form>
</div>

<?php include_once(PRIVATE_PATH .'/footer.php')?>