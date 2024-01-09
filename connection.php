<?php
class Connection {
    public function connect() {
        session_start();
        $conn = mysqli_connect('localhost', 'root', '', 'quiz');

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } 
        return $conn; 
    }
} 

$userConnect = new Connection;
$conn = $userConnect->connect();
?>
