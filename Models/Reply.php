<?php

namespace Models;

use Core\Database;

class Reply {

    protected $db;
    protected $table = 'reply';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createReply($message, $userId, $message_id)
    {
        $query = "INSERT INTO {$this->table} (message, user_id, message_id) VALUES (:message, :user_id, :message_id)";
        $this->db->query($query, [
            ':message' => $message,
            ':user_id' => $userId,
            ':message_id' => $message_id
        ]);
    }

    public function getReplybyId($id)
    {
        $query = "
            SELECT 
                    *
             FROM {$this->table} 
             
             WHERE 
                  reply.id = :id
             
       ";
       
       return $this->db->query($query, [':id' => $id])->findOrFail();
    }

    public function deleteReply($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $this->db->query($query, [':id' => $id]);
    }
}