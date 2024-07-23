<?php
use Core\App;
use Core\Database;
use Models\Tour;

$db = App::resolve(Database::class);



$tourModel = new Tour($db);


$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 
$tourId = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : null;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tourId) {

        $tour = $tourModel->getTourById($tourId);

     
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
        if ($tourdate>$tourdateEnd) {
            $errors[] = "začátek cesty nemůže být později jak konec cesty";
        }
    
        if (empty($errors)) {
            try {
        /*         print_r($tourtype);
                echo $destination.$tourdate.$tourdateEnd.$fellowtraveler.$aboutme; */
                 $tourModel->updateTourById($destination, $tourdate, $tourdateEnd, $tourtype, $fellowtraveler, $aboutme, $currentUser,$tourId);
      
                 $redirectUrl = getUrl('tvojespolucesty?update=success');
                header("Location: " . $redirectUrl); 
                exit;
            } catch (Exception $e) {
                $errors[] = "An error occurred while creating the tour: " . $e->getMessage();
            }
        }
        if (!empty($errors)) {
             $_SESSION['errors'] = $errors;
             $redirectUrl = getUrl('tvojespolucesty?update=error');
            header("Location: " . $redirectUrl);
            exit;
        }
    
    } else {
        echo "Invalid message ID";
    }
} else {
    echo "Some error occurred";
}
