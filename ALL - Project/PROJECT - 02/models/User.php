<?php
class User
{
  private $conn;
  private $table_name = "users";

  public $id;
  public $name;
  public $email;
  public $password;
  public $created_at;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function register()
  {
    $query = "INSERT INTO " . $this->table_name . " 
                  SET name = ?, email = ?, password = ?";

    $stmt = $this->conn->prepare($query);

    // Sanitize input
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);

    // Bind values
    $stmt->bind_param("sss", $this->name, $this->email, $this->password);

    if ($stmt->execute()) {
      $stmt->close();
      return true;
    }
    $stmt->close();
    return false;
  }

  public function emailExists()
  {
    $query = "SELECT id, name, email, password 
                  FROM " . $this->table_name . " 
                  WHERE email = ? 
                  LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $this->email);
    $stmt->execute();

    $result = $stmt->get_result();
    $num = $result->num_rows;

    if ($num > 0) {
      $row = $result->fetch_assoc();
      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->email = $row['email'];
      $this->password = $row['password'];
      $stmt->close();
      return true;
    }
    $stmt->close();
    return false;
  }

  public function login($input_password)
  {
    if ($this->emailExists()) {
      if (password_verify($input_password, $this->password)) {
        return true;
      }
    }
    return false;
  }

  public function getUserById()
  {
    $query = "SELECT id, name, email, created_at 
                  FROM " . $this->table_name . " 
                  WHERE id = ? 
                  LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $this->id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
      $this->name = $row['name'];
      $this->email = $row['email'];
      $this->created_at = $row['created_at'];
      $stmt->close();
      return true;
    }
    $stmt->close();
    return false;
  }

  public function updateProfile()
  {
    $query = "UPDATE " . $this->table_name . " 
                  SET name = ?, email = ? 
                  WHERE id = ?";

    $stmt = $this->conn->prepare($query);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));

    $stmt->bind_param("ssi", $this->name, $this->email, $this->id);

    if ($stmt->execute()) {
      $stmt->close();
      return true;
    }
    $stmt->close();
    return false;
  }

  public function updatePassword($new_password)
  {
    $query = "UPDATE " . $this->table_name . " 
                  SET password = ? 
                  WHERE id = ?";

    $stmt = $this->conn->prepare($query);

    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    $stmt->bind_param("si", $hashed_password, $this->id);

    if ($stmt->execute()) {
      $stmt->close();
      return true;
    }
    $stmt->close();
    return false;
  }
}
