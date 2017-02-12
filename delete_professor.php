<?php # edit_department.php

$page_title = 'Delete the Professor';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$prof_id="";
$prof_fname="";
$prof_lname="";
$prof_cabin="";
$prof_email="";


# GET METHOD: then retireve and populate
if ( (isset($_GET['prof_id'])) && (is_numeric($_GET['prof_id'])) )  // Already been determined., Assign to populate
	{ 
	
	$prof_id = $_GET['prof_id'];

	// Retrieve the dept's information which we clicked to delete.
	$query = "SELECT prof_id,prof_fname,prof_lname, prof_cabin, prof_email
			  FROM  professors 
			  WHERE prof_id=$prof_id";
			  
	$result = @mysqli_query ($dbc, $query); // Run the query.

	if (mysqli_num_rows($result) == 1) { // Valid dept ID, then only show the form.

		// Get the dept's information.
		$row = mysqli_fetch_array ($result, MYSQL_ASSOC);
		$prof_fname=$row['prof_fname'];
		$prof_lname=$row['prof_lname'];
		$prof_cabin=$row['prof_cabin'];
		$prof_email=$row['prof_email'];
		}
	else { // Not a valid dept ID.
		echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error. Not a valid Professor ID .</p><p><br /><br /></p>';
		}
	}

elseif ( (isset($_POST['prof_id'])) && (is_numeric($_POST['prof_id'])) ) //POST method
	{        
	$prof_id=$_POST['prof_id'];
	// perform delete 
	}
else 
	{ // No valid ID, kill the script.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error .</p><p><br /><br /></p>';
	exit();
	}
	

##IF FORM IS SUBMITTED: CHECK YES/NO SURE, THEN DELETE POST METHOD:
// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
		
			
			$query = "SELECT prof_fname, prof_lname
					 FROM professors
					 WHERE prof_id=$prof_id";	
					 
		   $result = @mysqli_query ($dbc, $query); // Run the query.
		   if (mysqli_num_rows($result) == 1) { // Valid Prof ID, show the result.

			// Get the dept information.  // for SUCCESS MESSAGES
			$row = mysqli_fetch_array ($result, MYSQL_ASSOC);

			$prof_fname=$row['prof_fname'];
			$prof_lname=$row['prof_lname'];
		   }
		   else { // Not a valid prof ID.
					echo '<h1 id="mainhead">Page Error</h1>
			<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
			}
			
			
	//Check if sure!
		if ($_POST['sure'] == 'Yes') { // Delete them.

			
			//query for deletion
			$query = "DELETE FROM professors WHERE prof_id=$prof_id";		
			$result_del = @mysqli_query ($dbc, $query); // Run the query.
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Get the movie information.
				$row = mysqli_fetch_array ($result, MYSQL_NUM);
			
				// Create the result page.
				echo '<h1 id="mainhead">Delete a Professor record</h1>
				<p>The professor <b>'.$prof_fname.'</b> <b> '.$prof_lname.'</b> has been deleted.</p><p><br /><br /></p>';
				echo'<p> <a href="view_professors.php">Go to View All Professors </a>';				
			} 
			else { // Did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The professor could not be deleted due to a system error.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
			}
		
		} // End of $_POST['sure'] == 'Yes' if().
		
		else  // Wasn't sure about deleting the professor.
		{ 
			echo '<h1 id="mainhead">Delete a Professor</h1>';

	
				echo'<p>The professor <b>'.$prof_fname.'</b> <b>'.$prof_lname.'</b> has NOT been deleted.</p><p><br /><br /></p>';	
				echo'<p> <a href="view_professors.php">Go to View All Professors </a>';


		} // End of wasn’t sure else().


}//if submitted section


	
// MAIN FORM	
if((isset($_GET['prof_id']))  && (is_numeric($_GET['prof_id'])) ){
	echo '<h2>Delete a professor</h2>
	<form action="delete_professor.php" method="post">
	<h3>First Name: ' . $prof_fname . '</h3>
	<h3>Last Name: ' . $prof_lname . '</h3>
	<h3>Cabin: ' . $prof_cabin. '</h3>
	<h3>E-Mail: ' . $prof_email . '</h3>
	
		
	
	
	
	<p>Are you sure you want to delete this Professor record?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	
	<p><input type="submit" name="submit" value="Submit!" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="prof_id" value="' . $prof_id . '" />  
	<p> <a href="view_professors.php">Go back to View All Professors </a>
	</form>';  //??hidden??
	
	
}


?>