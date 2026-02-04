<?php
class AuthController
{
          private $db;
          private $user;

          public function __construct($database, $userModel)
          {
                    $this->db = $database;
                    $this->user = $userModel;
          }

          public function register($name, $email, $password, $confirm_password)
          {
                    $errors = [];

                    // Validation
                    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                              $errors[] = "All fields are required";
                    }

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                              $errors[] = "Invalid email format";
                    }

                    if (strlen($password) < 8) {
                              $errors[] = "Password must be at least 8 characters";
                    }

                    if ($password !== $confirm_password) {
                              $errors[] = "Passwords do not match";
                    }

                    // Check if email exists
                    $this->user->email = $email;
                    if ($this->user->emailExists()) {
                              $errors[] = "Email already exists";
                    }

                    if (count($errors) > 0) {
                              return ["success" => false, "errors" => $errors];
                    }

                    // Register user
                    $this->user->name = $name;
                    $this->user->email = $email;
                    $this->user->password = $password;

                    if ($this->user->register()) {
                              return ["success" => true, "message" => "Registration successful"];
                    }

                    return ["success" => false, "errors" => ["Registration failed"]];
          }

          public function login($email, $password)
          {
                    $errors = [];

                    if (empty($email) || empty($password)) {
                              $errors[] = "All fields are required";
                    }

                    if (count($errors) > 0) {
                              return ["success" => false, "errors" => $errors];
                    }

                    $this->user->email = $email;

                    if ($this->user->login($password)) {
                              $_SESSION['user_id'] = $this->user->id;
                              $_SESSION['user_name'] = $this->user->name;
                              $_SESSION['user_email'] = $this->user->email;
                              $_SESSION['logged_in'] = true;

                              return ["success" => true, "message" => "Login successful"];
                    }

                    return ["success" => false, "errors" => ["Invalid email or password"]];
          }

          public function logout()
          {
                    session_unset();
                    session_destroy();
                    return true;
          }

          public function isLoggedIn()
          {
                    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
          }

          public function getCurrentUser()
          {
                    if ($this->isLoggedIn()) {
                              return [
                                        'id' => $_SESSION['user_id'],
                                        'name' => $_SESSION['user_name'],
                                        'email' => $_SESSION['user_email']
                              ];
                    }
                    return null;
          }
}
