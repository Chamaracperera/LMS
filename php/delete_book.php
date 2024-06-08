<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_name'])) {
    header("Location:../index.html");
    exit;
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Check for related records in bookborrower table
        $stmt1 = $conn->prepare("SELECT COUNT(*) FROM bookborrower WHERE book_id = ?");
        $stmt1->bind_param("s", $book_id);
        $stmt1->execute();
        $stmt1->bind_result($count);
        $stmt1->fetch();
        $stmt1->close();

        if ($count > 0) {
            // Delete related records in bookborrower table
            $stmt2 = $conn->prepare("DELETE FROM bookborrower WHERE book_id = ?");
            $stmt2->bind_param("s", $book_id);
            $stmt2->execute();
            $stmt2->close();
        }

        // Delete record in book table
        $stmt3 = $conn->prepare("DELETE FROM book WHERE book_id = ?");
        $stmt3->bind_param("s", $book_id);
        $stmt3->execute();
        $stmt3->close();

        // Commit transaction
        $conn->commit();
        
        header("Location: display_book.php?stat=Book_Deleted");
        exit();
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        echo "Error: " . $exception->getMessage();
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
