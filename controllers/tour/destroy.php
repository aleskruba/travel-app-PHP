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

     
        if ($tour['tour_id'] === intval($tourId)) {
         
            $tourModel->deleteTour($tourId);

            $url = getUrl('tvojespolucesty');
            header("Location: " . $url);
            exit();
        } else {
            echo "Unauthorized action";
        }
    } else {
        echo "Invalid message ID";
    }
} else {
    echo "Some error occurred";
}
