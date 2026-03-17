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
        return $this->db->run(
            "INSERT INTO messages (session_id, sender_id, recipient_id, message)
             VALUES (:session_id, :sender_id, :recipient_id, :message)",
            ['session_id'   => $data['session_id'],  'sender_id'    => $data['sender_id'],
             'recipient_id' => $data['recipient_id'], 'message'      => $data['message']]
        )->rowCount();
    }

    public function getSessionDetails($session_id)
    {
        return $this->db->run(
            "SELECT s.*, sk.name AS skill_name,
                    u_ment.username AS mentor_username, u_stud.username AS student_username
             FROM sessions s
             JOIN skills sk         ON s.skill_id   = sk.id
             JOIN users  u_ment     ON s.mentor_id  = u_ment.id
             JOIN users  u_stud     ON s.student_id = u_stud.id
             WHERE s.id = :session_id",
            ['session_id' => $session_id]
        )->single();
    }
}
