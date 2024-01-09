<?php
include_once "connection.php";

class SQLqueries extends Connection{
    public $conn;

    function __construct(){
        $this->conn = parent::connect();
    }

    public function selectQuery($table, $column , $where = NULL, $orderby = NULL , $limit=NULL) {
        $sql = "SELECT $column FROM $table";
        
        if ($where !== NULL) {
            $sql .= " WHERE $where";
        }
    
        if ($orderby !== NULL) {
            $sql .= " ORDER BY $orderby";
        }

        if($limit !== NULL) {
            $sql .= " LIMIT $limit";
        }
    
        // return $sql;

        $result = mysqli_query($this->conn, $sql);
        // Check for errors
        if (!$result) {
            die("Error in query: " . mysqli_error($this->conn));
        }
        return $result;
    }

    public function insertQuery($table, $columns, $values) {

        $columns = implode(', ', $columns);
        $values = "'" . implode("', '", $values) . "'";

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";


        // return $sql;
        $result = mysqli_query($this->conn, $sql);

        // Check for errors
        if (!$result) {
            die("Error in query: " . mysqli_error($this->conn));
        }

        return $result;
    }

    public function deleteQuery($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        // return $sql;
        $result = mysqli_query($this->conn, $sql);

        // Check for errors
        if (!$result) {
            die("Error in query: " . mysqli_error($this->conn));
        }

        return $result;
    }
}

?>