<?php # add_department.php  

$page_title = 'Add a department';

##CONNECTION TO DB:
include ('mysqli_connect_to_devkar_courses.php');

$dept_name="";
$dept_year="";
$univ_id="";
$mail_office_id="";
#  DO NOT USE $dept_id = "";

#NO GET METHOD

	

##IF FORM IS SUBMITTED: CHECK ERRORS, IF NONE THEN ADD THE NEW DEPARTMENT
// Check if the form has been submitted.  // ????DOES it have to be one parameter like 'course_title' or the 'submit' tag is fine, 
											//double-checking here??? see 'add_movie'
if (isset($_POST['submitted'])) {  
		
		
		#$dept_name = $_POST['dept_name'];  //not required to assing POST at first only??
		#$dept_year = $_POST['dept_year'];
		#$univ_id = $_POST['univ_id'];
		#$mail_office_id = $_POST['mail_office_id'];

						  
	// Initialize error array.
	$errors = array(); 
	
	// Check for a department name.
	if (empty($_POST['dept_name'])) {
		$errors[] = 'You forgot to enter the name of the department.';
	} else {
		$dept_name = $_POST['dept_name'];
	}
	
	// Check for department year  //check for numeric
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
	
	
	// Check for a University name (Not Required).
	if (empty($_POST['univ_id'])) {
		$errors[] = 'You forgot to select University for the department.';
	} else {
		$univ_id = $_POST['univ_id'];
	}
	
	
	// Check for Contact Mail. (Not Required).
	if (empty($_POST['mail_office_id'])) {
		$errors[] = 'You forgot to select the contact mail of the department.';
	} else {
		$mail_office_id = $_POST['mail_office_id'];
	}
	
	
	#Get the Department details: for SUCCESS MESSAGE
		$query = "SELECT  univ_name, contact_mail
				  FROM  universities, mailoffice 
				  WHERE univ_id = $univ_id AND office_id = $mail_office_id";

		$result = @mysqli_query ($dbc, $query);
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
			{
				$univ_name=$row['univ_name']; 
				$contact_mail=$row['contact_mail']; 
		// they will be used as part of the success message
			}
	
	
	//if no errors in the vlaues selected, updation of the entries
	if (empty($errors)) { // If everything's OK.
	
	
			// Make the query.
			$query = "INSERT INTO departments (dept_name, dept_year, univ_id, mail_office_id) 
					 VALUES ('$dept_name','$dept_year', '$univ_id', '$mail_office_id')";
			$result = @mysqli_query ($dbc, $query); // Run the query.
			// If query ran OK.
			if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
			
				// Print a message.
				 echo '<h1>Success!</h1>
						<p>You have added:</p>';
						
				echo "<table>
				<tr><td>Department Name:</td><td>$dept_name</td></tr>
				<tr><td>Department Year(Establishment):</td><td>$dept_year</td></tr>
				<tr><td>University Name:</td><td>$univ_name</td></tr>
				<tr><td>Contact Mail:</td><td>$contact_mail</td></tr>
			</table>";
			echo '<p> <a href="add_department.php">Go back to Add a Department </a>';
							
			} 
			else { // If query did not run OK.
				echo '<h1 id="mainhead">System Error</h1>
				<p class="error">The department could not be added due to a system error. We apologize for any inconvenience.</p>'; // Public message.
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

	echo "<h2>Add a department</h2>
		<form action='add_department.php' method='post'>
		<p>Department Name: <input type='text' name='dept_name' size='35' maxlength='35' value='";  //DEPARTMENT NAME
		if (isset($dept_name))
		{
			echo $dept_name;  //to make it sticky
		}	 
	
	echo "'></p>

	<p>Department Year: <input type='text' name='dept_year' size='35' maxlength='4' value='";  // DEPARTMENT YEAR
	if (isset($dept_year))
		{
			echo $dept_year;  //to make it sticky
		}	 
	
	echo "'>";

		
	echo "<p>Univeristy Name: <select name='univ_id'>";  //UNIVERSITY NAMES
		// Build the query for department names drop-down
		$query = "SELECT univ_id, univ_name  FROM universities ORDER BY univ_name ASC";
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
		
	echo "<p>Contact Mail: <select name='mail_office_id'>";  //CONTACT MAIL NAMES
		// Build the query for department names drop-down
		$query = "SELECT office_id, contact_mail FROM mailoffice ORDER BY contact_mail ASC";  //column names acc to table of 'mailoffice'
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
	echo '</select>&nbsp;&nbsp;';
		}
		else{
			echo "no results";
		}
		
	echo"<br/>";	
	#echo "<br/><input type='hidden' name='course_id' value='".$course_id."'>";	
	echo "<p> <input type='submit' name= 'submitted' value='Add Department!'>"; //?????????????????????????????????????????????????/

	
	#echo "<input type='hidden' name='submitted' value='TRUE' />";
	
	echo "</form>";
		
}
echo '<p><a href="view_departments.php">Go back to Department List</a>&nbsp;&nbsp;&nbsp; <a href="add_course.php">Go back to Adding a Course</a>&nbsp;&nbsp;&nbsp;<a href="main_index.php">Go back to the Main Menu</a>';


?>