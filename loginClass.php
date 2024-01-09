<?php
include "connection.php";
include "classes.php";
session_start();


class AuthLog extends Connection {
    public $conn; 
    public $query;
    function __construct(){
        $this->conn = parent::connect();
        $this->query = new SQLqueries();

        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if (method_exists($this, $action)) {
            echo $this->$action($_REQUEST);
        }
    }

    public function login(){
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
        $count = 0;

        if(!empty($email) and !empty($password)){
            $email = mysqli_real_escape_string($this->conn, $email);
            $password = mysqli_real_escape_string($this->conn, $password); // Escape password as well

            $sql = "SELECT * FROM `users` WHERE password='$password' AND email='$email'";
            $res = mysqli_query($this->conn, $sql);
            $count = mysqli_num_rows($res);
            
            if($count != 0) {
                $row = mysqli_fetch_assoc($res);
                $_SESSION['login'] = true;
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                
                if ($row['role'] == 'admin') {
                    return "admin.php?name=$row[name]";

                } else if ($row['role'] == 'customer') {
                    return "home.php?name=$row[name]";
                }
            } else {
                return "NO USEER";
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        return 'login.php';
    }
}

$auth = new AuthLog();

