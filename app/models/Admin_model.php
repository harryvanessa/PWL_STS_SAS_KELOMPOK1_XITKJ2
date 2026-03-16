<?php

class Admin_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPendingMentors()
    {
        return $this->db->run(
            "SELECT m.id, m.full_name, m.experience, s.name AS skill_name, u.username
             FROM mentor_profiles m
             JOIN skills s ON m.skill_id = s.id
             JOIN users  u ON m.user_id  = u.id
             WHERE m.status = 'pending'"
        )->resultSet();
    }

    public function approveMentor($id)
    {
        return $this->db->run(
            "UPDATE mentor_profiles SET status = 'approved' WHERE id = :id",
            ['id' => $id]
        )->rowCount();
    }

    public function rejectMentor($id, $feedback)
    {
        return $this->db->run(
            "UPDATE mentor_profiles SET status = 'rejected', feedback = :feedback WHERE id = :id",
            ['feedback' => $feedback, 'id' => $id]
        )->rowCount();
    }

    public function addSkill($data)
    {
        return $this->db->run(
            "INSERT INTO skills (name, description) VALUES (:name, :description)",
            ['name' => $data['name'], 'description' => $data['description']]
        )->rowCount();
    }

    public function deleteSkill($id)
    {
        return $this->db->run(
            "DELETE FROM skills WHERE id = :id",
            ['id' => $id]
        )->rowCount();
    }
}
