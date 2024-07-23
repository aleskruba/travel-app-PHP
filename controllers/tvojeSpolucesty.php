<?php

use Core\App;
use Core\Database;
use Models\Tour;

$db = App::resolve(Database::class);

$tourModel = new Tour($db);

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

if ($currentUser !== null) {
    $result = $tourModel->getTourByUser($currentUser);

    $yourTours = [];

    foreach ($result as $row) {
        $tourTypes = json_decode($row['tour_tourtype'], true);

        $yourTours[] = [
            'id' => $row['tour_id'],
            'destination' => $row['tour_destination'],
            'date' => $row['tour_date'],
            'tourdate' => $row['tour_tourdate'],
            'tourdateEnd' => $row['tour_tourdateEnd'],
            'tourtype' => $tourTypes,
            'fellowtraveler' => $row['tour_fellowtraveler'],
            'aboutme' => $row['tour_aboutme'],
            'user_id' => $row['user_id'],
            'user_firstName' => $row['user_firstName'],
            'user_email' => $row['user_email'],
            'user_image' => $row['user_image'],
        ];
    }

   

    require 'views/tvojespolucesty.view.php';
} else {
    // Handle the case where the user is not logged in
    echo "User is not logged in.";
    exit;
}
