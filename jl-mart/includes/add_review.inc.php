<?php

session_start();

include '../classes/database-connect.php';
include '../classes/feedback-ctrl.php';

$feedbackCtrl = new FeedbackCtrl();

if (isset($_POST['submit'])) {
    $id = $_SESSION['userid'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $feedbackCtrl->submitFeedback($id, $rating, $review);

    header("location: ../views/homepage.php?message=Review Submitted");
}
