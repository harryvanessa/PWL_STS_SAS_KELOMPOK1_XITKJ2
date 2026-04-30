<?php

class Student_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getStudentProfile($user_id)
    {
        return $this->db->run(
            "SELECT * FROM student_profiles WHERE user_id = :user_id",
            ['user_id' => $user_id]
        )->single();
    }

    public function updateInterest($user_id, $interest)
    {
        return $this->db->run(
            "UPDATE student_profiles SET interest = :interest WHERE user_id = :user_id",
            ['interest' => $interest, 'user_id' => $user_id]
        )->rowCount();
    }

    public function gachaMentor($skill_id)
    {
        return $this->db->run(
            "SELECT m.id AS mentor_profile_id, m.user_id, m.full_name, m.experience, u.username
             FROM mentor_profiles m
             JOIN users u ON m.user_id = u.id
             WHERE m.skill_id = :skill_id AND m.status = 'approved'
             ORDER BY RAND() LIMIT 1",
            ['skill_id' => $skill_id]
        )->single();
    }

    public function requestSession($data)
    {
        return $this->db->run(
            "INSERT INTO sessions (student_id, mentor_id, skill_id, session_date, status, notes)
             VALUES (:student_id, :mentor_id, :skill_id, :session_date, 'pending', :notes)",
            ['student_id'   => $data['student_id'],  'mentor_id'    => $data['mentor_id'],
             'skill_id'     => $data['skill_id'],     'session_date' => $data['session_date'],
             'notes'        => $data['notes']]
        )->rowCount();
    }

    public function getStudentSessions($student_id)
    {
        return $this->db->run(
            "SELECT s.*, m.full_name AS mentor_name, sk.name AS skill_name
             FROM sessions s
             JOIN mentor_profiles m ON s.mentor_id = m.user_id
             JOIN skills sk         ON s.skill_id  = sk.id
             WHERE s.student_id = :student_id
             ORDER BY s.session_date DESC",
            ['student_id' => $student_id]
        )->resultSet();
    }

    public function getMentorById($user_id, $skill_id)
    {
        return $this->db->run(
            "SELECT m.id AS mentor_profile_id, m.user_id, m.full_name, m.experience, u.username
             FROM mentor_profiles m
             JOIN users u ON m.user_id = u.id
             WHERE m.user_id = :user_id AND m.skill_id = :skill_id AND m.status = 'approved'",
            ['user_id' => $user_id, 'skill_id' => $skill_id]
        )->single();
    }

    public function getMentorComments($mentor_user_id)
    {
        return $this->db->run(
            "SELECT c.*, sp.full_name, u.username
             FROM mentor_comments c
             JOIN users u ON c.student_user_id = u.id
             JOIN student_profiles sp ON u.id = sp.user_id
             WHERE c.mentor_user_id = :mentor_user_id
             ORDER BY c.created_at DESC",
            ['mentor_user_id' => $mentor_user_id]
        )->resultSet();
    }

    public function addMentorComment($data)
    {
        return $this->db->run(
            "INSERT INTO mentor_comments (mentor_user_id, student_user_id, comment)
             VALUES (:mentor_user_id, :student_user_id, :comment)",
            [
                'mentor_user_id'  => $data['mentor_user_id'],
                'student_user_id' => $data['student_user_id'],
                'comment'         => $data['comment']
            ]
        )->rowCount();
    }
}
