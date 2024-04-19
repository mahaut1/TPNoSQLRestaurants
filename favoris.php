<?php
session_start();
require 'config/database.php';  // Assurez-vous que cette ligne pointe vers votre fichier de configuration de la base de données

// Connexion à MongoDB
$db = getMongoDB();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['_id'])) {
    header('Location: index.php');  // Redirection vers la page de connexion
    exit();
}

// Gestion des actions d'ajout et de suppression
if (isset($_GET['action'], $_GET['id'])) {
    $userId = $_SESSION['user_id'];
    $restaurantId = new MongoDB\BSON\ObjectId($_GET['id']);

    if ($_GET['action'] == 'add') {
        $db->users->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($userId)],
            ['$addToSet' => ['favorites' => $restaurantId]]
        );
    } elseif ($_GET['action'] == 'remove') {
        $db->users->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($userId)],
            ['$pull' => ['favorites' => $restaurantId]]
        );
    }

    header('Location: favoris.php');  // Recharger la page pour voir les changements
    exit();
}

// Récupérer les favoris de l'utilisateur
$user = $db->users->findOne(['_id' => new MongoDB\BSON\ObjectId($_SESSION['_id'])]);
$favorites = $user['favorites'] ?? [];
$favoriteRestaurants = $db->restaurants->find(['_id' => ['$in' => $favorites]]);

?>
<html>
<head>
    <title>Mes Favoris</title>
</head>
<body>
    <h1>Mes Restaurants Favoris</h1>
    <ul>
        <?php foreach ($favoriteRestaurants as $restaurant) { ?>
            <li>
                <?php echo htmlspecialchars($restaurant['name']); ?>
                <a href="?action=remove&id=<?php echo (string)$restaurant['_id']; ?>">Supprimer des favoris</a>
            </li>
        <?php } ?>
    </ul>
    <a href="liste_restaurants.php">Retour à la liste des restaurants</a>
</body>
</html>
