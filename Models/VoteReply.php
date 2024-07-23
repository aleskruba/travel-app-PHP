<?php
namespace Models;

use Core\Database;

class VoteReply
{
    protected $db;
    protected $table = 'votesreply'; // Adjust if your table name is different

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function createVote($userId, $reply_id, $message_id, $vote_type)
    {
        $query = "INSERT INTO {$this->table} (user_id, reply_id, message_id,vote_type) VALUES (:user_id, :reply_id, :message_id, :vote_type)";
        $this->db->query($query, [
            ':user_id' => $userId,
            ':reply_id' => $reply_id,
            ':message_id' => $message_id,
            ':vote_type' => $vote_type,
        ]);
    }

    public function findVoteByUserAndMessage($userId, $reply_id)
    {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id AND reply_id = :reply_id";
        return $this->db->query($query, [
            ':user_id' => $userId,
            ':reply_id' => $reply_id,
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
