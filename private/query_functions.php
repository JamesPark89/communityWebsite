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

    $errors = validate_subject($subject);
    if(!empty($errors)){
      return $errors;
    }

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

    $errors = validate_subject($subject);
    if(!empty($errors)){
      return $errors;
    }
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

  function delete_subject($id) {
    global $db;
    $sql = "DELETE FROM house ";
    $sql .= "WHERE id='". $id . "' ";
    $sql .= "LIMIT 1";
  
    $result = mysqli_query($db, $sql);
  
    //for DELETE statments, $result is true/flase
  
    if($result){
      return true;
    } else {
  
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

  function validate_subject($subject) {

    $errors = [];
    
    // title
    if(is_blank($subject['title'])) {
      $errors[] = "Title cannot be blank.";
    } elseif(!has_length($subject['title'], ['min' => 2, 'max' => 50])) {
      $errors[] = "Title must be between 2 and 50 characters.";
    }
  
    // contents
    if(is_blank($subject['contents'])) {
      $errors[] = "contents cannot be blank.";
    } elseif(!has_length($subject['title'], ['min' => 2, 'max' => 255])) {
      $errors[] = "contents must be between 2 and 50 characters.";
    }

    return $errors;
  }
  
?>