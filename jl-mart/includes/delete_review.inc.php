<?php

include '../classes/database-connect.php';
include '../classes/feedback-ctrl.php';

$feedbackCtrl = new FeedbackCtrl();

if (isset($_POST['submit'])) {
    $id = $_GET['id'];

    $feedbackCtrl->deleteFeedback($id);

    header("location: ../views/adminReviews.php?message=Review Deleted");
}
