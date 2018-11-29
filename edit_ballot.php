<!--- 
Name: edit_ballot.php
Author:	kelly ramm kelly_ramm@hboe.org
Description: Edit a ballot
Created: 11/2018
--->

<!--- Force the user to log in --->
<?php
	// Start the session
	session_start();
	
	//check if user is logged in
include('forceAdminLogin.php');	
//check if user isadmin
	if (!isset($_SESSION["userType"]) || $_SESSION["userType"] != "admin"){
		// Redirect to ballot manager page
                header("location: ballot_manager.php");
				exit;	
	
	} else {
		require( 'inc/utils.php' );
		// Connect to database
		require( 'inc/db.php' );
		//Verify that a ballot ID is included in URL --->
		if (isset($_GET['ID']) && is_numeric($_GET['ID'])) {
	 		$_SESSION["ballotID"] = $_GET['ID'];
			
		}
		if (!isset($_SESSION["ballotID"])){
			header("location: ballot_manager.php");
		}
		// Delete a Ballot --->
		if (isset($_SESSION["ballotID"]) && isset($_POST["Delete"])){
		//delete QUERIES HERE
			
		//DELETE	
		header("location: ballot_manager.php");
		}
	
    	//  Update Ballot --->

		if (isset($_POST["MM_UpdateRecord"]) && $_POST["MM_UpdateRecord"] = "Editballot"){

				//edit ballot
  		header("location: ballot_manager.php");
		}
		//  END  Update Ballot --->
		
		//  Query Ballot Details --->
		$sql = "SELECT * FROM ballot_ballots WHERE ballotID = '" . $_SESSION['ballotID'] . "'"; 
					if($result = mysqli_query($conn, $sql))
                    {
						
						if (mysqli_num_rows($result) == 1) 
                        {
?>    
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->
<!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">    
    
</head>

<body>
    <h2>EDIT BALLOT</h2>
    <div class="container"></div>
	 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" name="EditBallot" id="EditBallot">
		  <table width="90%" border="0" cellspacing="0" cellpadding="0" class="table table-striped">
            <?php 
                         //display ballot info
							while($row = mysqli_fetch_assoc($result)) 
                            {
                                $startDate = date_format(new DateTime($row["ballotStartDate"]),'m-d-Y');
                                $endDate = date_format(new DateTime($row["ballotEndDate"]),'m-d-Y');
                                if ($row["ballotLive"])
                                {
                                    $liveStatus = "checked";
                                } else
                                {
                                    $liveStatus = "";
                                }
                                ///*********************need to output correct info in form to edit ballot 
                                    echo "<tr>
                                            <th>Ballot Title</th>
                                            <td><input name='ballotTitle' type='text' value='". $row["ballotName"] . "' size='40' /></td></tr>"; 
                                echo "<tr>
                                        <th>Ballot Start Date</th>
                                        <td><input name='ballotStartDate' type='text' value='" . $startDate . "' size='18'/>
                                        </td></tr>";
                                echo "<tr>
                                        <th>Ballot End Date</th>
                                        <td><input name='ballotEndDate' type='text'  value='". $endDate ."' size='18' />
                                        </td> </tr>";
                                echo " <tr>
                                        <th>Contact Name</th>
                                        <td><input name='ballotContactName' type='text' value='" .$row["ballotContactName"] . "' size='40' />
                                        </td></tr>";
                                echo "<tr>
                                        <th>Contact eMail</th>
                                        <td><input name='ballotContactEmail' type='text' value='" .$row["ballotContactEmail"] . "' size='40' />
                                        </td></tr>
                                    <tr>
                                        <th>Introduction Message</th>
                                        <td><textarea name='ballotIntroductionMessage' cols='40' rows='5'>" . $row["ballotIntroMessage"] . "</textarea>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th>Completion Message</th>
                                        <td><textarea name='ballotCompletionMessage' cols='40' rows='5'>" . $row["ballotCompleteMessage"] . "</textarea> 
                                        </td> </tr>
                                    <tr>
                                        <th>Ballot Live</th>
                                        <td><input " .  $liveStatus  . "name='ballotStatus' type='checkbox' value='ballotStatus' />
                                        </td></tr>
                                    <tr>
                                        <td colspan='2'>
                                            <input name='Updateballot' type='submit' id='Updateballot' value='Update' /> 
                                            <input name='DeleteResults' type='submit' id='DeleteResults' value='Delete Results' />
                                            <input name='Delete' type='submit' id='Delete' value='Delete ALL Results and This Ballot' />
                                        </td></tr>";
                                ?>
                                        <input type="hidden" name="MM_UpdateRecord" value="Editballot">
         </table>
    </form>
    <?php } 
         } else {
                        echo "<h2>No results</h2>";
                }
                } else
                    {
                        echo "</br> conncection error </br>";
                        echo $sql;
                    }
        
    ?>
                     <?php
                            echo "<h2>EDIT VOTERS</h2>
                                        <table width='100%' border='0' cellpadding='0' cellspacing='0' class='table'>
                                            <tr>
                                                <th>Current Voters</th>
                                                <td><h5>" . $row["recordCount"] . " Total Voters</h5></td>
                                            </tr>
                                            <form action='add_voters.php' method='POST' name='addVoters' id='addVoters' enctype='multipart/form-data'>
                                                <tr>
                                                    <th>View</th>
                                                    <td>         
                                                     <input name='link' type='button' value='View Voters' onClick='MM_goToURL('parent','voter_list.cfm?ID=" . $_SESSION["ballotID"] . " ')' />

                                                   </td>
                                                </tr>
                                                <tr>
                                                    <th>Delete</th>
                                                    <td><input type='submit' name='voterDelete' id='voterDelete' value='Delete All Voters' /> 
                                                              <br>
                                                    <span style='font-size: 75%; line-height:1.125em;'>[ NOTE: deleting all voters will not delete any votes already placed. ]</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Add</th>
                                                    <td> 
                                                        <input type='file'  name='upload_file'  />     
                                                       <label>
                                                           <input type='submit' name='add' id='add' value='Add' />
                                                        </label>
                                                       <p><br />
                                                              <span style='font-size: 75%; line-height:1.125em;'>To add voters from a file: <br />
                                                                  1. Create a .csv file in excel. <br />
                                                                  2. File should contain 2 Columns: <strong>Student ID and Last Name</strong>.<br />
                                                                  3. Remove Column Labels </span><span style='font-size: 75%; line-height:1.125em;'><br />
                                                                    <a href='SamplevotersFile.csv'>View Sample File</a></span></p>
                                                      </td>
                                                </tr>
                                            </form>
                                        </table>";
        ?>
        <?php 
        // query ballot positions ---->
            $sql2 = "SELECT * FROM ballot_positions INNER JOIN ballot_position_type ON ballot_positions.positionTypeID = ballot_position_type.positionTypeID WHERE positionBallotID = '" . $_SESSION['ballotID'] . "'";
            if($positionsResult = mysqli_query($conn, $sql2))
            {
            ?>
    <h2>EDIT POSITIONS</h2>
          <table width='90%'  cellpadding='0' cellspacing='0' class='table' >
            <tr>
              <th width='70%'  align='center'>Ballot Position</th>
              <th width='30%'  align='center'>Position Type</th>
            </tr>
            <tr>
              <td colspan='2' >&nbsp;</td>
            </tr>
              
              <?php 
                         //display ballot info
							while($row2 = mysqli_fetch_assoc($positionsResult)) 
                            {
                                echo "
                                  <tr>
                                      <td width='70%'  height='20'><a href='edit_position.cfm?ID=" . $row2["positionID"] . "'>" . $row2["positionText"] . "</a></td>
                                      <td width='30%' align='center'>" . $row2["positionTypeID"] . "
                                      </td></tr>";
                            }?>
                              <?php 
                echo "
                                  <tr>
                                    <td colspan='2'>
                                    <form  name='addPosition' id='addPosition'>
                                    <input name='AddNewPosition' type='button' id='AddNewPosition' onClick='MM_goToURL('parent','add_position.php?ID=" . $_SESSION["ballotID"] . "]');return document.MM_returnValue' value='Add New Position'> 
                                    </form>
                                    </td>
                                    </tr>
                                  </table>
                                        ";
                                        ?>
         <?php       
                
            } else
                    {
                        echo "</br> SQL 2 conncection error </br>";
                        echo $sql2;
                    }
    }
				
	?>		
              
              
              
              
            
        
    </div>	 
</body>
	<script src="js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>	
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
  <script src="js/plugins.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>

</html>
