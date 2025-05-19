<!-- Establishing connection with mysqli server -->
<?php
$con = new mysqli("localhost", "garvita", "1234", "todo");
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
$error = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./asset/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="./asset/jQuery/script.js"></script>
  <title>To Do List</title>
</head>
<body>
  <main>
    <!-- Home section starts here -->
    <section class = "home">
      <div class="container">
        <h1>To Do List</h1>
        <p>Welcome to Todo List app, helps managing your tasks efficiently.</p>
        <div id = "option">
          <!-- Form to create enteries within list -->
          <form class="form" method = "POST">
            <div id="textbox">
              <input type="text" id="title" name="title" placeholder="Enter Task Title">
            </div>
            <div id="button">
              <input type="button" id="submit" value="submit" onclick = "insert_data()">
            </div>
          </form>
        </div>
        <!-- For displaying error encountered -->
        <div id = "error">
          <?php echo $error; ?>
        </div>
        <!-- Displays the entered values from the database -->
        <div id="display">
          <table id="row-data">
            <?php
              $sql ="SELECT * FROM todo_list ORDER BY id DESC";
              $result = $con->query($sql);
              // Checks whether table contain any record
              if($result->num_rows>0):
                while($row=$result->fetch_assoc()):
            ?>
            <!-- Table row to display title, status and actions associated with entry -->
              <tr id="row<?php echo $row['id'] ?>" class="<?php echo $row['status'] === 'Done' ? 'done' : '' ?>">
                <td>
                  <input type="checkbox" onchange="toggle_box(<?php echo $row['id'] ?>)" <?php echo $row['status'] === 'Done'? 'checked' : '' ?>>
                  <span class="data"><?php echo htmlspecialchars($row['title']) ?></span>
                </td>
                <td><a href="javascript:void(0)" onclick ="delete_data('<?php echo $row['id'] ?>')">Delete</a></td>
                <td><a href="javascript:void(0)" onclick="edit_data('<?php echo $row['id'] ?>')">Edit</a></td>
              </tr>
            <?php
                endwhile;
              // Indicates that no record present.
              else:
                echo "No Enteries Added";
              endif;
            ?>
          </table>
        </div>
      </div>
    </section>
    <!-- Home section ends -->
  </main>
</body>
</html>
