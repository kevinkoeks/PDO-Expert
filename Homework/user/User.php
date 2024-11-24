<?php
class User
{
    private $db;

    public function __construct($db) {
        $this->db = $db; // Pass database object ($db) to User-class
        session_start(); //Start session in __construct for each new user
    }

    // Register user 
    public function register($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $this->db->run("INSERT INTO users (username, password) VALUES (:username, :password)", [
            ':username' => $username,
            ':password' => $hashedPassword
        ]);   
    }


    public function login($username, $password)
    {
        $userDB = $this->db->run("SELECT * FROM users WHERE username = :username", [
            ':username' => $username ])->fetch(); // Fetch info from the PDOstatement object
        

        if ($userDB && password_verify($password, $userDB['password'])) {
            // Store user data in session  
            $_SESSION["username"] = $userDB["username"];
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        // Clear the session data
        session_unset();
        session_destroy();
    }

    // Checks if a session is running (true/false)
    public function isLoggedIn()
    {
        return isset($_SESSION['username']);
    }
}
