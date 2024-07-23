<?php
    use Core\App;
    use Core\Database;
    use Models\Tour;
    use Models\TourMessage;

    $db = App::resolve(Database::class);

    $tourModel = new Tour($db);
    $tourMessageModel = new TourMessage($db);
       
    $tourId = isset($_GET['param1']) ? $_GET['param1'] : null;

    $currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 

     $tour = $tourId ? $tourModel->getTour($tourId) : null; 

    $result = $tourMessageModel->getTourMessagesWithRepliesById($tourId);


    $tourmessages = [];

    foreach ($result as $row) {
        $messageId = $row['tourmessage_id'];
    
        if (!isset($tourmessages[$messageId])) {
            $tourmessages[$messageId] = [
                'message_id' => $messageId,
                'message_date' => $row['tourmessage_date'],
                'message_text' => $row['tourmessage_message'],
                'message_tour_id' => $row['tourmessage_tour_id'],
                'user_id' => $row['user_id'],
                'user_firstName' => $row['user_firstName'],
                'user_email' => $row['user_email'],
                'user_image' => $row['user_image'],
                'replies' => []
            ];
        }
    
        if (!empty($row['tourreply_id'])) {
            $tourmessages[$messageId]['replies'][] = [
                'reply_id' => $row['tourreply_id'],
                'reply_date' => $row['tourreply_date'],
                'reply_message' => $row['tourreply_message'],
                'reply_user_id' => $row['tourreply_user_id'],
                'reply_user_firstName' => $row['tourreply_user_firstName'],
                'reply_user_image' => $row['tourreply_user_image']
            ];
        }
    }
    
require 'views/spolucesty/spolucestyDetail.view.php';