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

    public function getAppsByMajor($major)
    {
        return $this->db->run(
            "SELECT app_name FROM major_apps WHERE major = :major ORDER BY app_name",
            ['major' => $major]
        )->resultSet();
    }
}
