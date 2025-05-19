<?php
/**
 * Edit class, contains functions to update enteries within database.
 */
class Edit
{ 
  /**
   * @var con
   * It holds instance of database connection.
   */
  public $con;
  /**
   * Constructor to establish connection with server.
   */
  public function __construct() {
    $this->con = new mysqli("localhost","garvita","1234","todo");
    if ($this->con->connect_error) {
      die("Connection failed: " . $this->con->connect_error);
    }
  }
  /**
   * Edit data function to edit entry.
   *
   * @return void
   * It matches the obtained id with the enteries in table and update corresponding entry.
   */
  public function editData() {
    $id = $_POST['id'];
    $data = $_POST['text'];
    $stmt = $this->con->prepare("UPDATE todo_list SET title = ? WHERE id = ?");
    $stmt->bind_param('si',$data,$id);
    if ($stmt->execute()) {
      echo "Data Updated Successfully";
    } else {
      echo "Error inserting data";
    }
    $stmt->close();
  }
   /**
   * Destructor to close connection with server.
   */
  public function __destruct() {
    $this->con->close();
  }
}
//Creating instance of class and calling edit function.
$data = new Edit();
$data->editData();
?>
