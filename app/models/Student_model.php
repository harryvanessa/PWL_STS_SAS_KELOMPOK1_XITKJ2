<?php

class Student_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getStudentProfile($user_id)
    {
        $this->db->query("SELECT * FROM student_profiles WHERE user_id = :user_id");
        $this->db->bind('user_id', $user_id);
        return $this->db->single();
    }

    public function updateInterest($user_id, $interest)
    {
        $this->db->query("UPDATE student_profiles SET interest = :interest WHERE user_id = :user_id");
        $this->db->bind('interest', $interest);
        $this->db->bind('user_id', $user_id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function gachaMentor($skill_id)
    {
        // Get random mentor with specific skill and approved status
        $query = "SELECT m.id as mentor_profile_id, m.user_id, m.full_name, m.experience, u.username
                  FROM mentor_profiles m
                  JOIN users u ON m.user_id = u.id
                  WHERE m.skill_id = :skill_id AND m.status = 'approved'
                  ORDER BY RAND() LIMIT 1";
        
        $this->db->query($query);
        $this->db->bind('skill_id', $skill_id);
        return $this->db->single();
    }

    public function requestSession($data)
    {
        $query = "INSERT INTO sessions (student_id, mentor_id, skill_id, session_date, status, notes) 
                  VALUES (:student_id, :mentor_id, :skill_id, :session_date, 'pending', :notes)";
        
        $this->db->query($query);
        $this->db->bind('student_id', $data['student_id']);
        $this->db->bind('mentor_id', $data['mentor_id']);
        $this->db->bind('skill_id', $data['skill_id']);
        $this->db->bind('session_date', $data['session_date']);
        $this->db->bind('notes', $data['notes']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getStudentSessions($student_id)
    {
        $query = "SELECT s.*, m.full_name as mentor_name, sk.name as skill_name 
                  FROM sessions s
                  JOIN users u_mentor ON s.mentor_id = u_mentor.id
                  JOIN mentor_profiles m ON u_mentor.id = m.user_id
                  JOIN skills sk ON s.skill_id = sk.id
                  WHERE s.student_id = :student_id
                  ORDER BY s.session_date DESC";
        $this->db->query($query);
        $this->db->bind('student_id', $student_id);
        return $this->db->resultSet();
    }
}
