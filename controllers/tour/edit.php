<?php
require_once './constants/constants.php';

use Core\App;
use Core\Database;
use Models\Tour;

$db = App::resolve(Database::class);

$tourModel = new Tour($db);

$heading = "Edit Tour";

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 
$tourId = urldecode($_GET['param1']);

if ($tourId) {
    $tour = $tourModel->getTourById($tourId);

    // Decode the tour_tourtype JSON string into an array
    $tourTypesArray = json_decode($tour['tour_tourtype'], true);

    // Ensure it's an array
    if (!is_array($tourTypesArray)) {
        $tourTypesArray = [];
    }

    // Pass the decoded array to the view
    require "views/spolucesty/tvojeSpolucestaDetail.php";
}
