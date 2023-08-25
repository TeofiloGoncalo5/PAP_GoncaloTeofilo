<?php

// Include your database connection file
include '../db.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the post ID from the request
    $postId = $_POST['post_id'];

    // First, delete the comments associated with the post
    $commentsQuery = "DELETE FROM comments WHERE idpost = $postId";
    $commentsResult = mysqli_query($conn, $commentsQuery);

    if (!$commentsResult) {
        // Handle the case where comments deletion fails
        $response = array(
            'success' => false,
            'message' => 'Failed to delete comments.'
        );
    } else {
        // Comments deleted successfully, now delete the post
        $postQuery = "DELETE FROM user_posts WHERE id = $postId";
        $postResult = mysqli_query($conn, $postQuery);

        if (!$postResult) {
            // Handle the case where post deletion fails
            $response = array(
                'success' => false,
                'message' => 'Failed to delete post.'
            );
        } else {
            // Post and comments deleted successfully
            $response = array(
                'success' => true,
                'message' => 'Post and associated comments deleted successfully.'
            );
        }
    }

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle the case where the request method is not POST
    $response = array(
        'success' => false,
        'message' => 'Invalid request method. Only POST requests are allowed.'
    );

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
