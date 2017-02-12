<?php # delete_section.php

$page_title = 'Delete the section';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$section_id="";
$section_code="";
$semester="";
$year="";
$prof_id="";
$course_id="";



# GET METHOD: then retireve and populate
if ( (isset($_GET['section_id'])) && (is_numeric($_GET['section_id'])) )  // Already been determined., Assign to populate
	{ 
	
	$section_id = $_GET['section_id'];

	// Retrieve the section's information which we clicked to delete.
	$query = "SELECT section_id,section_code,semester, year, courses.course_id, course_title, professors.prof_id, CONCAT(prof_fname, ' ', prof_lname) as prof_name
			FROM sections, courses, professors 
			WHERE sections.course_id=courses.course_id AND sections.prof_id=professors.prof_id AND sections.section_id=$section_id";
		
			  
	$result = @mysqli_query ($dbc, $query); // Run the query.

	if (mysqli_num_rows($result) == 1) { // Valid section ID, then only show the form.

		// Get the section's information.
		$row = mysqli_fetch_array ($result, MYSQL_ASSOC);
		$course_title=$row['course_title'];
		$section_code=$row['section_code'];
		$semester=$row['semester'];
		$year=$row['year'];
		$prof_name=$row['prof_name'];
		
		}
	else { // Not a valid section ID.
		echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error. Not a valid Section ID .</p><p><br /><br /></p>';
		}
	}

elseif ( (isset($_POST['section_id'])) && (is_numeric($_POST['section_id'])) ) //POST method
	{        
	$section_id=$_POST['section_id'];
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
		
			#FOR SUCCESS MESSAGES
			$query = "SELECT section_id, course_title, section_code, semester, year
					 FROM sections as s, courses as c
					 WHERE s.course_id = c.course_id AND section_id=$section_id";	
					 
		   $result = @mysqli_query ($dbc, $query); // Run the query.
		   if (mysqli_num_rows($result) == 1) { // Valid section ID, show the result.

			// Get the section information.  // for SUCCESS MESSAGES
			$row = mysqli_fetch_array ($result, MYSQL_ASSOC);

			$course_title=$row['course_title'];
			$section_code=$row['section_code'];
			$semester=$row['semester'];
			$year=$row['year'];  
			
		   }
		   else { // Not a valid section ID.
					echo '<h1 id="mainhead">Page Error</h1>
			<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
			}
			
			
	//Check if sure!
		if ($_POST['sure'] == 'Yes') { // Delete them.

			
			//query for deletion
			$query = "DELETE FROM sections WHERE section_id=$section_id";		
			$result_del = @mysqli_query ($dbc, $query); // Run the query.
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Get the section information.
				$row = mysqli_fetch_array ($result, MYSQL_NUM);
			
				// Create the result page.
				echo '<h1 id="mainhead">Delete a Section</h1>
				<p>The section <b>'.$section_code.'</b> for <b> '.$semester.' '.$year.'</b> of the course <b>'.$course_title.'</b> has been deleted.</p><p><br /><br /></p>';	
				echo '<p> <a href="view_courses.php">Go back to View all Courses </a> ';
			} 
			else { // Did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The section could not be deleted due to a system error.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
			}
		
		} // End of $_POST['sure'] == 'Yes' if().
		
		else  // Wasn't sure about deleting the section.
		{ 
			echo '<h1 id="mainhead">Delete a Section</h1>
				<p>The section <b>'.$section_code.'</b> for <b> '.$semester.' '.$year.'</b> of the course <b>'.$course_title.'</b> has  NOT been deleted.</p><p><br /><br /></p>';	
				echo '<p> <a href="view_courses.php">Go back to View all Courses </a> ';


		} // End of wasn’t sure else().


}//if submitted section


	
// MAIN FORM	
if((isset($_GET['section_id']))  && (is_numeric($_GET['section_id'])) ){
	echo '<h2>Delete a section</h2>
	<form action="delete_section.php" method="post">
	<h3>Course: ' . $course_title . '</h3>
	<h3>Section Code: ' . $section_code . '</h3>
	<h3>Semester: ' . $semester . '</h3>
	<h3>Year: ' . $year. '</h3>
	<h3>Teaching Professor: ' . $prof_name . '</h3>
	
		
	
	
	
	<p>Are you sure you want to delete this Section?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	
	<p><input type="submit" name="submit" value="Submit!" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="section_id" value="' . $section_id . '" />  
	<p> <a href="view_courses.php">Go back to View all Courses </a>
	</form>';  //??hidden??
	
	
}


?>