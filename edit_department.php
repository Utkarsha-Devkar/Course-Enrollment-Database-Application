<?php # edit_department.php

$page_title = 'Edit the department';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$dept_id="";
$dept_name="";
$dept_year="";
$univ_id="";
$mail_office_id="";


# GET METHOD: then retireve and populate
if ( (isset($_GET['dept_id'])) && (is_numeric($_GET['dept_id'])) )  // Already been determined., Assign to populate
	{ 
	
	$dept_id = $_GET['dept_id'];

	// Retrieve the department's information which we clicked to edit.
	$query = "SELECT dept_id,dept_name,dept_year, univ_id, mail_office_id
				FROM departments WHERE dept_id=$dept_id";		
	$result = @mysqli_query ($dbc, $query); // Run the query.

	if (mysqli_num_rows($result) == 1) { // Valid department ID, then only show the form.

		// Get the course's information.
		$row = mysqli_fetch_array ($result, MYSQL_ASSOC);
		$dept_name=$row['dept_name'];
		$dept_year=$row['dept_year'];
		$univ_id=$row['univ_id'];
		$mail_office_id=$row['mail_office_id'];
		}
	else { // Not a valid Department ID.
		echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error. Not a valid Department ID.</p><p><br /><br /></p>';
		}
	}

elseif ( (isset($_POST['dept_id'])) && (is_numeric($_POST['dept_id'])) ) //POST method
	{        
	$dept_id=$_POST['dept_id'];
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
if (isset($_POST['submitted'])) {                       //Ask????????????

	$errors = array(); // Initialize error array.
	
	// Check for a Dept name.
	if (empty($_POST['dept_name'])) {
		$errors[] = 'You forgot to enter the name of the department.';
	} else {
		$dept_name = $_POST['dept_name'];
	}
	
	// Check for dept year
	if (empty($_POST['dept_year'])) {
		$errors[] = 'You forgot to enter the year of the department.';
	} else {
		
		if(is_numeric($_POST['dept_year']))
		{
		$dept_year = $_POST['dept_year'];
		}
	
		else
		{
		$dept_year = $_POST['dept_year'];
		$errors[] = 'You entered a non-numeric value for the year.';
		}
		
	}
		
	// Check for a University Name.
	if (empty($_POST['univ_id'])) {
		$errors[] = 'You forgot to select University Name.';
	} else {
		$univ_id = $_POST['univ_id'];
	}
	
	
	// Check for contact- mail.
	if (empty($_POST['mail_office_id'])) {
		$errors[] = 'You forgot to select the contact- mail.';
	} else {
		$mail_office_id = $_POST['mail_office_id'];
	}
	
	//if no errors in the vlaues selected, updation of the entries
	if (empty($errors)) { // If everything's OK.
	
	
			// Make the query.
			$query = "UPDATE departments SET dept_name='$dept_name', dept_year='$dept_year', univ_id=$univ_id, mail_office_id=$mail_office_id WHERE dept_id = $dept_id";   
			$result = @mysqli_query ($dbc, $query); // Run the query.
			// If query ran OK.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
			
				// Print a message.
				echo '<h1 id="mainhead">Edit the Department Details</h1>
				<p>The Department record has been edited.</p><p><br /><br /></p>';	
							
			} else { // If query did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The department could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

	echo "<h2>Edit Department Details</h2>
		<form action='edit_department.php' method='post'>
		<p>Department Name: <input type='text' name='dept_name' size='35' maxlength='35' value='";  //DEPT NAME
		if (isset($dept_name))
		{
			echo $dept_name;  //to make it sticky
		}	 
	
	echo "'>";
		
	echo "<p>Department Year: <input type='text' name='dept_year' size='35' maxlength='4' value='"; // DEPT YEAR
			if (isset($dept_year))
		{
			echo $dept_year;  //to make it sticky
		}	 
	
	echo "'> <i>#4 digits</i>";
		

		
	echo "<p>University Name: <select name='univ_id'>";  //UNIVERSITY NAMES
		// Build the query for department names drop-down
		$query = "SELECT univ_id, univ_name FROM universities ORDER BY univ_name ASC";
		$result = @mysqli_query ($dbc, $query);
		if ($result)
		{
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			if ($row['univ_id'] == $univ_id) 
			{
			echo '<option value="' .$row['univ_id']. '" selected="selected">' . $row['univ_name'] . '</option>';
			}
			else 
			{
			echo '<option value="' .$row['univ_id']. '" >' . $row['univ_name'] . '</option>';
			}   
		}
	echo '</select> </p>';
		}
		else{
			echo "no results";
		}
		
	echo "<p>Contact Mail: <select name='mail_office_id'>";  //MAIL OFFICE NAMES
		// Build the query for contact-mail names drop-down
		$query = "SELECT office_id, contact_mail FROM mailoffice ORDER BY contact_mail ASC";
		$result = @mysqli_query ($dbc, $query);
		if ($result)
		{
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			if ($row['office_id'] == $mail_office_id) 
			{
			echo '<option value="' .$row['office_id']. '" selected="selected">' . $row['contact_mail'] . '</option>';
			}
			else 
			{
			echo '<option value="' .$row['office_id']. '" >' . $row['contact_mail'] . '</option>';
			}   
		}
	echo '</select> </p>';
		}
		else{
			echo "no results";
		}
		
		
		
	echo "<br/><input type='hidden' name='dept_id' value='".$dept_id."'>";	
	echo "<br/><input type='submit' value='Submit!'>";
	echo "<input type='hidden' name='submitted' value='TRUE' />";
	echo "<p> <a href='view_departments.php'>Go to View All Departments </a>";
	echo "</form>";
		
	


?>