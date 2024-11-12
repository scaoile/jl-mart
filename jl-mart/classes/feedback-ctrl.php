<?php

class FeedbackCtrl extends DatabaseConnect
{

    public function submitFeedback($id, $rating, $review)
    {
        $query = $this->connect()->prepare("INSERT INTO product_feedback (user_id, rating, comment) VALUES (?, ?, ?);");

        try {
            $query->execute([$id, $rating, $review]);
        } catch (PDOException $e) {
            header("location: ../views/homepage.php?message=Error Requesting Data");
            $query = null;
            exit();
        }
    }

    public function getFeedback()
    {
        $query = $this->connect()->prepare("
            SELECT 
                product_feedback.id AS feedback_id,
                product_feedback.user_id,
                users.name AS user_name,  -- Get the user's name
                product_feedback.rating,
                product_feedback.comment,
                product_feedback.reply,
                product_feedback.created_at,
                COUNT(feedback_likes.feedback_id) AS likes_count
            FROM 
                product_feedback
            LEFT JOIN 
                feedback_likes ON feedback_likes.feedback_id = product_feedback.id
            JOIN 
                users ON product_feedback.user_id = users.id  -- Join with the users table
            GROUP BY 
                product_feedback.id
            ORDER BY 
                product_feedback.created_at DESC;
        ");

        if (!$query->execute()) {
            $query = null;
            header("location: ../views/homepage.php?message=Error Requesting Data");
            exit();
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = null;
        return $result;
    }

    public function addLike($feedback_id, $user_id)
    {
        try {
            // Check if the feedback_id exists in product_feedback table
            $checkQuery = $this->connect()->prepare("SELECT id FROM product_feedback WHERE id = ?");
            $checkQuery->execute([$feedback_id]);

            if ($checkQuery->rowCount() > 0) {
                // Insert or update the timestamp if a like already exists from the same user
                $query = $this->connect()->prepare("
                INSERT INTO feedback_likes (feedback_id, user_id, created_at) 
                VALUES (?, ?, NOW())
                ON DUPLICATE KEY UPDATE created_at = NOW()
            ");
                $query->execute([$feedback_id, $user_id]);
                echo "Like added successfully.";
            } else {
                echo "Error: Feedback not found.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function replyFeedback($feedback_id, $reply)
    {
        $query = $this->connect()->prepare("UPDATE product_feedback SET reply = ? WHERE id = ?;");

        try {
            $query->execute([$reply, $feedback_id]);
        } catch (PDOException $e) {
            header("location: ../views/homepage.php?message=Error Requesting Data");
            $query = null;
            exit();
        }
    }

    public function deleteFeedback($feedback_id)
    {
        $query = $this->connect()->prepare("DELETE FROM product_feedback WHERE id = ?;");

        try {
            $query->execute([$feedback_id]);
        } catch (PDOException $e) {
            header("location: ../views/adminReviews.php?message=Error Requesting Data");
            $query = null;
            exit();
        }
    }
}
