<?

//ajouter un restaurant au favoris
$db->users->updateOne(
    ["_id" => new MongoDB\BSON\ObjectId($userId)],
    ['$addToSet' => ['favorites' => new MongoDB\BSON\ObjectId($restaurantId)]]
);

//supprimer un restaurant des favoris
$db->users->updateOne(
    ["_id" => new MongoDB\BSON\ObjectId($userId)],
    ['$pull' => ['favorites' => new MongoDB\BSON\ObjectId($restaurantId)]]
);
