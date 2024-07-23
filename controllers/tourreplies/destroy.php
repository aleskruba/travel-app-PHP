<?php
use Core\App;
use Core\Database;
use Models\TourReply;

$db = App::resolve(Database::class);
$tourReplyModel = new TourReply($db);

$tourReplyId = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : null;

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tourReplyId) {
        $countryParam = isset($_GET['param1']) ? urldecode($_GET['param1']) : null;

        $reply = $tourReplyModel->getTourReplybyId($tourReplyId);

        if ($reply['user_id'] === $currentUser) {
            
            $tourReplyModel->deleteTourReply($tourReplyId);

            $param1 = htmlspecialchars($_GET['param1'], ENT_QUOTES, 'UTF-8');
            $url = getUrl('spolucesty/' . $param1);
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
