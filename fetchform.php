<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname ="av";




$conn=mysqli_connect($servername,$username,$password,$dbname);
$sql= "SELECT * FROM form ";


mysqli_query($conn,$sql);



mysqli_close($conn);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Document</title>
</head>
<body>
<table align='center' border=1>
    
<th>Name</th>
<th>Class</th>
<th>Actions</th>

<tr>
<?php echo "<td>$Name</td>"; 
 echo "<td>$Class</td>"; ?>
 <td><button style="background-color: red;">delete</button>   <button style="background-color: green">update</button></td>
</tr>
</table>
</body>
</html>

