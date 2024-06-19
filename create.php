<?php
  include_once("config.php");

  //echo '<pre>';
  //var_dump($_SERVER);
  //echo '<pre>';
  $errors = [];
  $result = false;
  $message = 'Added Successfully';
  $sname = '';
  $sgender = '';
  $saddress = '';
  $sstatus = '';

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $sname = $_POST['sname'];
    $sgender = $_POST['sgender'];
    $saddress = $_POST['saddress'];
    $sstatus = $_POST['sstatus'];
    
    if(!$sname){
      $errors[] = 'Student Name is Required';
    }
    if(!$saddress){
      $errors[] = 'Address is Required';
    }

    if(empty($errors)){
      $statement = $conn->prepare("INSERT INTO student (student_name, student_gender, student_address, student_status) VALUES (:sname, :sgender, :saddress, :sstatus)");

      $statement->bindValue(':sname', $sname);
      $statement->bindValue(':sgender', $sgender);
      $statement->bindValue(':saddress', $saddress);
      $statement->bindValue(':sstatus', $sstatus);

      $result = $statement->execute();

      if ($result) {
        // Reset variables to clear the form fields
        $sname = '';
        $sgender = '';
        $saddress = '';
        $sstatus = '';
      }
    }
  }
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
  </head>
  <body>
    <h1>Add Student</h1>

    <?php if(!empty($errors)):?>
      <div class="alert alert-danger">
        <?php foreach($errors as $error): ?>
          <div> <?php echo $error ?> </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if($result):?>
      <div class ="alert alert-success">
        <?php echo 'Added Successfully' ?>
      </div>
    <?php endif; ?>

    <form action="" method="post">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Student Name</label>
        <input type="text" name="sname" value ="<?php echo $sname?>" class="form-control">
      </div>
      <div class="mb-3">
      <label for="inputState" class="form-label">Gender</label>
        <select id="inputState" name="sgender" class="form-select">
          <option value="Male" <?php echo $sgender === 'Male' ? 'selected' : '' ?>>Male</option>
          <option value="Female" <?php echo $sgender === 'Female' ? 'selected' : '' ?>>Female</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Address</label>
        <input type="text" name="saddress" value ="<?php echo $saddress?>" class="form-control">
      </div>
      <div class="mb-3">
        <label for="inputState" class="form-label">Status</label>
        <select id="inputState" name="sstatus" class="form-select">
          <option value="ACTIVE" <?php echo $sstatus === 'ACTIVE' ? 'selected' : '' ?>>ACTIVE</option>
          <option value="INACTIVE" <?php echo $sstatus === 'INACTIVE' ? 'selected' : '' ?>>INACTIVE</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      <a href = "index.php" type="submit" class="btn btn-secondary">Back</a>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>