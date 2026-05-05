<?php

class Exchange_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // ─── Student Skills ────────────────────────────────────────────────────────

    // All skills offered by any student (excludes current user's own if $exclude_id given)
    public function getAllStudentSkills($exclude_id = null)
    {
        $sql = "SELECT ss.id, ss.level, ss.description, ss.created_at,
                       s.name AS skill_name, s.description AS skill_desc,
                       sp.full_name, u.id AS student_user_id, u.username
                FROM student_skills ss
                JOIN skills s          ON ss.skill_id   = s.id
                JOIN users  u          ON ss.student_id = u.id
                JOIN student_profiles sp ON u.id        = sp.user_id";

        if ($exclude_id) {
            $sql .= " WHERE ss.student_id != :exclude_id";
            return $this->db->run($sql, ['exclude_id' => $exclude_id])->resultSet();
        }

        return $this->db->run($sql)->resultSet();
    }

    // group
    public function getSkillsByCategory($skill_id)
    {
        return $this->db->run(
            "SELECT ss.id, ss.level, ss.description, ss.created_at,
                    s.name AS skill_name,
                    sp.full_name, u.id AS student_user_id, u.username
             FROM student_skills ss
             JOIN skills s           ON ss.skill_id   = s.id
             JOIN users  u           ON ss.student_id = u.id
             JOIN student_profiles sp ON u.id         = sp.user_id
             WHERE ss.skill_id = :skill_id",
            ['skill_id' => $skill_id]
        )->resultSet();
    }

    // Specific student_skill record with full detail
    public function getStudentSkillDetail($id)
    {
        return $this->db->run(
            "SELECT ss.*, s.name AS skill_name, s.description AS skill_desc,
                    sp.full_name, sp.email, sp.phone, u.id AS student_user_id, u.username
             FROM student_skills ss
             JOIN skills s           ON ss.skill_id   = s.id
             JOIN users  u           ON ss.student_id = u.id
             JOIN student_profiles sp ON u.id         = sp.user_id
             WHERE ss.id = :id",
            ['id' => $id]
        )->single();
    }

    // Skills that a specific student has listed
    public function getMySkills($student_id)
    {
        return $this->db->run(
            "SELECT ss.*, s.name AS skill_name
             FROM student_skills ss
             JOIN skills s ON ss.skill_id = s.id
             WHERE ss.student_id = :student_id
             ORDER BY ss.created_at DESC",
            ['student_id' => $student_id]
        )->resultSet();
    }

    public function addStudentSkill($data): int
    {
        return $this->db->run(
            "INSERT INTO student_skills (student_id, skill_id, level, description)
             VALUES (:student_id, :skill_id, :level, :description)",
            [
                'student_id' => $data['student_id'],
                'skill_id' => $data['skill_id'],
                'level' => $data['level'],
                'description' => $data['description']
            ]
        )->rowCount();
    }

    public function deleteStudentSkill($id, $student_id): int
    {
        return $this->db->run(
            "DELETE FROM student_skills WHERE id = :id AND student_id = :student_id",
            ['id' => $id, 'student_id' => $student_id]
        )->rowCount();
    }

    // ─── Exchanges ─────────────────────────────────────────────────────────────

    public function requestExchange($data): int
    {
        return $this->db->run(
            "INSERT INTO skill_exchanges (requester_id, provider_id, student_skill_id, message)
             VALUES (:requester_id, :provider_id, :student_skill_id, :message)",
            [
                'requester_id' => $data['requester_id'],
                'provider_id' => $data['provider_id'],
                'student_skill_id' => $data['student_skill_id'],
                'message' => $data['message']
            ]
        )->rowCount();
    }

    // Requests incoming to this student (they own the skill)
    public function getIncomingRequests($student_id)
    {
        return $this->db->run(
            "SELECT se.*, ss.level, s.name AS skill_name,
                    sp.full_name AS requester_name, u.username AS requester_username
             FROM skill_exchanges se
             JOIN student_skills ss    ON se.student_skill_id = ss.id
             JOIN skills s             ON ss.skill_id         = s.id
             JOIN users u              ON se.requester_id     = u.id
             JOIN student_profiles sp  ON u.id               = sp.user_id
             WHERE se.provider_id = :student_id
             ORDER BY se.created_at DESC",
            ['student_id' => $student_id]
        )->resultSet();
    }

    // Requests this student has sent
    public function getOutgoingRequests($student_id)
    {
        return $this->db->run(
            "SELECT se.*, ss.level, s.name AS skill_name,
                    sp.full_name AS provider_name, u.username AS provider_username
             FROM skill_exchanges se
             JOIN student_skills ss    ON se.student_skill_id = ss.id
             JOIN skills s             ON ss.skill_id         = s.id
             JOIN users u              ON se.provider_id      = u.id
             JOIN student_profiles sp  ON u.id               = sp.user_id
             WHERE se.requester_id = :student_id
             ORDER BY se.created_at DESC",
            ['student_id' => $student_id]
        )->resultSet();
    }

    public function updateExchangeStatus($id, $provider_id, $status): int
    {
        return $this->db->run(
            "UPDATE skill_exchanges SET status = :status
             WHERE id = :id AND provider_id = :provider_id",
            ['status' => $status, 'id' => $id, 'provider_id' => $provider_id]
        )->rowCount();
    }

    // Check if a requester already sent a request for this student_skill
    public function hasExistingRequest($requester_id, $student_skill_id): bool
    {
        return $this->db->run(
            "SELECT id FROM skill_exchanges
             WHERE requester_id = :requester_id AND student_skill_id = :student_skill_id
               AND status = 'pending'",
            ['requester_id' => $requester_id, 'student_skill_id' => $student_skill_id]
        )->rowCount() > 0;
    }
}
