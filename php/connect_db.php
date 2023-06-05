<?php
    $user = 'root';
    $pass = '';
    // Data Source Name
    $dsn = 'mysql:host=localhost;dbname=zenor';
    try{ //tentative de connexion : on crée un objet de la classe PDO
        $dbh= new PDO($dsn, $user, $pass);
    } catch (PDOException $e){
        print "Erreur ! :" . $e->getMessage() . "<br/>";
        die();
    }
?>