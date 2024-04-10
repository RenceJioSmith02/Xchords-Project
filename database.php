<?php
    class Database {
        function getConnection() {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "e-commercedb";
    
            $connection = mysqli_connect($servername, $username, $password, $database);
            if (!$connection) {
                die("Connection Failed ".mysqli_connect_errror());
            } 
            // echo "Connection Success!";
            return $connection;
        }

        function close($connection) {
            if ($connection) {
                mysqli_close($connection);
            }
        }
    }

?>