<?php
    function connect()
    {
        $conn = new mysqli("localhost", "root", "", "sanp");
        return $conn;
    }
?>