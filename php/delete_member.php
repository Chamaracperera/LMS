<?php
include_once 'db.php';

if (isset($_GET['id'])) {
    $member_id = $_GET['id']; 

    
    if ($stmt = $conn->prepare("DELETE FROM member WHERE member_id = ?")) {
        $stmt->bind_param("s", $member_id); 

       
        if ($stmt->execute()) {
            $stmt->close();
            
            header("Location: display_member.php");
            exit();
        } else {
            echo "Error executing query: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
