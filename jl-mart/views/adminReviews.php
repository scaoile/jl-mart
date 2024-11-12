<?php
session_start();

include '../classes/database-connect.php';
include '../classes/feedback-ctrl.php';

$feedbackCtrl = new FeedbackCtrl();

$feedbacks = $feedbackCtrl->getFeedback();

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminReviews.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Reviews and Ratings</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav-admin.php'; ?>

        <div class="comment-container">
            <h1 class="title"> Reviews and Ratings </h1>

            <?php
            foreach ($feedbacks as $feedback) {
                echo '
                        <div class="comments">
                            <div class="top-comment">
                                <div class="top-left-comment">
                                    <img src="images/user-icon.svg">
                                    <div class="name-date">
                                        <h2>' . htmlspecialchars($feedback['user_name']) . '</h2>
                                        <h3>' . htmlspecialchars($feedback['created_at']) . '</h3>
                                    </div>
                                </div>
                                <div class="top-right-comment">

                        ';
                if ($feedback['rating'] == "Satisfied Product" || $feedback['rating'] == "Satisfied Service") {
                    echo '<div class="rate1">';
                } else if ($feedback['rating'] == "Bad Product" || $feedback['rating'] == "Bad Service") {
                    echo '<div class="rate2">';
                }
                echo '
                                        ' . htmlspecialchars($feedback['rating']) . '
                                    </div>
                                    <div class="heart">
                                        <button class="heart-button" onclick="toggleHeart()">&#x2661;</button>
                                        <p>' . htmlspecialchars($feedback['likes_count']) . '</p>
                                    </div>
                                    <form action="../includes/delete_review.inc.php?id=' . htmlspecialchars($feedback['feedback_id']) . '" method="post" style="display:inline;">
                                        <input type="hidden" name="comment_id" value="' . htmlspecialchars($feedback['feedback_id']) . '">
                                        <button type="submit" name="submit" class="delete-button">
                                            <img src="images/trash-icon.svg" alt="Delete">
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="main-comment">
                                <p>' . htmlspecialchars($feedback['comment']) . '</p>
                            </div>
                            <div class="comment-input">
                            <form action="../includes/submit_reply.inc.php?id=' . htmlspecialchars($feedback['feedback_id']) . '" method="post">
                                <textarea id="new-comment" name="reply" placeholder="Write your comment here...">' . htmlspecialchars($feedback['reply']) . '</textarea>
                                <input type="image" src="images/submit-comment.svg" alt="Submit" class="submit-image">
                            </form>
                        </div>
                    </div>
                    ';
            }
            ?>
        </div>

    </div>

</body>

</html>