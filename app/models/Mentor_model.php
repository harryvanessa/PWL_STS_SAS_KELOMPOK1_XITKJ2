<?php

class Mentor_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMentorProfile($user_id)
    {
        $query = "SELECT m.*, s.name as skill_name 
                  FROM mentor_profiles m
                  JOIN skills s ON m.skill_id = s.id
                  WHERE m.user_id = :user_id";
        $this->db->query($query);
        $this->db->bind('user_id', $user_id);
        return $this->db->single();
    }

    public function getSessionRequests($user_id)
    {
        // First get mentor_id from users table
        $query = "SELECT s.*, u_student.username as student_username, sp.full_name as student_name, sk.name as skill_name
                  FROM sessions s
                  JOIN users u_mentor ON s.mentor_id = u_mentor.id
                  JOIN users u_student ON s.student_id = u_student.id
                  JOIN student_profiles sp ON u_student.id = sp.user_id
                  JOIN skills sk ON s.skill_id = sk.id
                  WHERE s.mentor_id = :user_id
                  ORDER BY s.session_date ASC";
        
        $this->db->query($query);
        $this->db->bind('user_id', $user_id);
        return $this->db->resultSet();
    }

    public function updateSessionStatus($session_id, $status)
    {
        $this->db->query("UPDATE sessions SET status = :status WHERE id = :session_id");
        $this->db->bind('status', $status);
        $this->db->bind('session_id', $session_id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function confirmSessionWithLink($session_id, $meeting_link)
    {
        $this->db->query("UPDATE sessions SET status = 'confirmed', meeting_link = :meeting_link WHERE id = :session_id");
        $this->db->bind('meeting_link', $meeting_link);
        $this->db->bind('session_id', $session_id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
