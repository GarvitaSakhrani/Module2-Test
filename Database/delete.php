<?php
/**
 * Delete class, contains functions to delete enteries from database.
 */
class Delete
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
   * Delete data function to delete entry.
   *
   * @return void
   * It matches the obtained id with the enteries in table and delete corresponding entry.
   */
  public function deleteData() {
    $id = $_POST['id'];
    $stmt = $this->con->prepare("DELETE FROM todo_list WHERE id=?");
    $stmt->bind_param('i',$id);
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
      echo "Entry deleted";
    } else {
      echo "Error Deleting";
    }
  }
  /**
   * Destructor to close connection with server.
   */
  public function __destruct() {
    $this->con->close();
  }
}
//Creating instance of class and calling delete function.
$entry = new Delete();
$entry->deleteData();
?>
