<?php
use Core\App;
use Core\Database;
use Models\Message;

$db = App::resolve(Database::class);
$messageModel = new Message($db);

$messageId = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : null;
$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($messageId) {
        $countryParam = isset($_GET['param1']) ? urldecode($_GET['param1']) : null;

        $message = $messageModel->getMessageByIdAndCountry($messageId, $countryParam);

        if ($message['user_id'] === $currentUser) {
            $messageModel->deleteMessage($messageId);

            $param1 = htmlspecialchars($_GET['param1'], ENT_QUOTES, 'UTF-8');
            $url = getUrl('traveltips/' . $param1);
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
