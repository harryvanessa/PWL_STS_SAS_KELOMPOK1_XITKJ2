<?php

class Admin_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // ─── Pending Mentors ────────────────────────────────────────
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

    // ─── Approved Mentors ───────────────────────────────────────
    public function getApprovedMentors()
    {
        return $this->db->run(
            "SELECT m.id, m.full_name, m.experience, s.name AS skill_name, u.username, m.user_id
             FROM mentor_profiles m
             JOIN skills s ON m.skill_id = s.id
             JOIN users  u ON m.user_id  = u.id
             WHERE m.status = 'approved'
             ORDER BY m.full_name ASC"
        )->resultSet();
    }

    // ─── Get Single Mentor (for profile page) ──────────────────
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

    // ─── Approve / Reject ───────────────────────────────────────
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

    // ─── Dismiss (berhentikan) Mentor ───────────────────────────
    public function deleteMentor($id)
    {
        return $this->db->run(
            "UPDATE mentor_profiles SET status = 'rejected', feedback = 'Diberhentikan oleh Admin' WHERE id = :id",
            ['id' => $id]
        )->rowCount();
    }

    // ─── Update Mentor Skill (Jurusan) ──────────────────────────
    public function updateMentorSkill($id, $skill_id)
    {
        return $this->db->run(
            "UPDATE mentor_profiles SET skill_id = :skill_id WHERE id = :id",
            ['skill_id' => $skill_id, 'id' => $id]
        )->rowCount();
    }

    // ─── Skill Management ───────────────────────────────────────
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

    // ─── Mentor Comments (untuk admin: tampilkan semua + role) ──
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

    // ─── Add Comment (Admin menulis komentar sendiri) ───────────
    public function addMentorComment($mentor_user_id, $student_user_id, $comment)
    {
        return $this->db->run(
            "INSERT INTO mentor_comments (mentor_user_id, student_user_id, comment)
             VALUES (:mentor_user_id, :student_user_id, :comment)",
            [
                'mentor_user_id'  => $mentor_user_id,
                'student_user_id' => $student_user_id,
                'comment'         => $comment,
            ]
        )->rowCount();
    }

    // ─── Update Comment ─────────────────────────────────────────
    public function updateMentorComment($comment_id, $comment)
    {
        return $this->db->run(
            "UPDATE mentor_comments SET comment = :comment WHERE id = :comment_id",
            ['comment' => $comment, 'comment_id' => $comment_id]
        )->rowCount();
    }

    // ─── Delete Comment ─────────────────────────────────────────
    public function deleteMentorComment($comment_id)
    {
        return $this->db->run(
            "DELETE FROM mentor_comments WHERE id = :comment_id",
            ['comment_id' => $comment_id]
        )->rowCount();
    }
}
