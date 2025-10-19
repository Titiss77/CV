<?php
    $id = "b13_39213320";
    //$id = "root";
    $pwd = "Mmdp2726";
    //$pwd = "";
    try {
        $connexion = new PDO("mysql:host=sql313.byethost13.com;dbname=b13_39213320_portfolio;charset=utf8mb4", $id, $pwd, [
        //$connexion = new PDO("mysql:host=localhost;dbname=b13_39213320_portfolio;charset=utf8mb4", $id, $pwd, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true,
        ]);
        
    } catch (PDOException $e) {
        die("<p>Erreur de connexion. Contactez l'administrateur.</p>");
    }
?>
