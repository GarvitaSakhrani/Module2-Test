<?php
/**
 * Insert class, contains functions to create enteries within database.
 */
class Insert 
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
   * Create Table function to create table.
   *
   * @return void
   * It created todo list table to store enteries if it doesnot exist.
   */
  public function createTable() {
    $sql = 'CREATE TABLE IF NOT EXISTS todo_list(
            id int auto_increment primary key,
            title varchar(300) not null,
            status varchar(250) default "Pending" 
            );';
    $stmt = $this->con->prepare($sql);
    $stmt->execute();
    $stmt->close();
  }
  /**
   * Insert data function to create entry.
   *
   * @return void
   * It accepts the title of task and creates an entry into the database.
   */
  public function insertData() {
    $data = $_POST['text'];
    $this->createTable();
    $stmt = $this->con->prepare("INSERT INTO todo_list(title) VALUES(?)");
    $stmt->bind_param('s',$data);
    if ($stmt->execute()) {
      echo $this->con->insert_id;;
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
//Creates instance if server request method is post.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //Creating instance of class and calling delete function.
  $obj = new Insert();
  $obj->insertData();
} else {
  echo "Error encountered while accepting data.";
}
?>
