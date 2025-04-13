<?php
include_once("modeles.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchNumCompte = isset($_GET['search_num']) ? $_GET['search_num'] : '';

$results = [];

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query = "SELECT nom FROM comptes WHERE nom LIKE '%$search%' LIMIT 10";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row['nom'];
    }
} elseif (!empty($searchNumCompte)) {
    $searchNumCompte = mysqli_real_escape_string($conn, $searchNumCompte);
    $query = "SELECT num_compte FROM comptes WHERE num_compte LIKE '%$searchNumCompte%' LIMIT 10";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row['num_compte'];
    }
}

echo json_encode($results);
?>
