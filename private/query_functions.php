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
    $sql .= "title='" . db_escape($db, $subject['title']) . "',";
    $sql .= "writer='" . db_escape($db, $subject['writer']) . "',";
    $sql .= "contents='" . db_escape($db, $subject['contents']) . "'";
    $sql .= "WHERE id='" . db_escape($db, $subject['id']) . "'";
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
    $sql .= "(title, writer, date, contents, image) ";
    $sql .= "VALUES (";
    $sql .="'" . db_escape($db, $subject['title']) . "',";
    $sql .="'" . db_escape($db, $subject['writer']) . "',";
    $sql .="'" . db_escape($db, $subject['date']) . "',";
    $sql .="'" . db_escape($db, $subject['contents']) . "',";
    $sql .="'" . db_escape($db, $subject['image']) . "'";
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
    $sql .= "WHERE id='". db_escape($db, $id) . "' ";
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
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
    $result = mysqli_query($db, $sql);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject;
  }

  function validate_subject($subject) {
    global $db;
    $errors = [];
    
    // title
    if(is_blank(db_escape($db, $subject['title']))) {
      $errors[] = "Title cannot be blank.";
    } elseif(!has_length($subject['title'], ['min' => 2, 'max' => 50])) {
      $errors[] = "Title must be between 2 and 50 characters.";
    }
  
    // contents
    if(is_blank(db_escape($db, ($subject['contents'])))) {
      $errors[] = "contents cannot be blank.";
    } elseif(!has_length($subject['title'], ['min' => 2, 'max' => 255])) {
      $errors[] = "contents must be between 2 and 50 characters.";
    }

    return $errors;
  }
  
  function insert_admin($admin) {
    global $db;

    $errors = validate_admin($admin);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['email']) . "',";
    $sql .= "'" . db_escape($db, $admin['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function validate_admin($admin, $options=[]) {

    $password_required = $options['password_required'] ?? true;

    if(is_blank($admin['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($admin['email'], array('max' => 255))) {
      $errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($admin['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if(is_blank($admin['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($admin['username'], array('min' => 6, 'max' => 12))) {
      $errors[] = "Username must be between 6 and 12 characters.";
    } elseif (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
      $errors[] = "Username not allowed. Try another.";
    }

    if($password_required) {
      if(is_blank($admin['password'])) {
        $errors[] = "Password cannot be blank.";
      } elseif (!has_length($admin['password'], array('min' => 8))) {
        $errors[] = "Password must contain 8 or more characters";
      } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      } elseif($admin['username'] == $admin['password']) {
        $errors[] = "Username and password must be different";
      }

      if(is_blank($admin['confirm_password'])) {
        $errors[] = "Confirm password cannot be blank.";
      } elseif ($admin['password'] !== $admin['confirm_password']) {
        $errors[] = "Password and confirm password must match.";
      }
    }

    return $errors;
  }

  function find_all_admins() {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";
    $result = mysqli_query($db, $sql);
    return $result;
  }

  function find_admin_by_id($id) {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
  }

  function find_admin_by_username($username) {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
  }



  function update_admin($admin) {
    global $db;

    $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin, ['password_required' => $password_sent]);
    if (!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE admins SET ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
    if($password_sent) {
      $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);
      $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
    }
    $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function delete_admin($admin) {
    global $db;

    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
?>