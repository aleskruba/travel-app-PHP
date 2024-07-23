<?php
   use Core\App;
    use Core\Validator;
    use Core\Database;
    
    $db = App::resolve(Database::class);
    
   // $baseUri = '/travel/';
    
    $heading = "Update Message";
    
    $currentUser=isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 
    $countryParam = urldecode($_GET['param1']);


    if (isset($_POST['id'])) {
      
        $query = "SELECT * from  message where id = :id ";
            
       $message =  $db->query($query, [
           ':id' => $_POST['id']
        ])->findOrFail();
    
        authorize($message['user_id']=== $currentUser);
  
      
            $errors = [];
    
            if (Validator::min($_POST['message'],2)) {
                $errors['message'] = ' Zpráva musí obsahovat text';
            }
        
            if (Validator::max($_POST['message'],10)) {
                $errors['message'] = ' Zpráva musí obsahovat max 400 znaků';
            }
    
            if (empty($errors)) {
      
                $query = "UPDATE message SET message = :message WHERE id = :id";
                    
                $message =  $db->query($query, [
                    ':message' => $_POST['message'],
                    ':id' => $_POST['id']
                ]); 
            
                
            } else {


    
                $_SESSION['errors'] = $errors;
                $_SESSION['message'] = trim($_POST['message']); 
            
            
          //    $redirectUrl = $baseUri . 'traveltips/' . urlencode($countryParam) . "/editmessage?id=" . urlencode($_POST['id']);
             //  $redirectUrl = getUrl('traveltips/' . urlencode($countryParam). '/editmessage?id=' . urlencode($_POST['id']));
         
             $redirectUrl = getUrl('traveltips/' . urlencode($countryParam).'/editmessage?id='. urlencode($_POST['id']));
             header("Location: " . $redirectUrl);
                exit;
            }
    
 
        
        // $redirectUrl = $baseUri . 'traveltips/' . urlencode($countryParam) . "/message?id=" . urlencode($_POST['id']);
        $redirectUrl = getUrl('traveltips/' . urlencode($countryParam).'/message?id='. urlencode($_POST['id']));
        header("Location: " . $redirectUrl);
        exit;
            


    }
    