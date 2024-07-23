<?php
use Core\App;
use Core\Database;
use Intervention\Image\ImageManagerStatic as Image;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = App::resolve(Database::class);

$currentUserID = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';
$imageErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imageInput']) && $_FILES['imageInput']['error'] === UPLOAD_ERR_OK) {
        // Check if the file type is acceptable
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($_FILES['imageInput']['type'], $allowedTypes)) {
            $response = ['status' => 'error', 'message' => 'Only JPEG, JPG, and PNG image formats are allowed'];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
        
        $file = $_FILES['imageInput']['tmp_name'];

        $image = Image::make($file)->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $tempFilePath = sys_get_temp_dir() . '/' . uniqid() . '.jpg';
        $image->save($tempFilePath);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.cloudinary.com/v1_1/dzxwsgl1r/image/upload');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'upload_preset' => 'schoolapp',
            'file' => new CURLFile($tempFilePath)
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        $responseData = json_decode($response, true);
        if (isset($responseData['secure_url'])) {
            $uploadedImageUrl = $responseData['secure_url'];

            // Update the user's profile image in the database
            $user = $db->query("SELECT * FROM user WHERE id = :id", ['id' => $currentUserID])->find();
            if ($user) {
                $query = "UPDATE user SET image = :image WHERE id = :id";
                $db->query($query, [':image' => $uploadedImageUrl, ':id' => $currentUserID]);
                $_SESSION['user']['image'] = $uploadedImageUrl;
                $response = ['status' => 'success', 'message' => 'Image uploaded successfully', 'imageUrl' => $uploadedImageUrl];
            } else {
                $response = ['status' => 'error', 'message' => 'User not found'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to upload image to Cloudinary'];
        }

        // Delete the temporary file
        unlink($tempFilePath);
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to receive file'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
