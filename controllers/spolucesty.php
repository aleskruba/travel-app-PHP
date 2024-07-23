<?php
require_once './constants/constants.php';
use Core\App;
use Core\Database;
use Models\Tour;

// Resolve dependencies
$db = App::resolve(Database::class);

$heading = 'spolucesty';
$emptyParam = false;

// Instantiate Tour model
$tourModel = new Tour($db);

// Initialize filter variables
$destination = isset($_GET['destination']) ? $_GET['destination'] : null;
$tourtype = isset($_GET['tourtype']) ? $_GET['tourtype'] : null;
$date = isset($_GET['date']) ? $_GET['date'] : null;

// Fetch filtered tours if any filter is applied
if (!empty($destination) || !empty($tourtype) || !empty($date)) {
    $result = $tourModel->getFilteredTours($destination, $tourtype, $date);
} else {
    // Fetch all tours if no filters are applied
    $result = $tourModel->getAllTours();
}

$resultSelect = $tourModel->getAllTours();

$tours = [];
$destinationSet = []; // Initialize destination set

// Loop through each tour result and structure it
foreach ($result as $row) {
    // Decode JSON string for tourtype
    $tourTypes = json_decode($row['tour_tourtype'], true); // Assuming tour_tourtype is the correct key

    // Build tour array including user details
    $tours[] = [
        'id' => $row['tour_id'], // Update alias for tour_id
        'destination' => $row['tour_destination'], // Assuming destination is correctly fetched
        'date' => $row['tour_date'], // Update alias for tour_date
        'tourdate' => $row['tour_tourdate'], // Update alias for tour_tourdate
        'tourdateEnd' => $row['tour_tourdateEnd'], // Update alias for tour_tourdateEnd
        'tourtype' => $tourTypes, // Array of tour types
        'fellowtraveler' => $row['tour_fellowtraveler'], // Update alias for tour_fellowtraveler
        'aboutme' => $row['tour_aboutme'], // Update alias for tour_aboutme
        'user_id' => $row['user_id'],
        'user_firstName' => $row['user_firstName'],
        'user_email' => $row['user_email'],
        'user_image' => $row['user_image'],

    ];


}

foreach ($resultSelect as $row) {

    $destination = $row['tour_destination'];
    if (!isset($destinationSet[$destination])) {
        $destinationSet[$destination] = true;
    }
}
$uniqueDestinations = array_keys($destinationSet);


require 'views/spolucesty.view.php';
?>
