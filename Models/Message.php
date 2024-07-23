<?php

namespace Models;

use Core\Database;

class Message
{
    protected $db;
    protected $table = 'message'; // Adjust if your table name is different

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getMessagesWithRepliesByCountry($country)
    {
        $query = "
            SELECT 
                message.id AS message_id,
                message.date AS message_date,
                message.message AS message_content,
             
                user.id AS user_id,
                user.firstName AS user_firstName,
                user.email AS user_email,   
                user.image AS user_image,
                
                reply.id AS reply_id,
                reply.date AS reply_date,
                reply.message AS reply_content,
                reply.message_id as reply_message_id,
                reply_user.id AS reply_user_id,
                reply_user.firstName AS reply_user_firstName,
                reply_user.image AS reply_user_image,

                votes.id AS vote_id,
                votes.vote_type AS vote_type,
                votes.user_id AS vote_user_id,
                votes.message_id AS vote_message_id,

                votesreply.id AS votesreply_id,
                votesreply.reply_id AS vote_reply_id,
                votesreply.vote_type AS vote_reply_type,
                votesreply.user_id AS vote_reply_user_id,
                votesreply.message_id AS vote_reply_message_id,

                COUNT(DISTINCT CASE WHEN votes.vote_type = 'thumb_up' THEN votes.id END) AS thumbs_up_count,
                COUNT(DISTINCT CASE WHEN votes.vote_type = 'thumb_down' THEN votes.id END) AS thumbs_down_count,
              
                COUNT(DISTINCT CASE WHEN votesreply.vote_type = 'thumb_up' THEN votesreply.id END) AS reply_thumbs_up_count,
                COUNT(DISTINCT CASE WHEN votesreply.vote_type = 'thumb_down' THEN votesreply.id END) AS reply_thumbs_down_count
            FROM 
                {$this->table} 
            JOIN 
                user ON {$this->table}.user_id = user.id 
            LEFT JOIN 
                reply ON reply.message_id = {$this->table}.id
            LEFT JOIN 
                user AS reply_user ON reply.user_id = reply_user.id
            LEFT JOIN 
                votes ON votes.message_id = {$this->table}.id
            LEFT JOIN 
                votesreply ON votesreply.message_id = {$this->table}.id
            WHERE 
                {$this->table}.country = :country
            GROUP BY 
                   message.id, user.id,reply.id
            ORDER BY 
                {$this->table}.date DESC , reply.date DESC
        ";
    
        return $this->db->query($query, [':country' => $country])->findAll();
    }
    

    public function createMessage($message, $userId, $country)
    {
        $query = "INSERT INTO {$this->table} (message, user_id, country) VALUES (:message, :user_id, :country)";
        $this->db->query($query, [
            ':message' => $message,
            ':user_id' => $userId,
            ':country' => $country
        ]);
    }

    public function getMessageByIdAndCountry($id, $country)
    {
        $query = "
            SELECT 
                message.id AS message_id,
                message.*,
                user.id AS user_id,
                user.firstName,        
                user.email    
            FROM 
                {$this->table}     
            JOIN 
                user ON message.user_id = user.id 
            WHERE 
                message.id = :id 
                AND 
                message.country = :country
        ";
        return $this->db->query($query, [':id' => $id, ':country' => $country])->findOrFail();
    }

    public function deleteMessage($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $this->db->query($query, [':id' => $id]);
    }
}
