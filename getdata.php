<?php
$servername = "localhost";
$username ="root";
$password ="";
$dbname ="bootstrap";

$conn= mysqli_connect($servername,$username,$password,$dbname);

$sql = "SELECT * FROM page";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result)>0) {

    while($row = mysqli_fetch_assoc($result)) {
        echo "Name:" .$row["name"] . "<br>";
        echo "Email:" .$row["mail"] . "<br>";
        echo "Subject:" .$row["sub"] . "<br>";
        echo "Message:" .$row["msg"] . "<br><br>";
    
    }
}
else{
    echo "0 results";
}

mysqli_close($conn);
?>