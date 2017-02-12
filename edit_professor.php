<?php # edit_professor.php

$page_title = 'Edit the Professor Details';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$prof_fname="";
$prof_lname="";
$prof_cabin="";
$prof_email="";
$prof_id = "";

# GET METHOD: then retireve and populate
if ( (isset($_GET['prof_id'])) && (is_numeric($_GET['prof_id'])) )  // Already been determined., Assign to populate
	{ 
	
	$prof_id = $_GET['prof_id'];

	// Retrieve the professor's information which we clicked to edit.
	$query ="SELECT prof_id,prof_fname,prof_lname, prof_cabin, prof_email
			FROM professors 
			WHERE prof_id=$prof_id";		
	$result = @mysqli_query ($dbc, $query); // Run the query.

	if(!$result){
		echo "Result not found";
	}
		if (mysqli_num_rows($result) == 1) { // Valid Prof ID, then only show the form.
		

			// Get the prof's information.
			$row = mysqli_fetch_array ($result, MYSQL_ASSOC);
			$prof_fname=$row['prof_fname'];
			$prof_lname=$row['prof_lname'];
			$prof_cabin=$row['prof_cabin'];
			$prof_email=$row['prof_email'];
			}
		else { // Not a valid Professor ID.
			echo '<h1 id="mainhead">Page Error</h1>
			<p class="error">This page has been accessed in error. Not a valid professor ID.</p><p><br /><br /></p>';
			}
	}	

	elseif ( (isset($_POST['prof_id'])) && (is_numeric($_POST['prof_id'])) ) //POST method
	{        
	$prof_id=$_POST['prof_id'];
	//update 
	}
	
	else 
	{ // No valid ID, kill the script.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
	exit();
	}
	

##IF FORM IS SUBMITTED: CHECK ERRORS, IF NONE THEN UPDATE
// Check if the form has been submitted.
if (isset($_POST['submitted'])) {

	$errors = array(); // Initialize error array.
	
	// Check for first name.
	if (empty($_POST['prof_fname'])) {
		$errors[] = 'You forgot to enter the first name of the professor.';
	} else {
		$prof_fname = $_POST['prof_fname'];
	}
	
	// Check for last name
	if (empty($_POST['prof_lname'])) {
		$errors[] = 'You forgot to enter the last name of the professor.';
	} else {
		$prof_lname = $_POST['prof_lname'];
	}
	
	
	// Check for a cabin.
	if (empty($_POST['prof_cabin'])) {
		$errors[] = 'You forgot to enter the cabin for the professor.';
	} else {
		$prof_cabin = $_POST['prof_cabin'];
	}
	
	
	// Check for professor email.
	if (empty($_POST['prof_email'])) {
		$errors[] = 'You forgot to enter the email of the professor.';
	} else {
		$prof_email = $_POST['prof_email'];
	}
	
	//if no errors in the vlaues selected, updation of the entries
	if (empty($errors)) { // If everything's OK.
	
	
			// Make the query.
			$query = "UPDATE professors SET prof_fname='$prof_fname', prof_lname='$prof_lname', prof_cabin='$prof_cabin', prof_email='$prof_email'
			WHERE prof_id = $prof_id";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			// If query ran OK.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
			
				// Print a message.
				echo '<h1 id="mainhead">Edit a Professor Details</h1>
				<p>The Professor record has been edited.</p><p><br /><br /></p>';	
							
			} else { // If query did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The professor details could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
				exit();
			}
				
	}	// End of if (empty($errors)) IF.
	else {  // Report the errors.
	
		echo '<h1 id="mainhead">Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		} // End of foreach
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	}  // End of report errors else()

}//if submitted section


	
// MAIN FORM	

	echo "<h2>Edit Professor Details</h2>
		<form action='edit_professor.php' method='post'>
		<p>First Name: <input type='text' name='prof_fname' size='35' maxlength='35' value='".$prof_fname."'><br/> ";
		
	echo "<p>Last Name: <input type='text' name='prof_lname' size='35' maxlength='35' value='".$prof_lname."'><br/> ";
	
	echo "<p>Cabin: <input type='text' name='prof_cabin' size='35' maxlength='35' value='".$prof_cabin."'><i>#'HallName_Number' format</i> . <br/> ";	
	
	echo "<p>Email Address: <input type='text' name='prof_email' size='35' maxlength='35' value='".$prof_email."'><br/> ";	
	
	echo "<br/><input type='hidden' name='prof_id' value='".$prof_id."'>";	
	echo "<br/><input type='submit' value='Submit!'>";
	echo "<input type='hidden' name='submitted' value='TRUE' />";
	echo'<p> <a href="view_professors.php">Go back to View All Professors </a>';
	
	echo "</form>";
		
	


?>