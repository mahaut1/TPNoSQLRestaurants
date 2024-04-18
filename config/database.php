<?php
require_once 'vendor/autoload.php';  // Assurez-vous que le composer a bien installé les dépendances

function getMongoDB() {
    $client = new MongoDB\Client("mongodb://92.222.79.73:PORT/");  // Remplacez PORT par le port réel
    return $client->nom_de_la_base_de_donnees;  // Remplacez par le nom de votre base de données
}
?>
