<?php

   require_once './constants/constants.php';
   use Core\App;
   use Core\Database;
   use Models\Message;


   $db = App::resolve(Database::class);
   
   $heading = 'traveltips';
   $emptyParam = false; 

   $messageModel = new Message($db);

 

   if (isset($_GET['param1'])) {
    $countryParam = urldecode($_GET['param1']);

    // Use the Message model method to fetch messages with replies
    $result = $messageModel->getMessagesWithRepliesByCountry($countryParam);

    $messages = [];

    foreach ($result as $row) {
        $message_id = $row['message_id'];

        if (!isset($messages[$message_id])) {
            $messages[$message_id] = [
                'id' => $message_id,
                'date' => $row['message_date'],
                'message' => $row['message_content'],
                'user_id' => $row['user_id'],
                'user_firstName' => $row['user_firstName'],
                'user_email' => $row['user_email'],
                'user_image' => $row['user_image'],
                'thumbs_up_count' => $row['thumbs_up_count'],
                'thumbs_down_count' => $row['thumbs_down_count'],
                'vote_user_id' => $row['vote_user_id'],
                'vote_message_id' => $row['vote_message_id'],
                'vote_type' => $row['vote_type'],
                'replies' => []
            ];
        }


        if ($row['reply_id']) {
            $messages[$message_id]['replies'][] = [
                'reply_id' => $row['reply_id'],
                'reply_date' => $row['reply_date'],
                'reply_content' => $row['reply_content'],
                'reply_message_id' => $row['reply_message_id'],
                'reply_user_id' => $row['reply_user_id'],
                'reply_user_firstName' => $row['reply_user_firstName'],
                'reply_user_image' => $row['reply_user_image'],
                'reply_thumbs_up_count' => $row['reply_thumbs_up_count'],
                'reply_thumbs_down_count' => $row['reply_thumbs_down_count'],
                'vote_reply_id' => $row['vote_reply_id'],
                'vote_reply_user_id' => $row['vote_reply_user_id'],
                'vote_reply_message_id' => $row['vote_reply_message_id'],
                'vote_reply_type' => $row['vote_reply_type'],
            ];
        }

        if ($row['vote_id']) {
            $messages[$message_id]['votes'][] = [
                'vote_id' => $row['vote_id'],
                'vote_user_id' => $row['vote_user_id']
   
            ];
        }


    }
} else {
    $emptyParam = true;
}


require "views/traveltips.view.php";

