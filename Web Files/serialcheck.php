<?php
$link = mysqli_connect('localhost','root','');
$database = mysqli_select_db($link,'serial');

$serial = $_GET['serial'];
$hwid = $_GET['hwidin'];

$sql = "SELECT * FROM serial WHERE serial = '". mysqli_real_escape_string($link,$serial) ."'" ;
$result = $link->query($sql);

/*
0 = Wrong HWID
1 = HWID is correct
2 = HWID left empty
3 = No serial with that key
*/

if(strlen($hwid) < 1)
{
	echo "2";
}
else
{
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if (strlen($row['hwid']) > 1)
			{
				if ($hwid != $row['hwid'])
				{
					echo "0";
				}
				else
				{
					echo "1";
				}
			}
			else
			{
				$sql = "UPDATE serial SET hwid='$hwid' WHERE serial='$serial'";
				echo "1";
				if(mysqli_query($link, $sql))
				{
					echo $row['hwid'];
				}
				else
				{
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
				}
			}
		}
	}
	else
	{
		echo "3";
	}
}

/*
0 = Wrong HWID
1 = HWID is correct
2 = HWID left empty
3 = No serial with that key
*/

?>

<html>
<head>
<title>Serial check</title>
</head>

<body>
</body>
</html>