<?php
use Core\App;
use Core\Database;
use Models\Reply;

$db = App::resolve(Database::class);
$replyModel = new Reply($db);

$replyId = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : null;

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($replyId) {
        $countryParam = isset($_GET['param1']) ? urldecode($_GET['param1']) : null;

        $reply = $replyModel->getReplybyId($replyId);

        if ($reply['user_id'] === $currentUser) {
            
            $replyModel->deleteReply($replyId);

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
