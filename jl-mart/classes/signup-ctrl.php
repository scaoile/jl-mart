<?php

class SignupCtrl extends DatabaseConnect
{
    private $name;
    private $email;
    private $phone;
    private $address;
    private $password;
    private $confirm_password;


    public function __construct($name, $email, $phone, $address, $password, $confirm_password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
    }

    //Checks for error if errors aren't found signs up the user
    public function signupUser()
    {
        if ($this->emptyInput() == false) {
            header("location: ../views/signup.php?message=Empty Input");
            exit();
        }
        if ($this->invalidName() == false) {
            header("location: ../views/signup.php?message=Error Invalid Name");
            exit();
        }
        if ($this->invalidEmail() == false) {
            header("location: ../views/signup.php?message=Error Email Taken");
            exit();
        }
        if ($this->passwordMatch() == false) {
            header("location: ../views/signup.php?message=Passwords do not match");
            exit();
        }
        if ($this->userCheck() == false) {
            header("location: ../views/signup.php?message=User already exists");
            exit();
        }

        $this->setUser($this->name, $this->email, $this->phone, $this->address, $this->password);
    }

    private function emptyInput()
    {
        $result = false;

        if (
            empty($this->name) ||
            empty($this->email) ||
            empty($this->password) ||
            empty($this->confirm_password)
        ) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function invalidName()
    {
        $result = false;
        if (
            !preg_match("/^[a-zA-Z]*$/", $this->name)
        ) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function invalidEmail()
    {
        $result = false;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function passwordMatch()
    {
        $result = false;
        if ($this->password !== $this->confirm_password) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function userCheck()
    {
        $result = false;
        if (!$this->checkUser($this->name, $this->email)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    protected function setUser($name, $email, $phone, $address, $password)
    {

        //Query to insert the users details into the database
        $query = $this->connect()->prepare('INSERT INTO users (name, email, password, phone_number, address_line1)
                                            Values(?, ?, ?, ?, ?);');

        //Hashes the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //Checks if the query ran if not sends the user back into the sign up page
        if (!$query->execute(array($name, $email, $hashedPassword, $phone, $address))) {
            $query = null;
            header("location: ../views/signup.php?message=Error Requesting Data");
            exit();
        }

        $query = null;
    }

    protected function checkUser($name, $email)
    {

        //Query to get columns
        $query = $this->connect()->prepare('SELECT name FROM users WHERE name = ? OR email = ?;');

        //Checks if the query ran if not sends the user back into the sign up page
        if (!$query->execute(array($name, $email))) {
            $query = null;
            header("location: ../views/signup.php?message=Error Requesting Data");
            exit();
        }

        //Checks if the query returned a data/row
        $resultCheck = false;
        if ($query->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }
}
