<?php 
#COONECTION:
include ('mysqli_connect_to_devkar_courses.php');

#Page header.
echo '<h1> Professors currently in the Database:</h1>';


// Number of records to show per page:
	$display = 5;

// Determine how many pages there are. Num of pages: np
	if (isset($_GET['np'])) 
		{ // Already been determined.
		$num_pages = $_GET['np'];
		} 
	else 
	{ // Need to determine.

 	// First, Count the number of records
	$query = "SELECT COUNT(*) FROM professors";
	$result = @mysqli_query ($dbc, $query);
	$row = mysqli_fetch_array ($result, MYSQL_NUM);
	$num_records = $row[0];
	
	// Calculate the number of pages.
	    if ($num_records > $display) { // More than 1 page.
		$num_pages = ceil ($num_records/$display);
		} else 
		{
		$num_pages = 1;
		}

	} // End of else of np IF.
	
	
	// Determine where in the database to start returning results.
	if (isset($_GET['s'])) {
	$start = $_GET['s'];
	} else {
	$start = 0;
	}
	
//LINKS:
	//Default column links.
	
	$link1 = "{$_SERVER['PHP_SELF']}?sort=f_a";
	$link2 = "{$_SERVER['PHP_SELF']}?sort=l_a";
	$link3 = "{$_SERVER['PHP_SELF']}?sort=c_a";
	$link4 = "{$_SERVER['PHP_SELF']}?sort=e_a";
	


	// Determine the sorting order.
	if (isset($_GET['sort'])) {

	// Use existing sorting order.
	switch ($_GET['sort']) {
		
		case 'f_a':
			$order_by = 'prof_fname ASC';
			$link1 = "{$_SERVER['PHP_SELF']}?sort=f_d";
			break;
		case 'f_d':
			$order_by = 'prof_fname DESC';
			$link1 = "{$_SERVER['PHP_SELF']}?sort=f_a";
			break;
			
		case 'l_a':
			$order_by = 'prof_lname ASC';
			$link2 = "{$_SERVER['PHP_SELF']}?sort=l_d";
			break;
		case 'l_d':
			$order_by = 'prof_lname DESC';
			$link2 = "{$_SERVER['PHP_SELF']}?sort=l_a";
			break;
			
		case 'c_a':
			$order_by = 'prof_cabin ASC';
			$link3 = "{$_SERVER['PHP_SELF']}?sort=c_d";
			break;
		case 'c_d':
			$order_by = 'prof_cabin DESC';
			$link3 = "{$_SERVER['PHP_SELF']}?sort=c_a";
			break;
			
		case 'e_a':
			$order_by = 'prof_email ASC';
			$link4 = "{$_SERVER['PHP_SELF']}?sort=e_d";
			break;
		case 'e_d':
			$order_by = 'prof_email DESC';
			$link4 = "{$_SERVER['PHP_SELF']}?sort=e_a";
			break;
		
		default:
			$order_by = 'prof_lname ASC';
			break;
	}
	
	// $sort will be appended to the pagination links.
	$sort = $_GET['sort'];
	
	} 
	else { // Use the default sorting order.
	$order_by = 'prof_lname ASC';
	$sort = 'l_a';
	}

	

// MAIN QUERY: Assign the query string to the variable $query
$query = "SELECT prof_id, prof_fname, prof_lname, prof_cabin, prof_email
		  FROM professors 
		  ORDER BY $order_by
		  LIMIT $start, $display";

 #echo '>>'.$query.'';        

// Run the query against the connection $dbc
$result = @mysqli_query ($dbc, $query);

//Table header- form - ECHO
echo "Ordered by $order_by";
echo '<table align="center" cellspacing="0" cellpadding="5">
<tr>
	<td align="left"><b>Edit</b></td>
	<td align="left"><b>Delete</b></td>
	
	<td align="left"><b><a href="' . $link1 . '">First Name </a></b></td>
	<td align="left"><b><a href="' . $link2 . '">Last Name</a></b></td>
	<td align="left"><b><a href="' . $link3 . '">Prof Cabin</a></b></td>
	<td align="left"><b><a href="' . $link4 . '">Prof Email </a></b></td>
	
</tr>';

// Fetch and print all the records.
	$bg = '#eeeeee'; // Set the initial background color.

	if($result) //checks if the query ran correct
	{	
	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) 
		{
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	
		// Define the background color for the table row.
		//use later now: <td align="left"><b><a href="edit_professor.php?course_id='.$row['COURSE_ID'] .'">edit</a></b></td>
		echo '<tr bgcolor="' . $bg . '" > 
		<td align="left"><b><a href="edit_professor.php?prof_id='.$row['prof_id'] .'">edit</a></b></td>
		<td align="left"><b><a href="delete_professor.php?prof_id='.$row['prof_id'] .'">delete</a></b></td>
	
		<td align="left">' . $row['prof_fname'] . '</td>
		<td align="left">' . $row['prof_lname'] . '</td>
		<td align="left">' . $row['prof_cabin'] . '</td>
		<td align="left">' . $row['prof_email'] . '</td>
		
		</tr>';
		}
	}
	else //If the query did not run OK.
	{
	 
	echo "<h1>System Error</h1>
	<p>We apologize for any inconvenience.</p>"; // Public message.
	echo "<p>" . mysqli_error($dbc) . "<br /><br />Query: $query </p>"; // Debugging message.

	} //Fetched and printed all the records.
		
echo '</table>';  // Table completed

mysqli_free_result ($result); // Free up the resources.	
mysqli_close ($dbc); // Close the database connection.

#LINKS:

//echo 'num_pages:'.$num_pages;
// Make the links to other pages, if necessary.
if ($num_pages > 1) {
	
	echo '<br /><p>';
	// Determine what page the script is on.	
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a First button and a Previous button.
	if ($current_page != 1) {
		echo '<a href="view_professors.php?s=0&np=' . $num_pages .'&sort=' . $sort .'">First</a> ';
		echo '<a href="view_professors.php?s=' . ($start - $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Previous</a> ';
	}
	
	// Make all the numbered pages.
	for ($i = 1; $i <= $num_pages; $i++) {

		if ($i != $current_page) {
			echo '<a href="view_professors.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages .'&sort=' . $sort . '">
			' . $i . '</a>&nbsp;';
		} else {
			echo $i . ' ';
		}
	}
	
	// If it's not the last page, make a Last button and a Next button.
	if ($current_page != $num_pages) {
		echo '<a href="view_professors.php?s=' . ($start + $display) . '&np=' . $num_pages .'&sort=' . $sort .'">Next</a> ';
		echo '<a href="view_professors.php?s=' . (($num_pages-1) * $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Last</a>';

	}
	
	echo '</p>';
	echo'<p> <a href="main_index.php">Go back to Main Menu </a>';
	
} // End of links section.
?>
