<?php # add_section.php  

$page_title = 'Add a section';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$section_code="";
$year="";
$semester="";
$course_id="";
$prof_id="";
$course_title="";
#  DO NOT USE $section_id = "";

#NO GET METHOD

	// Check for a Course name (Not Required).
	if (!empty($_GET['course_id'])) {
		$course_id = $_GET['course_id'];
	}
	

##IF FORM IS SUBMITTED: CHECK ERRORS, IF NONE THEN ADD THE NEW DEPARTMENT
// Check if the form has been submitted.  // ????DOES it have to be one parameter like 'course_title' or the 'submit' tag is fine, 
											//double-checking here??? see 'add_movie'
if (isset($_POST['submitted'])) {  
		
						  
	// Initialize error array.
	$errors = array(); 
	
	// Check for a department name.
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
	
	if (empty($_POST['semester'])) {
		$errors[] = 'You forgot to enter the semester of the section.';
	} else {
		$semester = $_POST['semester'];
	}
	
	// Check for department year  //check for numeric
	if (empty($_POST['year'])) {
		$errors[] = 'You forgot to enter the year of availability of the section.';
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
	
	
	// Check for a Course name (Not Required).
	if (empty($_POST['course_id'])) {
		$errors[] = 'You forgot to select Course of the section.';
	} else {
		$course_id = $_POST['course_id'];
	}
	

	
	
	// Check for Professor Name. (Not Required).
	if (empty($_POST['prof_id'])) {
		$errors[] = 'You forgot to select the Professor for the section.';
	} else {
		$prof_id = $_POST['prof_id'];
	}
	
	
	#Get the Department details: for SUCCESS MESSAGE
		$query = "SELECT  c.course_id, course_code, course_title, p.prof_id, CONCAT(prof_fname, ' ', prof_lname) as prof_name
				  FROM  professors p, courses c, sections 
				  WHERE c.course_id = $course_id AND p.prof_id = $prof_id";

		$result = @mysqli_query ($dbc, $query);
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
			{
				$course_code=$row['course_code']; 
				$course_title=$row['course_title']; 
				$prof_name=$row['prof_name']; 
		// they will be used as part of the success message
			}
	
	
	//if no errors in the vlaues selected, updation of the entries
	if (empty($errors)) { // If everything's OK.
	
	
			// Make the query.
			$query = "INSERT INTO sections (section_code, year, semester, course_id, prof_id) 
					 VALUES ('$section_code','$year', '$semester', '$course_id', '$prof_id')";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			// If query ran OK.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
			
				// Print a message.
				 echo '<h1>Success!</h1>
						<p>You have added following section to the course: <b>'.$course_code.'</b> titled <b> '.$course_title.'</b></p>';
						
				echo "<table>
				<tr><td>Section Code:</td><td>$section_code</td></tr>
				<tr><td>Year(Availability):</td><td>$year</td></tr>
				<tr><td>Semester:</td><td>$semester</td></tr>
				<tr><td>Course Code:</td><td>$course_code</td></tr>
				<tr><td>Professor Name:</td><td>$prof_name</td></tr>
			</table>";
			echo '<p> <a href="add_section.php">Go back to Add a Section </a>';
							
			} 
			else { // If query did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The section could not be added due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

	echo "<h2>Add a section</h2>
		<form action='add_section.php' method='post'>
		<p>Section Code: <input type='text' name='section_code' size='35' maxlength='4' value='";  //SECTION CODE
		if (isset($section_code))
		{
			echo $section_code;  //to make it sticky
		}	 
	
	echo "'> <i> 4digits</i></p>

	
	<p>Year of Availability: <input type='text' name='year' size='35' maxlength='4' value='";  // YEAR
	if (isset($year))
		{
			echo $year;  //to make it sticky
		}	 
	
	echo "'>";
	
	echo "<p>Semester of Availability: <input type='text' name='semester' size='35' maxlength='35' value='";  // SEMESTER
	if (isset($semester))
		{
			echo $semester;  //to make it sticky
		}	 
	
	echo "'> <i>(Spring,Summer,Fall,Winter)</i>";

	echo "<p>Course Code : <select name='course_id'>";  //COURSE CODE
		// Build the query for department names drop-down
		$query = "SELECT course_id, course_code  FROM courses ORDER BY course_code ASC";
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
	echo '</select>&nbsp;&nbsp;&nbsp;<a href="add_course.php">Add a new Course</a> </p>';
		}
		else{
			echo "no results";
		}
		
	echo "<p>Professor Name: <select name='prof_id'>";  //CONTACT MAIL NAMES
		// Build the query for department names drop-down
		$query = "SELECT prof_id, CONCAT(prof_fname, ' ', prof_lname) as prof_name FROM professors ORDER BY prof_name ASC";  //
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
	echo '</select>&nbsp;&nbsp;&nbsp;<a href="add_professor.php">Add a new Professor</a> </p>';
		}
		else{
			echo "no results";
		}
		
		
	#echo "<br/><input type='hidden' name='course_id' value='".$course_id."'>";	
	echo "<br/><input type='submit' name= 'submitted' value='Add Section!'>";
	
	
	
	#echo "<input type='hidden' name='submitted' value='TRUE' />";
	#echo "<p> <a href=''>Add a section to the course </a>";
	echo "</form>";
}	
	echo '<p><a href="view_courses.php">Go back to View all Courses</a>';


?>