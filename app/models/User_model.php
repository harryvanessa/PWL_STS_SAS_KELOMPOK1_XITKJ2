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
            // 1. Insert ke tabel users
            $queryUser = "INSERT INTO users (username, password, role) VALUES (:username, :password, 'student')";
            $this->db->query($queryUser);
            $this->db->bind('username', $data['username']);
            $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
            $this->db->execute();

            // Ambil ID user yang baru masuk
            $this->db->query('SELECT LAST_INSERT_ID() as id');
            $user_id = $this->db->single()['id'];

            // 2. Insert ke tabel student_profiles
            $queryStudent = "INSERT INTO student_profiles (user_id, full_name, email, phone, address) 
                            VALUES (:user_id, :full_name, :email, :phone, :address)";
            $this->db->query($queryStudent);
            $this->db->bind('user_id', $user_id);
            $this->db->bind('full_name', $data['full_name']);
            $this->db->bind('email', $data['email']);
            $this->db->bind('phone', $data['phone']);
            $this->db->bind('address', $data['address']);
            
            $this->db->execute();
            return $this->db->rowCount();
        } catch (PDOException $e) {
            return -1; // Signal error
        }
    }

    public function registerMentor($data)
    {
        try {
            // 1. Insert ke tabel users (role=mentor)
            $queryUser = "INSERT INTO users (username, password, role) VALUES (:username, :password, 'mentor')";
            $this->db->query($queryUser);
            $this->db->bind('username', $data['username']);
            $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
            $this->db->execute();

            // Ambil ID
            $this->db->query('SELECT LAST_INSERT_ID() as id');
            $user_id = $this->db->single()['id'];

            // 2. Insert ke tabel mentor_profiles
            $queryMentor = "INSERT INTO mentor_profiles (user_id, skill_id, full_name, email, phone, experience, status) 
                            VALUES (:user_id, :skill_id, :full_name, :email, :phone, :experience, 'pending')";
            $this->db->query($queryMentor);
            $this->db->bind('user_id', $user_id);
            $this->db->bind('skill_id', $data['skill_id']);
            $this->db->bind('full_name', $data['full_name']);
            $this->db->bind('email', $data['email']);
            $this->db->bind('phone', $data['phone']);
            $this->db->bind('experience', $data['experience']);
            
            $this->db->execute();
            return $this->db->rowCount();
        } catch (PDOException $e) {
            return -1; // Signal error
        }
    }
}
