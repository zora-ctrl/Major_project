

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Dashboard</title>
</head>
<body>
   
   <form method="POST" align="center"  >
    <h2>DASHBOARD</h2>
 <input type="text" placeholder="name" name="uname"><br>
 <input type="text" placeholder="class" name="uclass"><br>
<button style="background-color: skyblue">Submit</button>
</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname ="av";


$Name=$_POST['uname'];
$Class=$_POST['uclass'];

$conn=mysqli_connect($servername,$username,$password,$dbname);
$sql="INSERT INTO form(uname,uclass)
VALUES('$Name','$Class')";
mysqli_query($conn,$sql);
 

include 'fetchform.php';

?>





 