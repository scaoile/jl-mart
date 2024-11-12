<?php
session_start();

include '../classes/database-connect.php';
include '../classes/homepage-ctrl.php';
include '../classes/feedback-ctrl.php';

$homepage = new HomepageCtrl();

$homepage = $homepage->getHomepage();

$reviews = new FeedbackCtrl();
$reviews = $reviews->getFeedback();

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Homepage</title>
</head>

<body>
    <div class="main-container">
        <?php include 'nav.php'; ?>

        <div class="banner">
            <div class="left">
                <div class="banner-text">
                    <h2><?php echo $homepage[0]['main_title'] ?></h2>
                    <p><?php echo $homepage[0]['main_description'] ?></p>
                    <a href="products.php">
                        <button class="banner-btn">Shop Now!</button>
                    </a>
                </div>
                <div class="banner-img">
                    <img src="images/<?php echo $homepage[0]['main_img'] ?>">
                </div>
            </div>

            <div class="right">
                <div class="top-right">
                    <p>Enjoy up to <span><?php echo $homepage[0]['discount'] ?>%</span>
                        OFF Product Discount</p>
                </div>
                <div class="down-right">
                    <div class="down-right-text">
                        <p>
                            We'd love to hear your thoughts!
                            <button class="rateButton" onclick="openPopup()">Click me to Rate!</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="category">
            <h1> Explore popular products </h1>
            <img src="images/category-homepage.svg">
        </div>

        <div class="category-container">
            <div class="category-card">
                <img src="images/<?php echo $homepage[0]['left_product_img'] ?>">
                <p><?php echo $homepage[0]['left_product_title'] ?></p>
            </div>

            <div class="category-card2">
                <img src="images/<?php echo $homepage[0]['middle_product_img'] ?>">
                <p><?php echo $homepage[0]['middle_product_title'] ?></p>
            </div>

            <div class="category-card">
                <img src="images/<?php echo $homepage[0]['right_product_img'] ?>">
                <p><?php echo $homepage[0]['right_product_title'] ?></p>
            </div>
        </div>

        <div class="reviews-container">
            <h1> Review and Rating </h1>

            <?php
            foreach ($reviews as $review) {
                echo "
                    <div class='comments'>
                        <div class='top-comment'>
                            <div class='top-left-comment'>
                                <img src='images/user-icon.svg'>
                                <div class='name-date'>
                                    <h2>{$review['user_name']} </h2>
                                    <h3>{$review['created_at']} </h3>
                                </div>
                            </div>
                ";
                if ($review['rating'] == 'Satisfied Product' || $review['rating'] == 'Satisfied Service') {
                    echo "<div class='top-right-comment'>
                                <div class='rate'>{$review['rating']}</div>";
                } else {
                    echo "<div class='top-right-comment'>
                                <div class='rate2'>{$review['rating']}</div>";
                }

                echo "
                                <div class='heart'>
                                    <a class='heart-button' href='../includes/add_like.php?id={$review['feedback_id']}'> &#x2661; </a>
                                    <p> {$review['likes_count']} </p>
                                </div>
                            </div>
                        </div>
                        <div class='main-commnet'>
                            <p> {$review['comment']} </p>
                        </div>
                    </div>
                ";
            }
            ?>
        </div>
    </div>

    <div class="popup-overlay"></div>
    <div class="popup">
        <h2>Rate and Review</h2>
        <h3> Put your ratings here </h3>
        <form method="POST" action="../includes/add_review.inc.php">
            <div class="rating-row">
                <div class="satisfied">
                    <label for="satisfied" class="clickable-label">SATISFIED PRODUCT:</label>
                    <input type="radio" id="satisfied-product" name="rating" value="Satisfied Product">
                </div>
                <div class="bad">
                    <label for="bad" class="clickable-label">BAD PRODUCT:</label>
                    <input type="radio" id="bad-product" name="rating" value="Bad Product">
                </div>
            </div>
            <div class="rating-row">
                <div class="satisfied">
                    <label for="satisfied" class="clickable-label">SATISFIED SERVICE:</label>
                    <input type="radio" id="satisfied-service" name="rating" value="Satisfied Service">
                </div>
                <div class="bad">
                    <label for="bad" class="clickable-label">BAD SERVICE:</label>
                    <input type="radio" id="bad-service" name="rating" value="Bad Service">
                </div>
            </div>
            <p>Put your review below:</p>
            <textarea id="review" name="review" placeholder="Enter your review here" rows="4" cols="50" required></textarea>
            <button type="submit" name='submit' class="submit-review">POST</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function toggleHeart(event) {
            const button = event.target;
            button.classList.toggle('liked');
            button.innerHTML = button.classList.contains('liked') ? '&#x2665;' : '&#x2661;';
        }

        document.querySelectorAll('.heart-button').forEach(button => {
            button.addEventListener('click', toggleHeart);
        });

        function openPopup() {
            document.querySelector('.popup-overlay').style.display = 'block';
            document.querySelector('.popup').style.display = 'block';
        }

        function closePopup() {
            document.querySelector('.popup-overlay').style.display = 'none';
            document.querySelector('.popup').style.display = 'none';
        }
        document.querySelector('.popup-overlay').addEventListener('click', closePopup);
    </script>

</body>

</html>