<?php

class Post {

  private $db;

  public function __construct(){
    $this->db = new Database;
  }

  public function getPosts(){
    $this->db->query('SELECT *,    
                    posts.id as postId,
                    users.id as userId,
                    posts.created_at as postsCreated,
                    users.created_at as usersCreated
                    FROM posts                    
                    INNER JOIN users
                    ON posts.user_id = users.id
                    ORDER BY posts.created_at DESC
                    ');

    $results = $this->db->resultSet();

    return $results;
  }

  public function addPost($data){
    $this->db->query('INSERT INTO posts (title, body, user_id) VALUES(:title, :body, :user_id)');
    // Bind values
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':body', $data['body']);  
    $this->db->bind(':user_id', $data['user_id']);  

    // Exectue
    return ($this->db->execute() ? true : false);
  }

  public function getPost($id){
    $this->db->query('SELECT * FROM posts WHERE id = :id');  
    // Bind values
    $this->db->bind(':id', $id);   
    $post = $this->db->single();
    return $post;
  }

  public function updatePost($data){
    $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
    // Bind values
    $this->db->bind(':id', $data['id']);  
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':body', $data['body']);  
    // Exectue
    return ($this->db->execute() ? true : false);
  }

  public function deletePost($id){
    $this->db->query('DELETE FROM posts WHERE id = :id');  
    // Bind values
    $this->db->bind(':id', $id); 
    // Exectue
    return $this->db->execute() ? true : false;
  } 
 
  
}
