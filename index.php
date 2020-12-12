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
<script>
    function addItem()
    {
        html = "<tr>";
        html += "<td><input type='text' name='Name[]'></td>";
        html += "<td><input type='phone' name='phone[]'></td>";
        html += "<td><select name='status' id='status'>"
        html +=  "<option value='negative'>Negative</option>"
        html += "<option value='positive'>Positive</option>"
        html += "</select></td>"
        html += "<td><button type='button' onclick=''>Submit</button></td>"
        html += "</tr>";
 
        var row = document.getElementById("tbody").insertRow();
        row.innerHTML = html;
    }
    
</script>

</head>
<body>

<h2>Org_name</h2>

<form method="POST" action="index.php">
 
    <table>
        <tr>
            <th>Name</th> <th>Phone</th> <th>Status</th> <th>Action</th>
        </tr>
        <tbody id="tbody"></tbody>
    </table>
 
    <button style="margin: 4px" type="button" onclick="addItem();">Add</button>
</form>


</body>
</html>