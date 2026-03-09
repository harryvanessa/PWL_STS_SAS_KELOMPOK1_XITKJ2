<?php

class Admin_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPendingMentors()
    {
        $query = "SELECT m.id, m.full_name, m.experience, s.name as skill_name, u.username as username
                  FROM mentor_profiles m 
                  JOIN skills s ON m.skill_id = s.id 
                  JOIN users u ON m.user_id = u.id
                  WHERE m.status = 'pending'";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function approveMentor($id)
    {
        $this->db->query("UPDATE mentor_profiles SET status = 'approved' WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function rejectMentor($id, $feedback)
    {
        // Now instead of deleting, we change status to 'rejected' and save the feedback.
        $this->db->query("UPDATE mentor_profiles SET status = 'rejected', feedback = :feedback WHERE id = :id");
        $this->db->bind('feedback', $feedback);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // Skills CRUD
    public function addSkill($data)
    {
        $this->db->query("INSERT INTO skills (name, description) VALUES (:name, :description)");
        $this->db->bind('name', $data['name']);
        $this->db->bind('description', $data['description']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteSkill($id)
    {
        $this->db->query("DELETE FROM skills WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
