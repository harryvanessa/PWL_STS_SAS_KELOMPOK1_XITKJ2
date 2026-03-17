<?php

class Skill_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllSkills()
    {
        return $this->db->run("SELECT * FROM skills")->resultSet();
    }

    public function getSkillById($id)
    {
        return $this->db->run("SELECT * FROM skills WHERE id = :id", ['id' => $id])->single();
    }
}
