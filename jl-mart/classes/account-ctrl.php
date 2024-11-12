<?php

class AccountCtrl extends DatabaseConnect
{
    public function updateInfo($id, $name, $email, $password, $phone_number, $address_line1, $address_line2, $address_line3, $city, $landmark, $postal_code, $country)
    {
        echo $phone_number;

        $query = $this->connect()->prepare("UPDATE users SET name = ?, email = ?, password = ?, phone_number = ?, address_line1 = ?, address_line2 = ?, address_line3 = ?, city = ?, landmark = ?, postal_code = ?, country = ? WHERE id = ?;");
        // Checks if the query ran, if not sends the user back into the inventory page
        try {
            $query->execute([$name, $email, $password, $phone_number, $address_line1, $address_line2, $address_line3, $city, $landmark, $postal_code, $country, $id]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation
                header("location: ../views/accountSetting.php?message=Duplicate Email");
            } else {
                header("location: ../views/accountSetting.php?message=Error Requesting Data");
            }
            $query = null;
            exit();
        }
    }

    public function getInfo($user_id)
    {
        $query = $this->connect()->prepare("SELECT * FROM users WHERE id = ?;");

        if (!$query->execute([$user_id])) {
            $query = null;
            header("location: ../views/accountSetting.php?message=Error Requesting Data");
            exit();
        }

        $result = $query->fetch(PDO::FETCH_ASSOC);
        $query = null;
        return $result;
    }

    public function getAddresses($user_id)
    {
        $query = $this->connect()->prepare("SELECT address_line1, address_line2, address_line3 FROM users WHERE id = ?;");

        if (!$query->execute([$user_id])) {
            $query = null;
            header("location: ../views/accountSetting.php?message=Error Requesting Data");
            exit();
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = null;
        return $result;
    }
}
