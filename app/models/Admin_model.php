<?php

class Admin_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // ── Pending & Approved Mentors ───────────────────────────────
    public function getPendingMentors()
    {
        return $this->db->run(
            "SELECT m.id, m.full_name, m.experience, s.name AS skill_name, u.username
             FROM mentor_profiles m
             JOIN skills s ON m.skill_id = s.id
             JOIN users  u ON m.user_id  = u.id
             WHERE m.status = 'pending'
             ORDER BY m.id DESC"
        )->resultSet();
    }

    public function getApprovedMentors()
    {
        return $this->db->run(
            "SELECT m.id, m.full_name, m.experience, m.skill_id, s.name AS skill_name, u.username, m.user_id
             FROM mentor_profiles m
             JOIN skills s ON m.skill_id = s.id
             JOIN users  u ON m.user_id  = u.id
             WHERE m.status = 'approved'
             ORDER BY m.full_name ASC"
        )->resultSet();
    }

    public function getMentorById($id)
    {
        return $this->db->run(
            "SELECT m.*, s.name AS skill_name, u.username
             FROM mentor_profiles m
             JOIN skills s ON m.skill_id = s.id
             JOIN users  u ON m.user_id  = u.id
             WHERE m.id = :id",
            ['id' => $id]
        )->single();
    }

    // ── Approve / Reject / Dismiss ───────────────────────────────
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

    public function dismissMentor($id)
    {
        return $this->db->run(
            "UPDATE mentor_profiles SET status = 'rejected', feedback = 'Diberhentikan oleh Admin' WHERE id = :id",
            ['id' => $id]
        )->rowCount();
    }

    // ── Update Jurusan/Skill Mentor ──────────────────────────────
    public function updateMentorSkill($id, $skill_id)
    {
        return $this->db->run(
            "UPDATE mentor_profiles SET skill_id = :skill_id WHERE id = :id",
            ['skill_id' => $skill_id, 'id' => $id]
        )->rowCount();
    }

    // ── Skill CRUD ───────────────────────────────────────────────
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

    // ── Mentor Comments (Admin bisa lihat semua + role) ──────────
    public function getMentorComments($mentor_user_id)
    {
        return $this->db->run(
            "SELECT c.*,
                    COALESCE(sp.full_name, 'Admin') AS full_name,
                    u.username,
                    u.role
             FROM mentor_comments c
             JOIN users u ON c.student_user_id = u.id
             LEFT JOIN student_profiles sp ON u.id = sp.user_id
             WHERE c.mentor_user_id = :mentor_user_id
             ORDER BY c.created_at DESC",
            ['mentor_user_id' => $mentor_user_id]
        )->resultSet();
    }

    public function addMentorComment($mentor_user_id, $commenter_user_id, $comment)
    {
        return $this->db->run(
            "INSERT INTO mentor_comments (mentor_user_id, student_user_id, comment)
             VALUES (:mentor_user_id, :student_user_id, :comment)",
            [
                'mentor_user_id'  => $mentor_user_id,
                'student_user_id' => $commenter_user_id,
                'comment'         => $comment,
            ]
        )->rowCount();
    }

    public function updateMentorComment($comment_id, $comment)
    {
        return $this->db->run(
            "UPDATE mentor_comments SET comment = :comment WHERE id = :id",
            ['comment' => $comment, 'id' => $comment_id]
        )->rowCount();
    }

    public function deleteMentorComment($comment_id)
    {
        return $this->db->run(
            "DELETE FROM mentor_comments WHERE id = :id",
            ['id' => $comment_id]
        )->rowCount();
    }

    // ── Student Management ───────────────────────────────────────
    public function getAllStudents()
    {
        return $this->db->run(
            "SELECT sp.*, u.username, u.created_at AS joined_at
             FROM student_profiles sp
             JOIN users u ON sp.user_id = u.id
             ORDER BY sp.full_name ASC"
        )->resultSet();
    }

    public function getStudentById($user_id)
    {
        return $this->db->run(
            "SELECT sp.*, u.username, u.created_at AS joined_at
             FROM student_profiles sp
             JOIN users u ON sp.user_id = u.id
             WHERE sp.user_id = :user_id",
            ['user_id' => $user_id]
        )->single();
    }

    // Komentar yang DITULIS oleh siswa ini (ke berbagai mentor)
    public function getCommentsByStudent($student_user_id)
    {
        return $this->db->run(
            "SELECT c.*,
                    mp.full_name AS mentor_name,
                    um.username  AS mentor_username,
                    s.name       AS skill_name
             FROM mentor_comments c
             JOIN users um ON c.mentor_user_id = um.id
             JOIN mentor_profiles mp ON mp.user_id = um.id AND mp.status = 'approved'
             JOIN skills s ON mp.skill_id = s.id
             WHERE c.student_user_id = :student_user_id
             ORDER BY c.created_at DESC",
            ['student_user_id' => $student_user_id]
        )->resultSet();
    }

    // Sesi/bimbingan siswa
    public function getStudentSessions($student_user_id)
    {
        return $this->db->run(
            "SELECT s.*, m.full_name AS mentor_name, sk.name AS skill_name
             FROM sessions s
             JOIN mentor_profiles m ON s.mentor_id = m.user_id
             JOIN skills sk ON s.skill_id = sk.id
             WHERE s.student_id = :student_id
             ORDER BY s.session_date DESC",
            ['student_id' => $student_user_id]
        )->resultSet();
    }

    // Admin mencarikan mentor untuk siswa (buat sesi)
    public function assignMentorToStudent($student_id, $mentor_id, $skill_id, $session_date, $notes)
    {
        return $this->db->run(
            "INSERT INTO sessions (student_id, mentor_id, skill_id, session_date, status, notes)
             VALUES (:student_id, :mentor_id, :skill_id, :session_date, 'confirmed', :notes)",
            [
                'student_id'   => $student_id,
                'mentor_id'    => $mentor_id,
                'skill_id'     => $skill_id,
                'session_date' => $session_date,
                'notes'        => $notes,
            ]
        )->rowCount();
    }

    // Hapus akun siswa (beserta data terkait via foreign key cascade)
    public function deleteStudent($user_id)
    {
        return $this->db->run(
            "DELETE FROM users WHERE id = :id AND role = 'student'",
            ['id' => $user_id]
        )->rowCount();
    }
}
