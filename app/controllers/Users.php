<?php
  class Users extends Controller {

    public function __construct(){
      $this->userModel = $this->model('User');
    }

    public function register(){
      
      // Check for POST       
      if ($_SERVER['REQUEST_METHOD'] === 'POST'){
          
        // Process form
        
        // Sanitze POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //sanitize as string
        
        // Init data
       
        $data =[
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];    
        

        // Validate email
        if (empty($data['email'])){
          $data['email_err'] = 'Please enter email';
        } else {
         // Check email
         if ($this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email is already taken';
         }
        }

        // Validate name
        // here we also validate later if the name is taken based on email
        if (empty($data['name'])){
          $data['name_err'] = 'Please enter name';
        }

        // Validate password
        if (empty($data['password'])){
          $data['password_err'] = 'Please enter password';
        } elseif (strlen($data['password']) < 6) {
          $data['password_err'] = 'Password must be at least 6 characters';
        }       

        // Validate confirm password
        if (empty($data['confirm_password'])){
          $data['confirm_password_err'] = 'Please enter password';
        } else {
          if (($data['confirm_password']) != ($data['password'])){
          $data['confirm_password_err'] = 'Passwords do not match';
          }
        }

        // Make sure errors are empty
        if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
              // Validated -- no errors
            
              // insert data to users table...
              
              // Hash the password -- strong one way hasing algorithm
              $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

              // Register user
              if ($this->userModel->register($data)) {
                flash('register_success','You are registerd and can log in');
                redirect('users/login');         
              } else {
                die('CODE 1: Somethign went wrong');
              };

            } else {
              // Load view with errors
              $this->view('users/register', $data);
            }
        }
    
        // Init data
        $data =[
          'name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // Load view
        $this->view('users/register', $data);
    
    }
    
    
    public function login(){
      // Check for POST
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Process form
         // Sanitze POST data
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); //sanitize as string
          
         // Init data       
         $data =[
       
           'email' => trim($_POST['email']),
           'password' => trim($_POST['password']),        
           'email_err' => '',
           'password_err' => '',       
         ]; 
         
        // Validate email
        if (empty($data['email'])){
          $data['email_err'] = 'Please enter email';
        }

        // Validate password
        if (empty($data['password'])){
          $data['password_err'] = 'Please enter password';
        } elseif (strlen($data['password']) < 6) {
          $data['password_err'] = 'Password must be at least 6 characters';
        } 
        
        // Check for user/email
        if ($this->userModel->findUserByEmail($data['email'])){
          // User found          
      
        } else {
          // User not found
          $data['email_err'] = 'No user found';
          //flash('user_not_found','Email not found, please register.', 'alert alert-warning');
        }

        // Make sure errors are empty
        if (empty($data['email_err']) && empty($data['password_err'])) {
          // Validated -- no errors        
          // Check and set logged in user
          // login() returns user info if valid user or false if not
          $loggedInUser = $this->userModel->login($data['email'], $data['password']);
          
          if ($loggedInUser) {
            // Create session variables
            $this->createUserSession($loggedInUser);
          } else {
            // Reload login form with error
            $data['password_err'] = 'Password incorrect';
            $this->view('users/login', $data);
          }
      } else {
        // Load view with errors
        $this->view('users/login', $data);
      }
      
      } else {
      // Init data
      $data =[    
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => '',        
      ];

      // Load view
      $this->view('users/login', $data);
      }      
    }

    public function createUserSession($user){
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_name'] = $user->name;
      redirect('posts');
    }

    public function logout() {
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy(); //gets rid of everything
      redirect ('users/login');
    }
  }