<?php
use Core\App;
use Core\Database;
use Models\TourMessage;

$db = App::resolve(Database::class);
$messageModel = new TourMessage($db);

$messageId = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : null;
$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($messageId) {
        $countryParam = isset($_GET['param1']) ? urldecode($_GET['param1']) : null;

        $message = $messageModel->getMessageById($messageId, $countryParam);

        if ($message['user_id'] === $currentUser) {
            $messageModel->deleteTourMessage($messageId);

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
