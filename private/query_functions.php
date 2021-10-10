<?php

  function find_all_subject() {
    global $db;

    $sql = 'SELECT * FROM house ';
    $sql .= 'ORDER BY id DESC';
    $result = mysqli_query($db, $sql);
    return $result;
  }
  
  function update_subject($subject) {
    global $db;
    $sql = "UPDATE house SET ";
    $sql .= "title='" . $subject['title'] . "',";
    $sql .= "writer='" . $subject['writer'] . "',";
    $sql .= "contents='" . $subject['contents'] . "'";
    $sql .= "WHERE id='" . $subject['id'] . "'";
    $sql .= "LIMIT 1";
  
    $result = mysqli_query($db, $sql);

    if($result){
      return true;
    } else{

      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function insert_subject($subject) {
    global $db;
  $sql = "INSERT INTO house ";
  $sql .= "(title, writer, date, contents) ";
  $sql .= "VALUES (";
  $sql .="'" . $subject['title'] . "',";
  $sql .="'" . $subject['writer'] . "',";
  $sql .="'" . $subject['date'] . "',";
  $sql .="'" . $subject['contents'] . "'";
  $sql .= ")";

  $result = mysqli_query($db, $sql);
  
  if($result){
    return true;
  } else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
  }
  }


  function find_subject_by_id($id){
    global $db;

    $id = $_GET['id'];

    $sql = "SELECT * FROM house ";
    $sql .= "WHERE id='" . $id . "'";
    $result = mysqli_query($db, $sql);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject;
  }
?>