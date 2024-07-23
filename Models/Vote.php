<?php
namespace Models;

use Core\Database;

class Vote
{
    protected $db;
    protected $table = 'votes'; // Adjust if your table name is different

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createVote($userId, $message_id, $vote_type)
    {
        $query = "INSERT INTO {$this->table} (user_id, message_id, vote_type) VALUES (:user_id, :message_id, :vote_type)";
        $this->db->query($query, [
            ':user_id' => $userId,
            ':message_id' => $message_id,
            ':vote_type' => $vote_type,
        ]);
    }

    public function findVoteByUserAndMessage($userId, $message_id)
    {  
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id AND message_id = :message_id";


        return $this->db->query($query, [
            ':user_id' => $userId,
            ':message_id' => $message_id,
        ])->find();
    }

    public function updateVote($vote_id, $vote_type)
    {
        $query = "UPDATE {$this->table} SET vote_type = :vote_type WHERE id = :vote_id";
        $this->db->query($query, [
            ':vote_type' => $vote_type,
            ':vote_id' => $vote_id,
        ]);
    }
}
