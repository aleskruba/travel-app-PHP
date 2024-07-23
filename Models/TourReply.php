<?php

namespace Models;

use Core\Database;

class TourReply {

    protected $db;
    protected $table = 'tourreply';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createTourReply($message, $userId, $message_id)
    {
        $query = "INSERT INTO {$this->table} (message, user_id, tourmessage_id) VALUES (:message, :user_id, :tourmessage_id)";
        $this->db->query($query, [
            ':message' => $message,
            ':user_id' => $userId,
            ':tourmessage_id' => $message_id
        ]);
    }

    public function getTourReplybyId($id)
    {
        $query = "
            SELECT * FROM {$this->table} WHERE tourreply.id = :id 
       ";
       
       return $this->db->query($query, [':id' => $id])->findOrFail();
    }

    public function deleteTourReply($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $this->db->query($query, [':id' => $id]);
    }
}