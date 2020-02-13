<?php

class Posts extends Controller {

    public function __construct(){
      // redirect non logged in users to login page
      // this in the constructor blocks access to all methods on the controller
      // to block a specific method put inside the method
      if (!isLoggedIn()){
        redirect ('users/login');
      } 

      // load the models
      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
    }

    public function index(){
      // Get posts
      $posts = $this->postModel->getPosts();  
      
      $data = [
        'posts' => $posts,
      ];
  
      $this->view('posts/index', $data);
    }

    public function add(){
     
      // Check for POST     
      // Post requsest that comes from Add Post button on the Add Post form  
      if ($_SERVER['REQUEST_METHOD'] === 'POST'){
          
        // Process form        
        // Sanitze POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //sanitize as string
        
        // Init data       
        if (isset($_POST['title']) && isset($_POST['body'])) {
          $data =[
            'title' => trim($_POST['title']),
            'body' => trim($_POST['body']),             
            'user_id' => trim($_SESSION['user_id']),
            'title_err' => '',
            'body_err'  => ''
          ];   
          
          //Validate data
          if (empty($data['title'])){
            $data['title_err'] = 'Please enter title';
          }

          if (empty($data['body'])){
            $data['body_err'] = 'Please enter body text';
          }

          // Make sure no errors
          if (empty($data['title_err']) && empty($data['body_err'])){
            // Validated
            if($this->postModel->addPost($data)){            
              flash('post_message', 'Post Added');
              redirect('posts');
            } else {
              flash('post_message', 'Post NOT Added', 'alert alert-waring');
            }
            
          } else {
              // Load with errors
              $this->view('posts/add', $data);            
          }
        }

      } else {
        // GET request that comes from Add Post button on post page -- top right
        $data = [
          'title' => '',
          'body'  => ''
        ];

        $this->view('posts/add', $data);
       }
    }

    public function edit($id){
     
      // Check for POST     
      // Post requsest that comes from Add Post button on the Add Post form  
      if ($_SERVER['REQUEST_METHOD'] === 'POST'){
          
        // Process form        
        // Sanitze POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //sanitize as string
        
        // Init data       
        if (isset($_POST['title']) && isset($_POST['body'])) {
          $data =[
            'id'    => $id,
            'title' => trim($_POST['title']),
            'body'  => trim($_POST['body']),             
            'user_id'   => trim($_SESSION['user_id']),
            'title_err' => '',
            'body_err'  => ''
          ];   
          
          //Validate data
          if (empty($data['title'])){
            $data['title_err'] = 'Please enter title';
          }

          if (empty($data['body'])){
            $data['body_err'] = 'Please enter body text';
          }

          // Make sure no errors
          if (empty($data['title_err']) && empty($data['body_err'])){
            // Validated
            if($this->postModel->updatePost($data)){            
              flash('post_message', 'Post Updated');
              redirect('posts');
            } else {
              flash('post_message', 'Post FAILED to update', 'alert alert-waring');
              die('Something went wrong:  line 122 posts.php');
            }
            
          } else {
              // Load with errors
              $this->view('posts/edit', $data);            
          }
        }

      } else {
        // Get existing post from model for editing
        $post = $this->postModel->getPost($id);

        // Check for owner -- If not owner redirect...
        if ($post->user_id != $_SESSION['user_id']) {
          redirect ('posts');
        } 
          // GET request that comes from Add Post button on post page -- top right
          $data = [
            'id'    => $id,
            'title' => $post->title,
            'body'  => $post->body
          ];
  
          $this->view('posts/edit', $data);
        }
    }
    
    public function show($id){

      $post = $this->postModel->getPost($id);
      $user = $this->userModel->getUser($post->user_id);
     
      $data = [
        'post' => $post,
        'user' => $user
      ];

      $this->view('posts/show', $data);
    }

    public function delete($id){

      // Get existing post from model for removal
      $post = $this->postModel->getPost($id);

      // Check for owner -- If not owner redirect...
      if ($post->user_id != $_SESSION['user_id']) {
        redirect ('posts');
      } 
      // Delete should always be a POST request
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($this->postModel->deletePost($id)) :
        flash('post_message', 'Post Deleted');
            redirect('posts');          
        endif;
        } else { // Just a GET request
        die ('Something went wrong: Posts.php Line 180');
      }
      
    }
   
}