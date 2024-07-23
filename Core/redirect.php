<?php
require_once 'vendor/autoload.php';


$clientID = '85802491961-b7t13blg4rkgqbira2i00fni49cg8rmm.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = isset($_SESSION['authentication']) && $_SESSION['authentication'] === 'login' ? 'http://localhost/travel/googlelogin' : 'http://localhost/travel/googleregister';


// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        // get profile info
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        // start session and store user data
        session_start();
        $_SESSION['user'] = [
            'email' => $google_account_info->email,
            'givenName' => $google_account_info->givenName,
            'familyName' => $google_account_info->familyName,
            'picture' => $google_account_info->picture
        ];

        if (isset($_SESSION['authentication']) && $_SESSION['authentication'] === 'login') {
            $redirectUrl = getUrl('googlelogin'); }
            else {
            $redirectUrl = getUrl('googleregister');
            }
        header("Location: $redirectUrl");

        exit();
    } else {
        echo 'Failed to retrieve access token.';
    }
}
?>