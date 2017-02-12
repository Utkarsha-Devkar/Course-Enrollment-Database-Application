<?php # edit_section.php

$page_title = 'Edit the course';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$section_id="";
$section_code="";
$year="";
$semester="";
$course_id="";
$prof_id="";


# GET METHOD: then retireve and populate
if ( (isset($_GET['section_id'])) && (is_numeric($_GET['section_id'])) )  // Already been determined., Assign to populate
	{ 
	
	$section_id = $_GET['section_id'];

	// Retrieve the section's information which we clicked to edit.
	$query = "SELECT section_id,section_code,year, semester, course_id,prof_id
				FROM sections WHERE section_id=$section_id";		
	$result = @mysqli_query ($dbc, $query); // Run the query.

	if (mysqli_num_rows($result) == 1) { // Valid section ID, then only show the form.

		// Get the section's information.
		$row = mysqli_fetch_array ($result, MYSQL_ASSOC);
		$section_code=$row['section_code'];
		$year=$row['year'];
		$semester=$row['semester'];
		$course_id=$row['course_id'];
		$prof_id=$row['prof_id'];
		}
	else { // Not a valid Section ID.
		echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error. Not a valid Section ID.</p><p><br /><br /></p>';
		}
	}

elseif ( (isset($_POST['section_id'])) && (is_numeric($_POST['section_id'])) ) //POST method
	{        
	$section_id=$_POST['section_id'];
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
	
	// Check for a code.
	if (empty($_POST['section_code'])) {
		$errors[] = 'You forgot to enter the code of the section.';
	} else {
		
		if(is_numeric($_POST['section_code']))
		{
		$section_code = $_POST['section_code'];
		}
		else
		{
		$section_code = $_POST['section_code'];
		$errors[] = 'You entered a non-numeric value for the code.';
		}	
	}
	
	// Check for year
	if (empty($_POST['year'])) {
		$errors[] = 'You forgot to enter the year of avaialability of the section.';
	} else {
		if(is_numeric($_POST['year']))
		{
		$year = $_POST['year'];
		}
	
		else
		{
		$year = $_POST['year'];
		$errors[] = 'You entered a non-numeric value for the year.';
		}	
	}
	
	
	// Check for a semester.
	if (empty($_POST['semester'])) {
		$errors[] = 'You forgot to select semester of availability of the section.';
	} else {
		$semester = $_POST['semester'];
	}
	
	
	// Check for course name.  (Not Required)
	if (empty($_POST['course_id'])) {
		$errors[] = 'You forgot to select the course name.';
	} else {
		$course_id = $_POST['course_id'];
	}
	
	// Check for Professor name.  (Not Required)
	if (empty($_POST['prof_id'])) {
		$errors[] = 'You forgot to select the Professsor name.';
	} else {
		$prof_id = $_POST['prof_id'];
	}
	
	//if no errors in the vlaues selected, updation of the entries
	if (empty($errors)) { // If everything's OK.
	
	
			// Make the query.
			$query = "UPDATE sections SET section_code='$section_code', year='$year', semester='$semester', course_id=$course_id, prof_id=$prof_id
			WHERE section_id = $section_id";    
			$result = @mysqli_query ($dbc, $query); // Run the query.
			// If query ran OK.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
			
				// Print a message.
				echo '<h1 id="mainhead">Edit the Section Details</h1>
				<p>The Section record has been edited.</p><p><br /><br /></p>';	
				
							
			} else { // If query did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The section could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

	echo "<h2>Edit Section Details</h2>
		<form action='edit_section.php' method='post'>
		<p>Section Code: <input type='text' name='section_code' size='35' maxlength='4' value='";  //SECTION CODE
		if (isset($section_code))
		{
			echo $section_code;  //to make it sticky
		}	 
	
	echo "'> <i> 4digit number </i>";
	
	echo "<p>Semester of Availability: <input type='text' name='semester' size='35' maxlength='35' value='"; // SEMESTER
			if (isset($semester))
		{
			echo $semester;  //to make it sticky
		}	 
	
	echo "'> <i>(Spring, Summer,Fall,Winter)</i>";
		
	echo "<p>Year: <input type='text' name='year' size='35' maxlength='4' value='"; // YEAR
			if (isset($year))
		{
			echo $year;  //to make it sticky
		}	 
	
	echo "'> <i>#4 digits</i>";
		

		
	echo "<p>Course Code: <select name='course_id'>";  //COURSE code
		// Build the query for COURSE names drop-down
		$query = "SELECT course_id, course_code FROM courses ORDER BY course_code ASC";
		$result = @mysqli_query ($dbc, $query);
		if ($result)
		{
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			if ($row['course_id'] == $course_id) 
			{
			echo '<option value="' .$row['course_id']. '" selected="selected">' . $row['course_code'] . '</option>';
			}
			else 
			{
			echo '<option value="' .$row['course_id']. '" >' . $row['course_code'] . '</option>';
			}   
		}
	echo '</select> </p>';
		}
		else{
			echo "no results";
		}
		
	echo "<p>Teaching Professor: <select name='prof_id'>";  //PROFESSOR NAMES
		// Build the query for contact-mail names drop-down
		$query = "SELECT prof_id, CONCAT(prof_fname, ' ', prof_lname) as prof_name
				 FROM professors ORDER BY prof_name ASC";
		$result = @mysqli_query ($dbc, $query);
		if ($result)
		{
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			if ($row['prof_id'] == $prof_id) 
			{
			echo '<option value="' .$row['prof_id']. '" selected="selected">' . $row['prof_name'] . '</option>';
			}
			else 
			{
			echo '<option value="' .$row['prof_id']. '" >' . $row['prof_name'] . '</option>';
			}   
		}
	echo '</select> </p>';
		}
		else{
			echo "no results";
		}
		
		
		
	echo "<br/><input type='hidden' name='section_id' value='".$section_id."'>";	
	echo "<br/><input type='submit' value='Submit!'>";
	echo "<input type='hidden' name='submitted' value='TRUE' />";
	#echo "<p> <a href=''>Add a section to the course </a>";
	echo "<p> <a href='view_courses.php'>Go back to View all Courses </a>";
	echo "</form>";
		
	


?>