<?php
   
   $baseUri = '/';
/* return [
    $baseUri.''=> 'controllers/index.php',
    $baseUri.'traveltips' => 'controllers/traveltips.php',
    $baseUri.'traveltips/:country' => 'controllers/traveltips.php',
    $baseUri.'traveltips/:country/message' => 'controllers/traveltipsMessage.php',
    $baseUri.'traveltips/:country/messages/createmessage' => 'controllers/messages/create.php',
    $baseUri.'spolucesty' => 'controllers/spolucesty.php',
    $baseUri.'signup' => 'controllers/signup.php',
    $baseUri.'login' => 'controllers/login.php'
];
 */

   $router->get($baseUri.'', 'controllers/index.php');
      
   $router->get($baseUri.'signup', 'controllers/auth/register.php')->only('guest');
   $router->post($baseUri.'signup', 'controllers/auth/store.php')->only('guest');

   $router->get($baseUri.'googleregister', 'controllers/auth/signupgoogle.php');
   $router->get($baseUri.'googlelogin', 'controllers/auth/signingoogle.php');
    
   $router->get($baseUri.'login', 'controllers/auth/login.php')->only('guest');
   $router->post($baseUri.'login', 'controllers/auth/session.php')->only('guest');
   
  $router->patch($baseUri.'updateprofile', 'controllers/auth/updateprofile.php')->only('auth');
   $router->patch($baseUri.'updatepassword', 'controllers/auth/updatepassword.php')->only('auth');

   $router->get($baseUri.'forgottenpassword', 'controllers/auth/forgottenpassword.php')->only('guest');
   $router->post($baseUri.'sendpasswordreset', 'controllers/auth/sendPasswordReset.php')->only('guest');
   $router->get($baseUri.'resetpassword', 'controllers/auth/resetPassword.php')->only('guest');

   $router->patch($baseUri.'updatepasswordreset', 'controllers/auth/updadatePasswordReset.php')->only('guest');

   

   $router->post($baseUri.'upload', 'controllers/auth/upload.php')->only('auth');

   $router->get($baseUri.'logout', 'controllers/auth/logout.php')->only('auth');
   $router->get($baseUri.'logoutgoogle', 'controllers/auth/logoutgoogle.php')->only('guest');


   $router->get($baseUri.'profile', 'controllers/auth/profile.php')->only('auth');

   $router->get($baseUri.'traveltips', 'controllers/traveltips.php');
   
   $router->get($baseUri.'traveltips/:country', 'controllers/traveltips.php');
   $router->get($baseUri.'traveltips/:country/message', 'controllers/traveltipsMessage.php')->only('auth');;
   
   $router->delete($baseUri.'traveltips/:country/destroymessage', 'controllers/messages/destroy.php')->only('auth');

   $router->post($baseUri.'traveltips/:country/createmessage',  'controllers/messages/create.php')->only('auth');
   $router->get($baseUri.'traveltips/:country/editmessage',  'controllers/messages/edit.php')->only('auth');
   $router->patch($baseUri.'traveltips/:country/updatemessage',  'controllers/messages/update.php')->only('auth');
    

   $router->get($baseUri.'spolucesty', 'controllers/spolucesty.php')->only('guest');

 /*   echo '<pre>';
 dd($router);
   echo '</pre>';

 */



   



  

