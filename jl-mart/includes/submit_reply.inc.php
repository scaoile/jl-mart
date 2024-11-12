<?php

include '../classes/database-connect.php';
include '../classes/feedback-ctrl.php';

$feedbackCtrl = new FeedbackCtrl();

$id = $_GET['id'];
$reply = $_POST['reply'];

$feedbackCtrl->replyFeedback($id, $reply);

header("location: ../views/adminReviews.php?message=Reply Submitted");
