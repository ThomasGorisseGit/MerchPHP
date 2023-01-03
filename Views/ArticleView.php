<?php
require "../script/connexionDatabase.php";

$query = "SELECT * FROM Article";
$stmt = $db->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($data);
