<?php
include_once("config.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    
    if ($student_id) {
        $statement = $conn->prepare("DELETE FROM student WHERE student_id = :student_id");
        $statement->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        
        if ($statement->execute()) {
            // Redirect back to index.php after successful deletion
            header("Location: index.php");
            exit();
        } else {
            // Display error message if deletion fails
            echo "Error: Unable to delete student.";
        }
    } else {
        echo "Error: Student ID is missing.";
    }
} else {
    echo "Error: Invalid request method.";
}
?>
