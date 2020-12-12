<?php

$pdo = new PDO('sqlite:db.db');

$stmt=$pdo->query("select * from organisation");

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($rows);
// echo "</pre>";
?>
<html>
<body>
    <table>
    <tr>
        <th>org_id</th>
        <th>org_name</th>
        <th>org_phno</th>
    </tr>
    <?php foreach($rows as $row)
    {
    ?>
    <tr>
        <td> <?php echo $row['org_id']; ?> </td>
        <td> <?php echo $row['org_name']; ?> </td>
        <td> <?php echo $row['org_phno']; ?> </td>
    </tr>
    <?php  
    }
    ?>
    </table>
</body>
</html>
