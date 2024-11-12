<?php
session_start();

include '../classes/database-connect.php';
include '../classes/feedback-ctrl.php';

$feedback = new FeedbackCtrl();

if (isset($_GET['id'])) {
    $feedback_id = $_GET['id'];
    $user_id = $_SESSION['userid'];

    $feedback->addLike($feedback_id, $user_id);

    header("location: ../views/homepage.php?message=Like Added");
}
