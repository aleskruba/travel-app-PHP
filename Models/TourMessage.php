<?php

namespace Models;

use Core\Database;

class TourMessage
{
    protected $db;
    protected $table = 'tourmessage'; 

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getTourMessagesWithRepliesById($id)
    {
        $query = "
            SELECT 
                tourmessage.id AS tourmessage_id,
                tourmessage.date AS tourmessage_date,
                tourmessage.message AS tourmessage_message,
                tourmessage.tour_id AS tourmessage_tour_id,
                user.id AS user_id,
                user.firstName AS user_firstName,
                user.email AS user_email,   
                user.image AS user_image,
                
                tourreply.id AS tourreply_id,
                tourreply.date AS tourreply_date,
                tourreply.message AS tourreply_message,
                tourreply.tourmessage_id AS tourreply_tourmessage_id,
                tourreply_user.id AS tourreply_user_id,
                tourreply_user.firstName AS tourreply_user_firstName,
                tourreply_user.image AS tourreply_user_image
            FROM 
                {$this->table} 
            JOIN 
                user ON {$this->table}.user_id = user.id 
            LEFT JOIN 
                tourreply ON tourreply.tourmessage_id = {$this->table}.id
            LEFT JOIN 
                user AS tourreply_user ON tourreply.user_id = tourreply_user.id
            WHERE 
                tourmessage.tour_id  = :id
            ORDER BY 
                      tourmessage.date DESC, tourreply.date DESC
        ";
    
        return $this->db->query($query, [':id' => $id])->findAll();
    }

    public function createTourMessage($message,$userId, $tourId)
    {
        $query = "
            INSERT INTO {$this->table} (message, user_id, tour_id)
            VALUES ( :message, :user_id, :tour_id)
        ";
    
        return $this->db->query($query, [
            ':message' => $message,
            ':user_id' => $userId,
            ':tour_id' => $tourId
        ]);
    }




    public function deleteTourMessage($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        return $this->db->query($query, [':id' => $id]);
    }

    public function createTourReply($message, $messageType, $userId, $tourMessageId)
    {
        $query = "
            INSERT INTO tourreply (date, message, messagetype, user_id, tourmessage_id)
            VALUES (NOW(), :message, :messagetype, :user_id, :tourmessage_id)
        ";
    
        return $this->db->query($query, [
            ':message' => $message,
            ':messagetype' => $messageType,
            ':user_id' => $userId,
            ':tourmessage_id' => $tourMessageId
        ]);
    }

    public function deleteTourReply($id)
    {
        $query = "DELETE FROM tourreply WHERE id = :id";
        return $this->db->query($query, [':id' => $id]);
    }



    public function getMessageById($id)
    {
        $query = "
            SELECT 
                tourmessage.id AS tourmessage_id,
                tourmessage.message AS tourmessage_message,
                user.id AS user_id,
                user.firstName,        
                user.email    
            FROM 
                {$this->table}     
            JOIN 
                user ON tourmessage.user_id = user.id 
            WHERE 
                tourmessage.id = :id 
   
        ";
        return $this->db->query($query, [':id' => $id])->findOrFail();
    }
}


