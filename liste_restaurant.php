<?php
session_start();
require 'config/database.php';  

// Connexion à MongoDB
$db = getMongoDB();

// Gérer les paramètres de tri
$sortField = $_GET['sort'] ?? 'name';  // Champ par défaut
$sortOrder = $_GET['order'] ?? 1;  // Ordre croissant par défaut

// Cartographie des champs valides pour le tri
$validSortFields = [
    'name' => 'name',
    '_id' => 'restaurant_id',
    'insertion_order' => 'insertion_order',
    'cuisine_types' => 'cuisine_type',
    'city' => 'district',
    'zip_code' => 'zipcode'
];

// Valider et appliquer le champ de tri
if (!array_key_exists($sortField, $validSortFields)) {
    $sortField = 'name';  // Retour au tri par défaut si le champ n'est pas valide
}
$sortCriteria = [$validSortFields[$sortField] => (int)$sortOrder];

// Requête à la base de données
$restaurants = $db->restaurants->find([], ['sort' => $sortCriteria]);

?>
<html>
<head>
    <title>Liste des Restaurants</title>
</head>
<body>
    <h1>Liste des Restaurants</h1>
    <form>
        Trier par :
        <select name="sort" onchange="this.form.submit()">
            <option value="name">Nom</option>
            <option value="_id">ID Restaurant</option>
            <option value="insertion_order">Ordre d'Insertion</option>
            <option value="cuisine_type">Type de Cuisine</option>
            <option value="district">Arrondissement</option>
            <option value="zipcode">Code Postal</option>
        </select>
        <select name="order" onchange="this.form.submit()">
            <option value="1">Croissant</option>
            <option value="-1">Décroissant</option>
        </select>
    </form>
    <ul>
        <?php foreach ($restaurants as $restaurant) { ?>
            <li><?php echo htmlspecialchars($restaurant['name']); ?></li>
        <?php } ?>
    </ul>
</body>
</html>
