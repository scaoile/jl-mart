<?php

class HomepageCtrl extends DatabaseConnect
{
    public function getHomepage()
    {

        $query = $this->connect()->prepare("SELECT * FROM homepage_banners WHERE id = 1;");
        //Checks if the query ran if not sends the user back into the login page
        if (!$query->execute()) {
            $query = null;

            header("location: ../views/homepage.php?error=queryfailed");
            exit();
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateMain($title, $description, $image)
    {
        $query = $this->connect()->prepare("UPDATE homepage_banners SET main_title = ?, main_description = ?, main_img = ? WHERE id = 1;");
        // Checks if the query ran, if not sends the user back into the inventory page
        if (!$query->execute([$title, $description, $image])) {
            $query = null;

            header("location: ../views/adminDashboard.php?error=queryfailed");
            exit();
        }
    }

    public function updateDiscount($discount)
    {
        $query = $this->connect()->prepare("UPDATE homepage_banners SET discount = ? WHERE id = 1;");
        // Checks if the query ran, if not sends the user back into the inventory page
        if (!$query->execute([$discount])) {
            $query = null;

            header("location: ../views/adminDashboard.php?error=queryfailed");
            exit();
        }
    }

    public function updateLeftCard($title, $image)
    {
        $query = $this->connect()->prepare("UPDATE homepage_banners SET left_product_title = ?, left_product_img = ? WHERE id = 1;");
        // Checks if the query ran, if not sends the user back into the inventory page
        if (!$query->execute([$title, $image])) {
            $query = null;

            header("location: ../views/adminDashboard.php?error=queryfailed");
            exit();
        }
    }

    public function updateMiddleCard($title, $image)
    {
        $query = $this->connect()->prepare("UPDATE homepage_banners SET middle_product_title = ?, middle_product_img = ? WHERE id = 1;");
        // Checks if the query ran, if not sends the user back into the inventory page
        if (!$query->execute([$title, $image])) {
            $query = null;

            header("location: ../views/adminDashboard.php?error=queryfailed");
            exit();
        }
    }

    public function updateRightCard($title, $image)
    {
        $query = $this->connect()->prepare("UPDATE homepage_banners SET right_product_title = ?, right_product_img = ? WHERE id = 1;");
        // Checks if the query ran, if not sends the user back into the inventory page
        if (!$query->execute([$title, $image])) {
            $query = null;

            header("location: ../views/adminDashboard.php?error=queryfailed");
            exit();
        }
    }
}
