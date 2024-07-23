<?php
use Core\App;
use Core\Database;
use Models\Tour;

// Initialize the database connection
$db = App::resolve(Database::class);

// Check if there's an 'id' parameter in the URL (optional, if you need to use it)
$messageId = isset($_GET['id']) ? $_GET['id'] : null;

$tourModel = new Tour($db);

// Check if the user is logged in and get their ID (assuming you have session management)
$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 

// Check if the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];  // Array to store validation errors
    
    // Retrieve form data
    $destination = isset($_POST['destination']) ? $_POST['destination'] : '';
    $tourdate = isset($_POST['date']) ? $_POST['date'] : '';
    $tourdateEnd = isset($_POST['dateend']) ? $_POST['dateend'] : '';
    $tourtype = isset($_POST['journey_type']) ? $_POST['journey_type'] : []; // Note the correct key 'journey_type'
    $fellowtraveler = isset($_POST['looking_for']) ? $_POST['looking_for'] : '';
    $aboutme = isset($_POST['about_me']) ? $_POST['about_me'] : '';

    // Validate form data
    if (empty($destination)) {
        $errors[] = "Destination cannot be empty.";
    }
    if (empty($tourdate)) {
        $errors[] = "Start date cannot be empty.";
    }
    if (empty($tourdateEnd)) {
        $errors[] = "End date cannot be empty.";
    }
    if (empty($tourtype)) {
        $errors[] = "Tour type cannot be empty.";
    }
    if (empty($fellowtraveler)) {
        $errors[] = "Looking for field cannot be empty.";
    }
    if (empty($aboutme)) {
        $errors[] = "About me field cannot be empty.";
    }

    if (empty($errors)) {
        try {
            $tourModel->createTour($destination, $tourdate, $tourdateEnd, $tourtype, $fellowtraveler, $aboutme, $currentUser);
            $redirectUrl = getUrl('spolucesty?message=success');
            header("Location: " . $redirectUrl);
            exit;
        } catch (Exception $e) {
            $errors[] = "An error occurred while creating the tour: " . $e->getMessage();
        }
    }

    // If there are errors, store them in the session and redirect back to the form
    if (!empty($errors)) {

        $_SESSION['errors'] = $errors;
        $redirectUrl = getUrl('spolucesty?message=error');
        header("Location: " . $redirectUrl);
        exit;
    }
}