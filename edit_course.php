<?php # edit_course.php

$page_title = 'Edit the course';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$course_code="";
$course_title="";
$course_credits="";
$dept_id="";
$course_id = "";

# GET METHOD: then retireve and populate
if ( (isset($_GET['course_id'])) && (is_numeric($_GET['course_id'])) )  // Already been determined., Assign to populate
	{ 
	
	$course_id = $_GET['course_id'];

	// Retrieve the course's information which we clicked to edit.
	$query = "SELECT course_id,course_code,course_title, course_credits, dept_id
				FROM courses WHERE course_id=$course_id";		
	$result = @mysqli_query ($dbc, $query); // Run the query.

	if (mysqli_num_rows($result) == 1) { // Valid course ID, then only show the form.

		// Get the course's information.
		$row = mysqli_fetch_array ($result, MYSQL_ASSOC);
		$course_code=$row['course_code'];
		$course_title=$row['course_title'];
		$course_credits=$row['course_credits'];
		$dept_id=$row['dept_id'];
		}
	else { // Not a valid course ID.
		echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error. Not a valid course ID.</p><p><br /><br /></p>';
		}
	}

elseif ( (isset($_POST['course_id'])) && (is_numeric($_POST['course_id'])) ) //POST method
	{        
	$course_id=$_POST['course_id'];
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
	
	// Check for a code.
	if (empty($_POST['course_code'])) {
		$errors[] = 'You forgot to enter the code of the course.';
	} else {
		$course_code = $_POST['course_code'];
	}
	
	// Check for course title
	if (empty($_POST['course_title'])) {
		$errors[] = 'You forgot to enter the title of the course.';
	} else {
		$course_title = $_POST['course_title'];
	}
	
	
	// Check for a course_credits.
	if (empty($_POST['course_credits'])) {
		$errors[] = 'You forgot to enter the number of credits for the course.';
	} else {
		$course_credits = $_POST['course_credits'];
	}
	
	
	// Check for department name.
	if (empty($_POST['dept_id'])) {
		$errors[] = 'You forgot to enter the name of the department.';
	} else {
		$dept_id = $_POST['dept_id'];
	}
	
	//if no errors in the vlaues selected, updation of the entries
	if (empty($errors)) { // If everything's OK.
	
	
			// Make the query.
			$query = "UPDATE courses SET course_code='$course_code', course_title='$course_title', course_credits=$course_credits, dept_id=$dept_id WHERE course_id = $course_id";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			// If query ran OK.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
			
				// Print a message.
				echo '<h1 id="mainhead">Edit a 	Course</h1>
				<p>The course record has been edited.</p><p><br /><br /></p>';	
							
			} else { // If query did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The course could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

	echo "<h2>Edit Course Details</h2>
		<form action='edit_course.php' method='post'>
		<p>Course Code: <input type='text' name='course_code' size='35' maxlength='35' value='".$course_code."'><br/> ";
		
	echo "<p>Course Title: <input type='text' name='course_title' size='35' maxlength='35' value='".$course_title."'><br/> ";
		
	echo "<p>Course Credits: <select name = 'course_credits'>";  //COURSE_CREDITS	
				for($i=1; $i<=6;$i++)
				{
					if($course_credits == $i)
					{
						echo "<option selected = 'selected'>$i</option>";
					}else{
						echo "<option>$i</option>";
					}
				}
	echo "</select>";
		
	echo "<p>Department Name: <select name='dept_id'>";  //DEPARTMENT NAMES
		// Build the query for department names drop-down
		$query = "SELECT DEPT_ID as dept_id, DEPT_NAME as dept_name  FROM departments ORDER BY dept_name ASC";
		$result = @mysqli_query ($dbc, $query);
		if ($result)
		{
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			if ($row['dept_id'] == $dept_id) 
			{
			echo '<option value="' .$row['dept_id']. '" selected="selected">' . $row['dept_name'] . '</option>';
			}
			else 
			{
			echo '<option value="' .$row['dept_id']. '" >' . $row['dept_name'] . '</option>';
			}   
		}
	echo '</select> </p>';
		}
		else{
			echo "no results";
		}
	echo "<br/><input type='hidden' name='course_id' value='".$course_id."'>";	
	echo "<br/><input type='submit' value='Submit!'>";
	echo "<input type='hidden' name='submitted' value='TRUE' />";
	echo "<p> <a href='add_section.php?course_id=$course_id'>Add a Section to the Course </a>&nbsp;&nbsp;&nbsp; <a href='view_courses.php'>Go back to View All Courses</a>";
	echo "</form>";
		
	


?>