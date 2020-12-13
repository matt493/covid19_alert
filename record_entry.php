<?php

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    $org_id=$_GET["org_id"];
    $pdo = new PDO('sqlite:db.db');
   
    $sql = "select * from visit where org_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$org_id]);
    $rows = $stmt->fetchAll();

    // echo "<pre>";
    // print_r($rows);
    // echo "</pre>";
?>

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

</style>

</head>
<body>
<?php
    // $pdo = new PDO('sqlite:db.db');
    // $org_id = 1;

    $sql = "select org_name from organisation where org_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$org_id]);
    $org_name = $stmt->fetch();

?>
    <h1> <?php echo $org_name['org_name']; ?> </h1>
    <table>
        <tr>
            <th>Full Name</th> <th>E-Mail</th> <th>Temperature</th> <th>Time START</th> <th>Time END</th> <th>Status</th> <th>Action</th>
        </tr>
        <?php 
        $action_get = "record_entry.php?org_id=".$org_id;
        $header_get = "Location:record_entry.php?org_id=".$org_id;
        // echo $action_get;
        // echo $header_get;
        foreach($rows as $row)
        {
        ?>
        <form method="POST" action="<?php echo $action_get; ?>">
        <tr>
            <td> <?php echo $row['visitor_name']; ?> </td>
            <td> <?php echo $row['email']; ?> </td>
            <td> <?php echo $row['temperature']; ?>  </td>
            <td> <?php echo $row['time_start']; ?>  </td>
            <td> <?php echo $row['time_end']; ?>  </td>
            <td> <?php echo $row['status']; ?> </td>
            <input type="hidden" name="visit_id" value= <?php echo $row['visit_id']; ?>>
            <td><input type="submit" name="finalize" value="End Time"></td>
        </tr>
        </form>
        <?php  
        }
        ?>
        <form method="POST" action="<?php echo $action_get; ?>">
        <tr>
            <td><input type='text' name='name'></td>
            <td><input type='email' name='email'></td>
            <td><input type='number' name='temperature'></td>
            <td>-time_start-</td>
            <td>-time_end-</td>
            <td>-status-</td>
            <td><input type="submit" name="init_record" value="Init Time"></td>
        </tr>
        </form>
    </table>

    <!-- <button style="margin: 4px" type="button" onclick="addItem();">Add</button> -->
</body>
</html>

<?php
if(isset($_POST['init_record']))
{
    $sql = "insert into visit(org_id,time_start,temperature,email,visitor_name) VALUES(?,julianday('now'),?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$org_id,$_POST['temperature'], $_POST['email'], $_POST['name']]);
    $_POST = array();

    header($header_get);
    exit;
}
else if(isset($_POST['finalize']))
{
    $sql = "update visit set time_end = julianday('now') where visit_id = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['visit_id']]);
    $_POST = array();

    header($header_get);
    exit;
}
?>