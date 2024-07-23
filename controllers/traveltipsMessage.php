
<?php
use Core\App;
use Core\Database;
 
$db = App::resolve(Database::class);
   
$messageId = isset($_GET['id']) ? $_GET['id'] : null;
$message = null;

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $query = "SELECT 
  message.id AS message_id,
    message.*,
    user.id AS user_id,
    user.firstName,        
    user.email    
    FROM message     
    JOIN user ON message.user_id = user.id 
    WHERE 
            message.id = :id 
            AND 
            message.country = :country";
$message = $db->query($query, [':id' => $messageId, ':country' => $_GET['param1']])->findOrFail();


authorize($message['user_id'] === $currentUser);

  $db->query("delete from message where id = :id ",[
 ':id' => $_POST['id'],
  ]); 
  $param1 = htmlspecialchars($_GET['param1'], ENT_QUOTES, 'UTF-8');
  $url = "/travel/traveltips/" . $param1 ;
  header("Location: " . $url);
  exit();

} else {



if ($messageId !== null && isset($_GET['param1'])) {
    $query = "SELECT 
          message.id AS message_id,
            message.*,
            user.id AS user_id,
            user.firstName,        
            user.email    
            FROM message     
            JOIN user ON message.user_id = user.id 
            WHERE 
                    message.id = :id 
                    AND 
                    message.country = :country";
    $message = $db->query($query, [':id' => $messageId, ':country' => $_GET['param1']])->findOrFail();
}


authorize($message['user_id'] === $currentUser);
}


require 'views/traveltips/traveltipsMessage.view.php';

