<?php

class Chat_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMessagesBySession($session_id)
    {
        $query = "SELECT m.*, u.username, u.role 
                  FROM messages m
                  JOIN users u ON m.sender_id = u.id
                  WHERE m.session_id = :session_id
                  ORDER BY m.created_at ASC";
        $this->db->query($query);
        $this->db->bind('session_id', $session_id);
        return $this->db->resultSet();
    }

    public function sendMessage($data)
    {
        $query = "INSERT INTO messages (session_id, sender_id, recipient_id, message) 
                  VALUES (:session_id, :sender_id, :recipient_id, :message)";
        
        $this->db->query($query);
        $this->db->bind('session_id', $data['session_id']);
        $this->db->bind('sender_id', $data['sender_id']);
        $this->db->bind('recipient_id', $data['recipient_id']);
        $this->db->bind('message', $data['message']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getSessionDetails($session_id)
    {
        $query = "SELECT s.*, sk.name as skill_name, 
                         u_ment.username as mentor_username, u_stud.username as student_username
                  FROM sessions s
                  JOIN skills sk ON s.skill_id = sk.id
                  JOIN users u_ment ON s.mentor_id = u_ment.id
                  JOIN users u_stud ON s.student_id = u_stud.id
                  WHERE s.id = :session_id";
        $this->db->query($query);
        $this->db->bind('session_id', $session_id);
        return $this->db->single();
    }
}
