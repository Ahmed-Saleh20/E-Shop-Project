<?php

      
     /*
      *   
      * This File Include Connection With Database
      *
     */

    $dsn  = 'mysql:host=localhost;dbname=shop';     // Data Source Name
    $user = 'root';                                 // The User To Connect
    $pass = '';                                     // Password of This User

    $option = array(                                // To Make Type Of Data UTF-8
        
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  
    
    );

    try{

        $conn =  new PDO($dsn,$user,$pass,$option);
        $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        //echo "<script> alert('Connected To Database Successfully')</script>";

    }catch(PDOException $e){
        // echo 'Faild To Connect' . $e->getMessage();
        echo "<script> alert('Faild To Connect with Database')</script>";
    }

/*That's Enogh To Connect With Database*/
/*
    $dsn  = 'mysql:host=localhost;dbname=shop';    // Data Source Name
    $user = 'root';                                // The User To Connect
    $pass = '';                                    // Password of This User
    $conn = new PDO($dsn,$user,$pass);
*/

    
?>