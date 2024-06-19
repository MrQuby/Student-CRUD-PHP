<?php
include_once("config.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$student = null;
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $statement = $conn->prepare("SELECT * FROM student WHERE student_id = :student_id");
    $statement->bindValue(':student_id', $student_id, PDO::PARAM_INT);
    $statement->execute();
    $student = $statement->fetch(PDO::FETCH_ASSOC);
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $sname = $_POST['sname'];
    $sgender = $_POST['sgender'];
    $saddress = $_POST['saddress'];
    $sstatus = $_POST['sstatus'];
  
    if (!$sname) {
        $errors[] = 'Student Name is Required';
    }

    if (empty($errors)) {
        $statement = $conn->prepare("UPDATE student SET student_name = :sname, student_gender = :sgender, student_address = :saddress, student_status = :sstatus WHERE student_id = :student_id");

        $statement->bindValue(':sname', $sname);
        $statement->bindValue(':sgender', $sgender);
        $statement->bindValue(':saddress', $saddress);
        $statement->bindValue(':sstatus', $sstatus);
        $statement->bindValue(':student_id', $student_id, PDO::PARAM_INT);

        if ($statement->execute()) {
            // Redirect back to index.php after successful update
            header("Location: index.php");
            exit();
        } else {
            $errors[] = 'Error: Unable to update student.';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
</head>
<body>
    <h1>Edit Student</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
          <div><?php echo $error ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($student): ?>
    <form action="update.php" method="post">
      <input type="hidden" name="student_id" value="<?php echo $student['student_id'] ?>">
      <div class="mb-3">
        <label for="sname" class="form-label">Student Name</label>
        <input type="text" name="sname" value="<?php echo $student['student_name'] ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label for="sgender" class="form-label">Gender</label>
        <select name="sgender" class="form-select">
          <option value="Male" <?php echo $student['student_gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
          <option value="Female" <?php echo $student['student_gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="saddress" class="form-label">Address</label>
        <input type="text" name="saddress" value="<?php echo $student['student_address'] ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label for="sstatus" class="form-label">Status</label>
        <select name="sstatus" class="form-select">
          <option value="ACTIVE" <?php echo $student['student_status'] == 'ACTIVE' ? 'selected' : '' ?>>ACTIVE</option>
          <option value="INACTIVE" <?php echo $student['student_status'] == 'INACTIVE' ? 'selected' : '' ?>>INACTIVE</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
    <?php else: ?>
      <div class="alert alert-danger">Error: Student not found.</div>
    <?php endif; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
