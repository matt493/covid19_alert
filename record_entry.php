<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";

    $pdo = new PDO('sqlite:db.db');
    $org_id=1;

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
<!-- <script>
    function addItem()
    {
        html = "<tr>";
        html += "<td><input type='text' name='Name[]'></td>";
        html += "<td><input type='phone' name='phone[]'></td>";
        html += "<td><select name='status' id='status'>"
        html += "<option value='negative'>Negative</option>"
        html += "<option value='positive'>Positive</option>"
        html += "</select></td>"
        html += "<td><button type='button' onclick=''>Submit</button></td>"
        html += "</tr>";
 
        var row = document.getElementById("tbody").insertRow();
        row.innerHTML = html;
    }
</script> -->

</head>
<body>

<h2>Org_name</h2>
    <table>
        <tr>
            <th>Full Name</th> <th>Phone</th> <th>Temperature</th> <th>Status</th> <th>Action</th>
        </tr>
        <?php foreach($rows as $row)
        {
        ?>
        <form method="POST" action="record_entry.php">
        <tr>
            <td> <?php echo $row['visitor_name']; ?> </td>
            <td> <?php echo $row['visitor_phno']; ?> </td>
            <td> <?php echo $row['temperature']; ?> </td>
            <td> <?php echo $row['status']; ?> </td>
            <input type="hidden" name="visit_id" value= <?php echo $row['visit_id']; ?>>
            <td><input type="submit" name="finalize" value="End Time"></td>
        </tr>
        </form>
        <?php  
        }
        ?>
        <form method="POST" action="record_entry.php">
        <tr>
            <td><input type='text' name='name'></td>
            <td><input type='phone' name='phone'></td>
            <td><input type='number' name='temperature'></td>
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
    $pdo = new PDO('sqlite:db.db');

    $sql = "insert into visit(org_id,time_start,temperature,visitor_phno,visitor_name) VALUES(?,julianday('now'),?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$org_id,$_POST['temperature'], $_POST['phone'], $_POST['name']]);
    $_POST = array();
}

if(isset($_POST['finalize']))
{
    $pdo = new PDO('sqlite:db.db');

    $sql = "update visit set time_end = julianday('now') where visit_id = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['visit_id']]);
    $_POST = array();
}
?>