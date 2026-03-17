<?php

class Mentor_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMentorProfile($user_id)
    {
        return $this->db->run(
            "SELECT m.*, s.name AS skill_name
             FROM mentor_profiles m
             JOIN skills s ON m.skill_id = s.id
             WHERE m.user_id = :user_id",
            ['user_id' => $user_id]
        )->single();
    }

    public function getSessionRequests($user_id)
    {
        return $this->db->run(
            "SELECT s.*, u_student.username AS student_username,
                    sp.full_name AS student_name, sk.name AS skill_name
             FROM sessions s
             JOIN users u_student          ON s.student_id = u_student.id
             JOIN student_profiles sp      ON u_student.id  = sp.user_id
             JOIN skills sk                ON s.skill_id    = sk.id
             WHERE s.mentor_id = :user_id
             ORDER BY s.session_date ASC",
            ['user_id' => $user_id]
        )->resultSet();
    }

    public function updateSessionStatus($session_id, $status)
    {
        return $this->db->run(
            "UPDATE sessions SET status = :status WHERE id = :session_id",
            ['status' => $status, 'session_id' => $session_id]
        )->rowCount();
    }

    public function confirmSessionWithLink($session_id, $meeting_link)
    {
        return $this->db->run(
            "UPDATE sessions SET status = 'confirmed', meeting_link = :meeting_link WHERE id = :session_id",
            ['meeting_link' => $meeting_link, 'session_id' => $session_id]
        )->rowCount();
    }
}
