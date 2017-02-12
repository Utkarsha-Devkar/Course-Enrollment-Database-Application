<?php # add_professor.php  

$page_title = 'Add a Professor';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$prof_fname="";
$prof_lname="";
$prof_cabin="";
$prof_email="";
#  DO NOT USE $prof_id = "";

#NO GET METHOD

	

##IF FORM IS SUBMITTED: CHECK ERRORS, IF NONE THEN ADD THE NEW PROFESSOR
// Check if the form has been submitted.  
if (isset($_POST['submitted'])) {  //??submitted or some field name??

						  
	// Initialize error array.
	$errors = array(); 
	
	// Check for first name.
	if (empty($_POST['prof_fname'])) {
		$errors[] = 'You forgot to enter the first name of the Professor.';
	} else {
		$prof_fname = $_POST['prof_fname'];
	}
	
	// Check for last name
	if (empty($_POST['prof_lname'])) {
		$errors[] = 'You forgot to enter the last name of the Professor.';
	} else {
		$prof_lname = $_POST['prof_lname'];
	}
	
	
	// Check for a Cabin 
	if (empty($_POST['prof_cabin'])) {
		$errors[] = 'You forgot to enter the cabin details of the Professor.';
	} else {
		$prof_cabin = $_POST['prof_cabin'];
	}
	
	
	// Check for Prof E-Mail. 
	if (empty($_POST['prof_email'])) {
		$errors[] = 'You forgot to enter the e-mail of the Professor.';
	} else {
		$prof_email = $_POST['prof_email'];
	}
	
	
	
	
	//if no errors in the vlaues selected, updation of the entries
	if (empty($errors)) { // If everything's OK.
	
	
			// Make the query.
			$query = "INSERT INTO professors (prof_fname, prof_lname, prof_cabin, prof_email) 
					 VALUES ('$prof_fname','$prof_lname', '$prof_cabin', '$prof_email')";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			// If query ran OK.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
			
				// Print a message.
				 echo '<h1>Success!</h1>
						<p>You have added:</p>';
						
				echo "<table>
				<tr><td>Professor First Name:</td><td>$prof_fname</td></tr>
				<tr><td>Professor Last Name:</td><td>$prof_lname</td></tr>
				<tr><td>Professor Cabin:</td><td>$prof_cabin</td></tr>
				<tr><td>Professor E-Mail:</td><td>$prof_email</td></tr>
			</table>";
			echo '<p> <a href="add_professor.php">Go back to Add a Professor </a>';
							
			} 
			else { // If query did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The professor could not be added due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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
	if(!(isset($_POST['submitted'])&&empty($errors))){	

	echo "<h2>Add a Professor</h2>
		<form action='add_professor.php' method='post'>
		<p>Professor First Name: <input type='text' name='prof_fname' size='35' maxlength='35' value='";  //FIRST NAME
		if (isset($prof_fname))
		{
			echo $prof_fname;  //to make it sticky
		}	 
	
	echo "'></p>

	<p>Professor Last Name: <input type='text' name='prof_lname' size='35' maxlength='35' value='";  // LAST NAME
	if (isset($prof_lname))
		{
			echo $prof_lname;  //to make it sticky
		}	 
	
	echo "'>";
	
	echo"<p>Professor Cabin: <input type='text' name='prof_cabin' size='35' maxlength='35' value='";  // CABIN
	if (isset($prof_cabin))
		{
			echo $prof_cabin;  //to make it sticky
		}	 
	
	echo "'> <i>#'HallName_Number' format</i> . <br/> ";
	
	echo"<p>Professor E-Mail: <input type='text' name='prof_email' size='35' maxlength='35' value='";  // EMAIL
	if (isset($prof_email))
		{
			echo $prof_email;  //to make it sticky
		}	 
	
	echo "'>";

		
	#echo "<br/><input type='hidden' name='course_id' value='".$course_id."'>";	
	echo "<p><input type='submit' name= 'submitted' value='Add Professor!'>";
	#echo "<input type='hidden' name='submitted' value='TRUE' />";
	
	echo "</form>";
	}		
echo' <p><a href="view_professors.php">Go to View All Professors </a>&nbsp;&nbsp;&nbsp;<a href="main_index.php">Go back to Main Menu </a>';	


?>