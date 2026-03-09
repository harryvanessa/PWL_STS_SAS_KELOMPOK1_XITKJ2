<?php

class Skill_model {
    private $table = 'skills';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllSkills()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getSkillById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }
}
