<?php # edit_course.php  ?? no hidden??

$page_title = 'Add a course';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$course_code="";
$course_title="";
$course_credits="";
$dept_id="";
#  DO NOT USE $course_id = "";

#NO GET METHOD

	

##IF FORM IS SUBMITTED: CHECK ERRORS, IF NONE THEN ADD THE NEW COURSE
// Check if the form has been submitted.  // ????DOES it have to be one parameter like 'course_title' or the 'submit' tag is fine
if (isset($_POST['submitted'])) {  
		
		#$course_id = $_POST['course_id'];   ??????????
		$course_code = $_POST['course_code'];
		$course_title = $_POST['course_title'];
		$course_credits = $_POST['course_credits'];
		$dept_id = $_POST['dept_id'];
	   

	// Initialize error array.
	$errors = array(); 
	
	// Check for a course code.
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
	
	
	// Check for department name.  ???? id or name
	if (empty($_POST['dept_id'])) {
		$errors[] = 'You forgot to enter the name of the department.';
	} else {
		$dept_id = $_POST['dept_id'];
	}
	
	#Get the course details: for SUCCESS MESSAGE
		$query = "SELECT  dept_name 
				  FROM  departments 
				  WHERE dept_id = $dept_id";

		$result = @mysqli_query ($dbc, $query);
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
			{
				$dept_name=$row['dept_name']; 
		// $dept_name will be used as part of the success message
			}	
	
	//if no errors in the vlaues selected, updation of the entries
	if (empty($errors)) { // If everything's OK.
	
	
			// Make the query.
			$query = "INSERT INTO courses (course_code, course_title, course_credits, dept_id) 
			VALUES ('$course_code','$course_title', '$course_credits', '$dept_id')";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			// If query ran OK.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
			
				// Print a message.
				 echo '<h1>Success!</h1>
						<p>You have added:</p>';
						
				echo "<table>
				<tr><td>Course Code:</td><td>$course_code</td></tr>
				<tr><td>Course Title:</td><td>$course_title</td></tr>
				<tr><td>Course Credits:</td><td>$course_credits</td></tr>
				<tr><td>Department Name:</td><td>$dept_name <a href='add_department.php'>Add a new Department</a></td></tr>
			</table>";
			echo '<p> <a href="add_course.php">Go back to Add a Course </a>';
							
			} 
			else { // If query did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The course could not be added due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

	echo "<h2>Add a course</h2>
		<form action='add_course.php' method='post'>
		<p>Course Code: <input type='text' name='course_code' size='35' maxlength='35' value='";  //COURSE CODE
		if (isset($course_code))
		{
			echo $course_code;  //to make it sticky
		}	 
	
	echo "'></p>

	<p>Course Title: <input type='text' name='course_title' size='35' maxlength='35' value='";  //COURSE TITLE
	if (isset($course_title))
		{
			echo $course_title;  //to make it sticky
		}	 
	
	echo "'>";

		
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
	echo '</select>&nbsp;&nbsp;&nbsp;<a href="add_department.php">Add a new Department</a> </p>';
		}
		else{
			echo "no results";
		}
	#echo "<br/><input type='hidden' name='course_id' value='".$course_id."'>";	
	echo "<br/><input type='submit' name= 'submitted' value='Add Course!'>";
	#echo "<input type='hidden' name='submitted' value='TRUE' />";
	#echo "<p> <a href=''>Add a section to the course </a>";
	
	echo "</form>";
		
}
	echo'<p> <a href="view_courses.php">Go to a View All Courses </a>&nbsp;&nbsp;&nbsp;<a href="main_index.php">Go back to Main Menu </a>';

?>