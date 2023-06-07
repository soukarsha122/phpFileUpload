<?php
$valid_extensions = array('php', 'html', 'js', 'xml');
$upload_dir = 'uploads/';

if(isset($_FILES['files'])) {
  $errors = array();
  $successes = array();

  foreach($_FILES['files']['tmp_name'] as $key => $tmp_name) {
    $file_name = $_FILES['files']['name'][$key];
    $file_size = $_FILES['files']['size'][$key];
    $file_tmp = $_FILES['files']['tmp_name'][$key];
    $file_type = $_FILES['files']['type'][$key];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if(in_array($file_ext, $valid_extensions) === false) {
      $errors[] = "File extension '{$file_ext}' not allowed.";
      continue;
    }

    if($file_size > 10240) {
      $errors[] = "File '{$file_name}' is too large (max 10KB).";
      continue;
    }

    $new_file_name = uniqid() . '_' . $file_name;
    $upload_path = $upload_dir . $new_file_name;
    if(move_uploaded_file($file_tmp, $upload_path)) {
      $successes[] = "File '{$file_name}' uploaded successfully.";
    } else {
      $errors[] = "An error occurred while uploading '{$file_name}'.";
    }
  }

  if(!empty($errors)) {
    echo '<h2>Errors:</h2><ul>';
    foreach($errors as $error) {
      echo "<li>{$error}</li><br>";
    }
    echo '</ul>';
  }

  if(!empty($successes)) {
    echo '<h2>Successes:</h2><ul>';
    foreach($successes as $success) {
      echo "<li>{$success}</li>";
    }
    echo '</ul>';
  }
}
?>

<form action="" method="post" enctype="multipart/form-data">
  <label for="files">Choose files to upload (max 5):</label>
  <input type="file" name="files[]" id="files" multiple accept=".php, .html, .js, .xml">
  <br>
  <input type="submit" value="Upload">
</form>
