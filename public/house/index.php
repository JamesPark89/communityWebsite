<?php include_once('../../private/initialize.php')?>

<?php $page_title = 'AUSLIFE_HOUSE'?>

<?php
  $subject_set = find_all_subject();
?>

<?php include_once(PRIVATE_PATH .'/header.php')?>

<div class="contents">
  <div class="table-head"><a href="new.php" class="btn btn-primary new-btn">New</a></div>
  <table class="contents-table">
    <tr>
      <th>No</th>
      <th>Title</th>
      <th>Writer</th>
      <th>Date</th>
    </tr>
    <?php while($subject = mysqli_fetch_assoc($subject_set)){?>
    <tr>
      <td class="td-id"><?php echo h($subject['id']); ?></td>
      <td class="td-contents"><a href="<?php echo url_for('house/view.php?id='.h($subject['id']));?>"><?php echo h($subject['title']);?></a></td>
      <td class="td-writer"><?php echo h($subject['writer']);?></td>
      <td class="td-date"><?php echo h($subject['date']);?></td>
    </tr>
    <?php } ?>
  </table>
  
  <?php
    mysqli_free_result($subject_set);
  ?>
</div>

<?php include_once(PRIVATE_PATH .'/footer.php')?>