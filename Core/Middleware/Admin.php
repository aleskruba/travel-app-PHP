<?php
    

namespace Core\Middleware;

class Admin {
    public function handle() {
        // Check if the user is logged in and has the admin email
        if (!isset($_SESSION['user']) || $_SESSION['user']['email'] !== 'admin@admin.com') {
            header('location: /travel/');
            exit();
        }
    }
}
