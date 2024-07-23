<?php

use Core\App;
use Core\Database;
use Models\Vote;

$db = App::resolve(Database::class);

$voteModel = new Vote($db);

$heading = "Create Vote";

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

$countryParam = urldecode($_GET['param1']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_user_id = $_POST['message_user_id'];
    $message_id = $_POST['message_id'];
    $vote_type = $_POST['vote_type'];

    $votesErrors = [];

    if ($currentUser ===  (int)$message_user_id) {
        $votesErrors['voteserrors'] = 'Nelze hlasovat pro sám sebe';
    }


    if (empty($votesErrors)) {
        // Check if the user has already voted for this message
        $existingVote = $voteModel->findVoteByUserAndMessage($currentUser, $message_id);
        if ($existingVote) {
            // Update the existing vote
            $voteModel->updateVote($existingVote['id'], $vote_type);
        } else {
            // Create a new vote
            $voteModel->createVote($currentUser, $message_id, $vote_type);
        }

        unset($_SESSION['errors']);

        $redirectUrl = getUrl('traveltips/' . urlencode($countryParam));

        header("Location: " . $redirectUrl);
        exit;
    } else {
        $_SESSION['voteserrors'] = $errors;
        $redirectUrl = getUrl('traveltips/' . urlencode($countryParam) . '?vote=error');

        header("Location: " . $redirectUrl);
        exit;
    }
}

