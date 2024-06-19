<?php

include_once("config.php");

$statement = $conn->prepare("SELECT * FROM student");
$statement->execute();
$student = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
</head>
<body>
    <h1>Student List</h1>
    <a href="create.php" type="button" class="btn btn-success">Add Student</a>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Number</th>
                <th scope="col">Full Name</th>
                <th scope="col">Gender</th>
                <th scope="col">Address</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($student as $i => $student): ?>
                <tr>
                    <th scope="row"><?php echo $i + 1 ?></th>
                    <td><?php echo $student['student_id'] ?></td>
                    <td><?php echo $student['student_name'] ?></td>
                    <td><?php echo $student['student_gender'] ?></td>
                    <td><?php echo $student['student_address'] ?></td>
                    <td><?php echo $student['student_status'] ?></td>
                    <td>
                        <a href="update.php?student_id=<?php echo $student['student_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <form action="delete.php" method="post" style="display:inline-block;">
                            <input type="hidden" name="student_id" value="<?php echo $student['student_id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
