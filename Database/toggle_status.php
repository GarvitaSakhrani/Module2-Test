<?php
/**
 * Toggle class, contains functions to change status of entry within database.
 */
class Toggle 
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
    $this->con = new mysqli("localhost", "garvita", "1234", "todo");
    if ($this->con->connect_error) {
      die("Connection failed: " . $this->con->connect_error);
    }
  }
  /**
   * Toggle status function to change status of entry.
   *
   * @return void
   * It matches the obtained id with the enteries in table and extracts status of entry from databse.
   * If the current status is Pending, it becomes Done and vice-versa.
   */
  public function toggleStatus() {
    //Finds current status of entry.
    $id = $_POST['id'];
    $stmt = $this->con->prepare("SELECT status FROM todo_list WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $currentStatus = $row['status'];
    //updates the status of entry accordingly.
    $newStatus = ($currentStatus === 'Done') ? 'Pending' : 'Done';
    $updateStmt = $this->con->prepare("UPDATE todo_list SET status = ? WHERE id = ?");
    $updateStmt->bind_param("si", $newStatus, $id);
    $updateStmt->execute();
    echo $newStatus;
    $stmt->close();
    $updateStmt->close();
  }
  /**
   * Destructor to close connection with server.
   */
  public function __destruct() {
    $this->con->close();
  }
}
//Creating instance of class and calling toggle function.
$toggle = new Toggle();
$toggle->toggleStatus();
?>
