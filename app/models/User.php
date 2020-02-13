<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Register user
    public function register($data){
      $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)') ;
      // Bind values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);

      // Exectue
      return ($this->db->execute() ? true : false);
    }

    public function login($email, $password){
      // Store logged in user in $_SESSION['user']
      $query = $this->db->query('SELECT * FROM users WHERE (email = :email)');
      // Bind value
      $this->db->bind(':email', $email);
      $row = $this->db->single();    
      $hashed_password = $row->password;
      if (password_verify($password, $hashed_password)){
        // Login form password matches db password
        return $row;
      } else {
        return false;
      }
    }

    // Find user by email
    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM users WHERE email = :email');
      // Bind value between :named param and real param
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      // Check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Get user by id
    public function getUser($id){
      $this->db->query('SELECT * FROM users WHERE id = :id');  
      // Bind values
      $this->db->bind(':id', $id);   
      $user = $this->db->single();
      return $user;
    }

  }