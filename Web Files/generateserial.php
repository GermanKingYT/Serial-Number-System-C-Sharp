<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "serial";

$chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$serial = '';
$max = count($chars)-1;
for($i=0;$i<25;$i++){
    $serial .= (!($i % 5) && $i ? '-' : '').$chars[rand(0, $max)];
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO `serial` (`id`, `serial`, `hwid`) VALUES (NULL, '$serial', '')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully!<br>";
	echo $serial;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<html>
<head>
<title>Serial check</title>
</head>

<body>
</body>
</html>