<?php

class LoginCtrl extends DatabaseConnect
{
    private $email;
    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    //Checks for error if errors aren't found signs up the user
    public function loginUser()
    {
        if ($this->emptyInput() == false) {
            header("location: ../views/login.php?message=Error Empty Input");
            exit();
        }

        $this->getUser($this->email, $this->password);
    }

    private function emptyInput()
    {
        $result = false;

        if (empty($this->email) || empty($this->password)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    protected function getUser($email, $password)
    {

        //Query to grab the password from the database
        $query = $this->connect()->prepare('SELECT * FROM users WHERE email = ?;');

        //Checks if the query ran if not sends the user back into the login page
        if (!$query->execute(array($email))) {
            $query = null;
            header("location: ../views/userLogin.php?message=Error Requesting Data");
            exit();
        }

        if ($query->rowCount() == 0) {
            $query = null;
            header("location: ../views/userLogin.php?message=User cannot be found");
            exit();
        }

        //Hashes the fetched password
        $passwordHashed = $query->fetchAll(PDO::FETCH_ASSOC);
        $checkpassword = password_verify($password, $passwordHashed[0]["password"]);

        //Checks if the inputted password is the same as the Fetched password
        if ($checkpassword == false) {
            $query = null;
            header("location: ../views/userLogin.php?message=Wrong Password Please Try Again");
            exit();
        } elseif ($checkpassword == true) {
            $query = null;
            $query = $this->connect()->prepare('SELECT * FROM users WHERE email = ? AND password = ?;');

            if (!$query->execute(array($email, $passwordHashed[0]["password"]))) {
                $query = null;
                header("location: ../views/userLogin.php?message=Error Requesting Data");
                exit();
            }

            if ($query->rowCount() == 0) {
                $query = null;
                header("location: ../views/userLogin.php?message=User Cannot be Found");
                exit();
            }

            $user = $query->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["userid"] = $user[0]["id"];
            $_SESSION["role"] = $user[0]["role"];
        }

        $query = null;
    }
}
