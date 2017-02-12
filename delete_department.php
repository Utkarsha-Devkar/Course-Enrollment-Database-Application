<?php # delete_department.php

$page_title = 'Delete the department';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$dept_id="";
$dept_name="";
$dept_year="";
$univ_id="";
$univ_name="";
$mail_office_id="";
$contact_mail="";


# GET METHOD: then retireve and populate
if ( (isset($_GET['dept_id'])) && (is_numeric($_GET['dept_id'])) )  // Already been determined., Assign to populate
	{ 
	
	$dept_id = $_GET['dept_id'];

	// Retrieve the dept's information which we clicked to delete.
	$query = "SELECT dept_id,dept_name,dept_year, univ_name, contact_mail
			  FROM  departments as d, mailoffice as m, universities as u 
			  WHERE d.univ_id = u.univ_id AND  d.mail_office_id= m.office_id AND dept_id=$dept_id";
			  
	$result = @mysqli_query ($dbc, $query); // Run the query.

	if (mysqli_num_rows($result) == 1) { // Valid dept ID, then only show the form.

		// Get the dept's information.
		$row = mysqli_fetch_array ($result, MYSQL_ASSOC);
		$dept_name=$row['dept_name'];
		$dept_year=$row['dept_year'];
		$univ_name=$row['univ_name'];
		#$dept_id=$row['dept_id'];
		$contact_mail=$row['contact_mail'];
		}
	else { // Not a valid dept ID.
		echo '<h1 id="mainhead">Page Error</h1>
		<p class="error">This page has been accessed in error. Not a valid Department ID .</p><p><br /><br /></p>';
		}
	}

elseif ( (isset($_POST['dept_id'])) && (is_numeric($_POST['dept_id'])) ) //POST method
	{        
	$dept_id=$_POST['dept_id'];
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
		
			
			$query = "SELECT dept_name, dept_year, univ_name
					 FROM departments as d, universities as u
					 WHERE d.univ_id = u.univ_id AND dept_id=$dept_id";	
					 
		   $result = @mysqli_query ($dbc, $query); // Run the query.
		   if (mysqli_num_rows($result) == 1) { // Valid dept ID, show the result.

			// Get the dept information.  // for SUCCESS MESSAGES
			$row = mysqli_fetch_array ($result, MYSQL_ASSOC);

			$univ_name=$row['univ_name'];
			$dept_name=$row['dept_name'];
			$dept_year=$row['dept_year'];    
			
		   }
		   else { // Not a valid dept ID.
					echo '<h1 id="mainhead">Page Error</h1>
			<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
			}
			
			
	//Check if sure!
		if ($_POST['sure'] == 'Yes') { // Delete them.

			
			//query for deletion
			$query = "DELETE FROM departments WHERE dept_id=$dept_id";		
			$result_del = @mysqli_query ($dbc, $query); // Run the query.
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Get the dept information.
				$row = mysqli_fetch_array ($result, MYSQL_NUM);
			
				// Create the result page.
				echo '<h1 id="mainhead">Delete a Department</h1>
				<p>The department <b>'.$dept_name.'</b> from the <b> '.$univ_name.'</b> has been deleted.</p><p><br /><br /></p>';	
				echo'<p> <a href="view_departments.php">Go to View All Departments </a>';
				
			} 
			else { // Did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The department could not be deleted due to a system error.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
			}
		
		} // End of $_POST['sure'] == 'Yes' if().
		
		else  // Wasn't sure about deleting the department.
		{ 
			echo '<h1 id="mainhead">Delete a Departent</h1>';

	
				echo'<p>The department: <b>'.$dept_name.'</b> from <b>'.$univ_name.'</b> has NOT been deleted.</p><p><br /><br /></p>';	
				echo'<p> <a href="view_departments.php">Go to View All Departments </a>';


		} // End of wasn’t sure else().


}//if submitted section


	
// MAIN FORM	
if((isset($_GET['dept_id']))  && (is_numeric($_GET['dept_id'])) ){
	echo '<h2>Delete a department</h2>
	<form action="delete_department.php" method="post">
	<h3>Department Name: ' . $dept_name . '</h3>
	<h3>Department Year: ' . $dept_year . '</h3>
	<h3>University Name: ' . $univ_name. '</h3>
	<h3>Contact Mail: ' . $contact_mail . '</h3>
	
		
	
	
	
	<p>Are you sure you want to delete this Department?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	
	<p><input type="submit" name="submit" value="Submit!" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="dept_id" value="' . $dept_id . '" />  
	<p> <a href="view_departments.php">Go back to View All Departments </a>
	</form>';  
	
	
}


?>