<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$data = json_decode(file_get_contents("php://input"), true);
$imageUrl = $data['data'];

$config = [
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'travedb',
    'charset' => 'utf8',
];

try {
    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
    $pdo = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $currentUserID =isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 


    if ($currentUserID) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->execute(['id' => $currentUserID]);
            $user = $stmt->fetch();
    
            if ($user) {
                $stmt = $pdo->prepare("UPDATE user SET image = :image WHERE id = :id");
                $stmt->execute(['image' => $imageUrl, 'id' => $currentUserID]);
              
            } 
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

        $response = [
            'status' => 'success',
            'message' => 'Data received',
            'user' => $currentUserID,
            'receivedData' => $data
        ];
    
        echo json_encode($response);


            $_SESSION['user']['image'] = $imageUrl;
        
      
        
 
        exit();




}


?>
