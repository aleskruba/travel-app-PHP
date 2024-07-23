<?php
use Core\App;
use Core\Database;
use Models\Vote;

$db = App::resolve(Database::class);
$voteModel = new Vote($db);
$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';
$countryParam = urldecode($_GET['param1']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);


    if (json_last_error() === JSON_ERROR_NONE) {
     
        $response = [];

        foreach ($data['data'] as $key => $value) {
            $response[$key] = $value;
        }

        $message_id = isset($response['messageId']) ? $response['messageId'] : '';
        $vote_type = isset($response['voteType']) ? $response['voteType'] : '';

        $existingVote = $voteModel->findVoteByUserAndMessage($currentUser, $message_id);
        
        if ($existingVote) {
            // Update the existing vote
            $voteModel->updateVote($existingVote['id'], $vote_type);
        } else {
            // Create a new vote
            $voteModel->createVote($currentUser, $message_id, $vote_type);
        }

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'data' => $response]);
    } else {
        // Handle the JSON decode error
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Error decoding JSON: ' . json_last_error_msg()]);
    }
}


