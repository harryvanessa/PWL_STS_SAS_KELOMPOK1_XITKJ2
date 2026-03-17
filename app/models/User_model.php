<?php

class User_model {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUserByUsername($username)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind('username', $username);
        return $this->db->single();
    }

    public function isUsernameTaken($username)
    {
        $this->db->query('SELECT id FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind('username', $username);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    public function registerStudent($data)
    {
        try {
            $this->db->run(
                "INSERT INTO users (username, password, role) VALUES (:username, :password, 'student')",
                ['username' => $data['username'], 'password' => password_hash($data['password'], PASSWORD_DEFAULT)]
            )->execute();

            $uid = $this->db->lastInsertId();

            return $this->db->run(
                "INSERT INTO student_profiles (user_id, full_name, email, phone, address)
                 VALUES (:user_id, :full_name, :email, :phone, :address)",
                ['user_id' => $uid, 'full_name' => $data['full_name'],
                 'email'   => $data['email'], 'phone' => $data['phone'], 'address' => $data['address']]
            )->rowCount();
        } catch (PDOException) {
            return -1;
        }
    }

    public function registerMentor($data)
    {
        try {
            $this->db->run(
                "INSERT INTO users (username, password, role) VALUES (:username, :password, 'mentor')",
                ['username' => $data['username'], 'password' => password_hash($data['password'], PASSWORD_DEFAULT)]
            )->execute();

            $uid = $this->db->lastInsertId();

            return $this->db->run(
                "INSERT INTO mentor_profiles (user_id, skill_id, full_name, email, phone, experience, status)
                 VALUES (:user_id, :skill_id, :full_name, :email, :phone, :experience, 'pending')",
                ['user_id' => $uid,        'skill_id'   => $data['skill_id'],
                 'full_name' => $data['full_name'], 'email'   => $data['email'],
                 'phone'    => $data['phone'],      'experience' => $data['experience']]
            )->rowCount();
        } catch (PDOException) {
            return -1;
        }
    }
}
