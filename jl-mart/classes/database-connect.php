<?php

include "../config.php";

class DatabaseConnect
{

    //Connects with the database
    protected function connect()
    {
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=jl_mart_db;', DB_USER, DB_PASS);
            return $dbh;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br>";
        }
    }
}
