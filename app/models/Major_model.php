<?php

class Major_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function saveMajorSelection($user_id, $major, $app)
    {
        try {
            return $this->db->run(
                "INSERT INTO major_selections (user_id, major, app) 
                 VALUES (:user_id, :major, :app)",
                ['user_id' => $user_id, 'major' => $major, 'app' => $app]
            )->rowCount();
        } catch (PDOException) {
            return -1;
        }
    }

    public function getMajorSelectionByUserId($user_id)
    {
        return $this->db->run(
            "SELECT * FROM major_selections WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1",
            ['user_id' => $user_id]
        )->single();
    }

    public function getAllMajorSelections()
    {
        return $this->db->run(
            "SELECT ms.*, u.username, sp.full_name 
             FROM major_selections ms
             JOIN users u ON ms.user_id = u.id
             LEFT JOIN student_profiles sp ON u.id = sp.user_id
             ORDER BY ms.created_at DESC"
        )->results();
    }

    public function getMajorSelectionsByMajor($major)
    {
        return $this->db->run(
            "SELECT ms.*, u.username, sp.full_name 
             FROM major_selections ms
             JOIN users u ON ms.user_id = u.id
             LEFT JOIN student_profiles sp ON u.id = sp.user_id
             WHERE ms.major = :major
             ORDER BY ms.created_at DESC",
            ['major' => $major]
        )->results();
    }

    public function getMajorSelectionStats()
    {
        return $this->db->run(
            "SELECT major, COUNT(*) as total FROM major_selections GROUP BY major ORDER BY total DESC"
        )->results();
    }
}
