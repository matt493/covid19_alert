<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
h2{
    text-align: left;
}
.a{
    text-align: center;
    background-color: #45a049;
    padding-bottom: 15px;
}
</style>

<?php
    // mail('mathewreji493@gmail.com','covid-19 alert','u are in primary contact','From: mobilenetz73@gmail.com');
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    $pdo = new PDO('sqlite:db.db');
   
    $sql="select * from visit where status = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['positive']);
    $rows = $stmt->fetchAll();

    // echo "<pre>";
    // print_r($rows);
    // echo "</pre>";
?>

</head>
<body>

<div class="a"></br>
    <h2 style="text-align:center">Medical Centre</h2>
    <form method="POST" action="medical_centre.php">
        <input  type='email' name='email'  placeholder="Enter e-mail ID">
        <button type='submit' name= 'submit' value='submit'>Add Report</button>
    </form>
</div>

<table>
        <tr>
            <th>Full Name</th> <th>E-Mail</th> <th>Temperature</th> <th>Time START</th> <th>Time END</th> <th>Status</th>
        </tr>
        <?php foreach($rows as $row)
        {
        ?>
        <form method="POST" action="record_entry.php">
        <tr>
            <td> <?php echo $row['visitor_name']; ?> </td>
            <td> <?php echo $row['email']; ?> </td>
            <td> <?php echo $row['temperature']; ?>  </td>
            <td> <?php echo $row['time_start']; ?>  </td>
            <td> <?php echo $row['time_end']; ?>  </td>
            <td> <?php echo $row['status']; ?> </td>
        </tr>
        </form>
        <?php  
        }
        ?>
    </table>

    <?php



    ?>

</body>

<?php
if(isset($_POST['submit']))
{
    $sql = "update visit set status = 'positive' where email = ? and time_start >= (julianday('now') - 14)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['email']]);
    // $_POST = array();

    //CORE LOGIC

    $sql = "select * from visit where email = ? and time_start >= (julianday('now') - 14) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['email']]);
    $rows = $stmt->fetchAll();

    // echo "<pre>";
    // print_r($rows);
    // echo "</pre>";

    // $time_start_arr = array();
    // $time_end_arr = array();
    $primary_contact_list = array();
    $contact_list = array();
    foreach ($rows as $row)
    {
        // array_push($time_start_arr, $row['time_start']);
        // array_push($time_end_arr, $row['time_end']);
        $time_start = $row['time_start'];
        $time_end = $row['time_end'];

        $sql = "select * from visit where (time_start <= ?) and (time_end >= ?)  and (status='negative');";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$time_end , $time_start]);
        $contact_list = $stmt->fetchAll();
        // $contact_list = array_merge($contact_list, $stmt->fetchAll());
    }
    // $contact_list = array_unique($contact_list);
    // mail('mathewreji493@gmail.com','covid-19 alert','u are in primary contact','From: mobilenetz73@gmail.com');
?>
<h2>Primary Contacts</h2>
    <table>
        <tr>
            <th>Full Name</th> <th>E-Mail</th> <th>Temperature</th> <th>Status</th>
        </tr>
        <?php foreach($contact_list as $contact)
        {
        ?>
        <form method="POST" action="record_entry.php">
        <tr>
            <td> <?php echo $contact['visitor_name']; ?> </td>
            <td> <?php echo $contact['email']; ?> </td>
            <td> <?php echo $contact['temperature']; ?>  </td>
            <td> primary contact </td>
        </tr>
        </form>
        <?php  
        }
        ?>
    </table>
<?php

    // echo "<pre>";
    // print_r($contact_list);
    // echo "</pre>";

    // echo "<pre>";
    // print_r($time_start_arr);
    // echo "</pre>";

    //--logic--

    $_POST = array();
    header("medical_centre.php");
    exit;
}
?>

</html>
