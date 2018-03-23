<?php
require('functions.php');
$conn=  mysqli_connect('localhost', 'root', '', 'poll');
?>
<?php
// retrieving positions sql query
$positions=mysqli_query($conn,"SELECT * FROM tbPositions")
or die("There are no records to display ... \n" . mysqli_error()); 
?>
<?php
    // retrieval sql query
// check if Submit is set in POST
 if (isset($_POST['Submit']))
 {
 // get position value
 $position = addslashes( $_POST['position'] ); //prevents types of SQL injection
 
 // retrieve based on position
 $result = mysqli_query($conn,"SELECT * FROM tbCandidates WHERE candidate_position='$position'")
 or die(" There are no records at the moment ... \n"); 
 
 // redirect back to vote
 //header("Location: vote.php");
 }
 else
 // do something
  
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Election commission of India:Voting Page</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="user_styles.css" rel="stylesheet" type="text/css" />
<link href="css/user_styles.css" rel="stylesheet" type="text/css" />   
<script language="JavaScript" src="js/user.js">
</script>
<style>
  #footer{
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
  }
  .contain{
    justify-content: center;
    align-items: center;
    margin-left:5%;
    margin-right:5%;
  }
</style>
<script type="text/javascript">
function getVote(int)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

	if(confirm("Your vote is for "+int))
	{
	xmlhttp.open("GET","save.php?vote="+int,true);
	xmlhttp.send();
	}
	else
	{
	alert("Choose another candidate ");	
	}
	
}

function getPosition(String)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

xmlhttp.open("GET","vote.php?position="+String,true);
xmlhttp.send();
}
</script>
<script type="text/javascript">
$(document).ready(function(){
   var j = jQuery.noConflict();
    j(document).ready(function()
    {
        j(".refresh").everyTime(1000,function(i){
            j.ajax({
              url: "admin/refresh.php",
              cache: false,
              success: function(html){
                j(".refresh").html(html);
              }
            })
        })
        
    });
   j('.refresh').css({color:"green"});
});
</script>
</head>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Election commission of India</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
      <li><a href="vote.php">Current polls</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
<div class="contain">
<div class="w3-display-container w3-center w3-light-grey" id="inst">
  <div>
  <table width="420" align="center">
  <form name="fmNames" id="fmNames" method="post" action="vote.php" onSubmit="return positionValidate(this)">
  <tr>
      <td style="padding-top: 20px;">Choose Position</td>
      <td style="padding-top: 20px;"><SELECT NAME="position" id="position" onclick="getPosition(this.value)">
      <OPTION VALUE="select">select
      <?php 
      //loop through all table rows
      while ($row=mysqli_fetch_array($positions)){
      echo "<OPTION VALUE=$row[position_name]>$row[position_name]"; 
      //mysqli_free_result($positions_retrieved);
      //mysqli_close($link);
      }
      ?>
      </SELECT></td>
      <td style="padding-top: 20px;"><input type="submit" name="Submit" value="See Candidates" /></td>
  </tr>
  <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
  </tr>
  </form> 
  </table>
  <table width="270" align="center">
  <form>
  <tr>
      <th>Candidates:</th>
  </tr>
  <?php
  //loop through all table rows
  //if (mysqli_num_rows($result)>0){
    if (isset($_POST['Submit']))
    {
  while ($row=mysqli_fetch_array($result)){
  echo "<tr>";
  echo "<td>" . $row['candidate_name']."</td>";
  echo "<td><input type='radio' name='vote' value='$row[candidate_name]' onclick='getVote(this.value)' /></td>";
  echo "</tr>";
  }
  mysqli_free_result($result);
  mysqli_close($conn);
  //}
    }
  else
  // do nothing
  ?>
  <tr>
      <h3>NB: Click a circle under a respective candidate to cast your vote. You can't vote more than once in a respective position. This process can not be undone so think wisely before casting your vote.</h3>
      <td>&nbsp;</td>
  </tr>
  </form>
  </table>
  </div>
</div>
</div>
<div class="w3-display-container w3-light-grey" id="footer"> 
  <div class="bottom_addr">&copy; 2018 Election commission of India. All Rights Reserved</div>
</div>
</div>
</body>
</html>