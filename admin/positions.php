<?php
include('../functions.php');
$conn=  mysqli_connect('localhost', 'root', '', 'poll');
//retrive positions from the tbpositions table
$result=mysqli_query($conn,"SELECT * FROM tbPositions")
or die("There are no records to display ... \n" . mysqli_error()); 
if (mysqli_num_rows($result)<1){
    $result = null;
}
?>

<?php
// inserting sql query
if (isset($_POST['Submit']))
{

$newPosition = addslashes( $_POST['position'] ); //prevents types of SQL injection

$sql = mysqli_query($conn, "INSERT INTO tbPositions(position_name) VALUES ('$newPosition')" )
        or die("Could not insert position at the moment" );

// redirect back to positions
 header("Location: positions.php");
}
?>
<?php
// deleting sql query
// check if the 'id' variable is set in URL
 if (isset($_GET['id']))
 {
 // get id value
 $id = $_GET['id'];
 
 // delete the entry
 $result = mysqli_query($conn,"DELETE FROM tbPositions WHERE position_id='$id'")
 or die("The position does not exist ... \n"); 
 
 // redirect back to positions
 header("Location: positions.php");
 }
 else
 // do nothing
    
?>
<!DOCTYPE html>
<html>
<head>
<title>Administration Control Panel:Positions</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/admin.js">
</script>
<style type="text/css">
	td {
		text-align: center;
	}
</style>
</head>
<body>
<center><b><font color = "brown" size="6">Election Commission of India</font></b></center><br><br>
<div id="page">
<div id="header">
  <h1>MANAGE POSITIONS</h1>
  <a href="home.php">Home</a> | <a href="create_user.php">Manage Administrators</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="../login.php">Logout</a>
</div>
<div id="container">
<table width="380" align="center">
<CAPTION><h3>ADD NEW POSITION</h3></CAPTION>
<form name="fmPositions" id="fmPositions" action="positions.php" method="post" onsubmit="return positionValidate(this)">
<tr>
    <td>Position Name</td>
    <td><input type="text" name="position" /></td>
    <td><input type="submit" name="Submit" value="Add" /></td>
</tr>
</table>
<hr>
<table border="0" width="420" align="center">
<CAPTION><h3>AVAILABLE POSITIONS</h3></CAPTION>
<tr>
<th>Position ID</th>
<th>Position Name</th>
</tr>

<?php
//loop through all table rows
while ($row=mysqli_fetch_array($result)){
echo "<tr>";
echo "<td>" . $row['position_id']."</td>";
echo "<td>" . $row['position_name']."</td>";
echo '<td><a href="positions.php?id=' . $row['position_id'] . '">Delete Position</a></td>';
echo "</tr>";	
}
mysqli_free_result($result);
mysqli_close($conn);
?>
</table>
<hr>
</div>
<div id="footer"> 
  <div class="bottom_addr">&copy; 2018 Govt of India. All Rights Reserved</div>
</div>
</div>
</body>
</html>