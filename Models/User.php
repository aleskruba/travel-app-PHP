<?php

// User.php

namespace Models;

use Core\Database;

class User
{
    protected $db;
    protected $table = 'user'; // Adjust if your table name is different
    public $id;
    public $username;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $registrationDate;
    public $image;
    public $googleId;
    public $googleEmail;
    public $googleName;
    public $googleProfilePicture;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function finduser($id) {
        $query = "SELECT * FROM user WHERE id = :id";
        $this->db->query($query, [':id' => $id]);
        $userData = $this->db->find();

        if ($userData) {
            foreach ($userData as $key => $value) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM {$this->table} WHERE email = :email";
        return $this->db->query($query, [':email' => $email])->find();
    }

    public function insert($email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO {$this->table} (email, password) VALUES (:email, :password)";
        return $this->db->query($query, [
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
    }


    public function updateProfile($id, $username, $firstName, $lastName, $email)
    {


        // Update the user's profile
        $query = "UPDATE {$this->table} SET username = :username, firstName = :firstName, lastName = :lastName, email = :email WHERE id = :id";
        $this->db->query($query, [
            ':username' => $username,
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':email' => $email,
            ':id' => $id
        ]);

        // Update session data
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['email'] = $email;

        return true;
    }


    public function changePassword($id, $password)
    {
        $query = "UPDATE {$this->table} SET password = :password WHERE id = :id";
        $this->db->query($query, [
            ':password' => password_hash($password, PASSWORD_BCRYPT),
            ':id' => $id
        ]);
    }

}
