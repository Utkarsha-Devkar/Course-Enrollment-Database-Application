<?php # edit_course.php

$page_title = 'Delete the course';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$course_code="";
$course_title="";
$course_credits="";
$dept_id="";
$course_id = "";
$dept_name= "";

# GET METHOD: then retireve and populate
if ( (isset($_GET['course_id'])) && (is_numeric($_GET['course_id'])) )  // Already been determined., Assign to populate
	{ 
	
	$course_id = $_GET['course_id'];

	// Retrieve the course's information which we clicked to delete.
	$query = "SELECT course_id,course_code,course_title, course_credits, dept_name
			  FROM courses as c, departments as d
			  WHERE c.DEPT_ID = d.DEPT_ID  AND course_id=$course_id";
			  
	$result = @mysqli_query ($dbc, $query); // Run the query.

	if (mysqli_num_rows($result) == 1) { // Valid course ID, then only show the form.

		// Get the course's information.
		$row = mysqli_fetch_array ($result, MYSQL_ASSOC);
		$course_code=$row['course_code'];
		$course_title=$row['course_title'];
		$course_credits=$row['course_credits'];
		#$dept_id=$row['dept_id'];
		$dept_name=$row['dept_name'];
		}
	else { // Not a valid course ID.
		echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error. Not a valid course ID #1.</p><p><br /><br /></p>';
		}
	}

elseif ( (isset($_POST['course_id'])) && (is_numeric($_POST['course_id'])) ) //POST method
	{        
	$course_id=$_POST['course_id'];
	// delete
	}
else 
	{ // No valid ID, kill the script.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error #2.</p><p><br /><br /></p>';
	exit();
	}
	

##IF FORM IS SUBMITTED: CHECK YES/NO SURE, THEN DELETE POST METHOD:
// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
			#$course_code = $_POST['course_code'];
			#$course_title = $_POST['course_title'];
			#$course_credits = $_POST['course_credits'];
			#$dept_name = $_POST['dept_name'];
			
			$query = "SELECT course_code, course_title
					 FROM courses WHERE course_id=$course_id";	
					 
		   $result = @mysqli_query ($dbc, $query); // Run the query.
		   if (mysqli_num_rows($result) == 1) { // Valid course ID, show the result.

			// Get the course information.
			$row = mysqli_fetch_array ($result, MYSQL_ASSOC);

			$course_code=$row['course_code'];
			$course_title=$row['course_title'];
			
		   }
		   else { // Not a valid course ID.
					echo '<h1 id="mainhead">Page Error</h1>
			<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
			}
			
			
	//Check if sure!
		if ($_POST['sure'] == 'Yes') { // Delete them.
			
			//query for deletion
			$query = "DELETE FROM courses WHERE course_id=$course_id";		
			$result_del = @mysqli_query ($dbc, $query); // Run the query.
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Get the course information.
				$row = mysqli_fetch_array ($result, MYSQL_NUM);
			
				// Create the result page.
				echo '<h1 id="mainhead">Delete a Course</h1>
				<p>The course <b>'.$course_code.'</b> titled<b> '.$course_title.'</b> has been deleted.</p><p><br /><br /></p>';
				echo '<p> <a href="view_courses.php">Go back to View All Courses </a>';
			} 
			else { // Did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The course could not be deleted due to a system error.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
			}
		
		} // End of $_POST['sure'] == 'Yes' if().
		
		else  // Wasn't sure about deleting the course.
		{ 
			echo '<h1 id="mainhead">Delete a Course</h1>';
	
				// Create the result page.
				echo'<p>The course <b>'.$course_code.'</b> titled <b>'.$course_title.'</b> has NOT been deleted.</p><p><br /><br /></p>';
				echo '<p> <a href="view_courses.php">Go back to View All Courses </a>';
			

		} // End of wasn’t sure else().


}//if submitted section


	
// MAIN FORM	
if((isset($_GET['course_id']))  && (is_numeric($_GET['course_id'])) ){
	echo '<h2>Delete a course</h2>
	<form action="delete_course.php" method="post">
	<h3>Course Code: ' . $course_code . '</h3>
	<h3>Course Title: ' . $course_title . '</h3>
	<h3>Course Credits: ' . $course_credits. '</h3>
	<h3>Department Name: ' . $dept_name . '</h3>
	
		
	
	
	
	<p>Are you sure you want to delete this Course?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	
	<p><input type="submit" name="submit" value="Submit!" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="course_id" value="' . $course_id . '" />  
	<p> <a href="view_courses.php">Go back to View All Courses </a>
	</form>'; 
	
	
		
}


?>