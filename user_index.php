<?php
include "db_conn.php";
include 'config.php';

session_start();

if (!isset($_SESSION['student_name'])) {
   header('location:form.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Schedules</title>
</head>

<body>
<div id="particles-js"></div>

<header>
  <h1><span><?php echo $_SESSION['student_name'] ?></span></h1>
  <a href="logout.php" class="ghost">Logout</a>
</header>



  <div class="container">
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">Building Name</th>
          <th scope="col">Room Number</th>
          <th scope="col">Subject Code</th>
          <th scope="col"><a href="?sort=date">Date</a></th>
          <th scope="col">Time</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

        // Modify the SQL query based on the sorting option
        $sql = "SELECT * FROM event_tbl e INNER JOIN subject_tbl s ON e.subject_id = s.subject_id";

        if ($sort === 'date') {
          $sql .= " ORDER BY e.event_date ASC";
        }

        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $row["building_name"] ?></td>
            <td><?php echo $row["room_number"] ?></td>
            <td><?php echo $row["subject_code"] ?></td>
            <td><?php echo $row["event_date"] ?></td>
            <td><?php echo $row["event_time"] ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="js/particles.js"></script>
	<script src="js/app.js"></script>
</body>

</html>
