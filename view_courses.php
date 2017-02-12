<?php 

include ('mysqli_connect_to_devkar_courses.php');

// Page header.
echo '<h1>Courses currently in the Database:</h1>';


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
	$query = "SELECT COUNT(*) FROM courses";
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
	
	$link1 = "{$_SERVER['PHP_SELF']}?sort=c_a";
	$link2 = "{$_SERVER['PHP_SELF']}?sort=t_a";
	$link3 = "{$_SERVER['PHP_SELF']}?sort=cr_a";
	$link4 = "{$_SERVER['PHP_SELF']}?sort=d_a";
	$link5 = "{$_SERVER['PHP_SELF']}?sort=s_a";


	// Determine the sorting order.
	if (isset($_GET['sort'])) {

	// Use existing sorting order.
	switch ($_GET['sort']) {
		
		case 'c_a':
			$order_by = 'COURSE_CODE ASC';
			$link1 = "{$_SERVER['PHP_SELF']}?sort=c_d";
			break;
		case 'c_d':
			$order_by = 'COURSE_CODE DESC';
			$link1 = "{$_SERVER['PHP_SELF']}?sort=c_a";
			break;
			
		case 't_a':
			$order_by = 'COURSE_TITLE ASC';
			$link2 = "{$_SERVER['PHP_SELF']}?sort=t_d";
			break;
		case 't_d':
			$order_by = 'COURSE_TITLE DESC';
			$link2 = "{$_SERVER['PHP_SELF']}?sort=t_a";
			break;
			
		case 'cr_a':
			$order_by = 'COURSE_CREDITS ASC';
			$link3 = "{$_SERVER['PHP_SELF']}?sort=cr_d";
			break;
		case 'cr_d':
			$order_by = 'COURSE_CREDITS DESC';
			$link3 = "{$_SERVER['PHP_SELF']}?sort=cr_a";
			break;
			
		case 'd_a':
			$order_by = 'DEPT_NAME ASC';
			$link4 = "{$_SERVER['PHP_SELF']}?sort=d_d";
			break;
		case 'd_d':
			$order_by = 'DEPT_NAME DESC';
			$link4 = "{$_SERVER['PHP_SELF']}?sort=d_a";
			break;
			
		case 's_a':
			$order_by = 'Number_of_Sections ASC';
			$link5 = "{$_SERVER['PHP_SELF']}?sort=s_d";
			break;
		case 's_d':
			$order_by = 'Number_of_Sections DESC';
			$link5 = "{$_SERVER['PHP_SELF']}?sort=s_a";
			break;
		
		default:
			$order_by = 'COURSE_CODE ASC';
			break;
	}
	
	// $sort will be appended to the pagination links.
	$sort = $_GET['sort'];
	
	} 
	else { // Use the default sorting order.
	$order_by = 'COURSE_CODE ASC';
	$sort = 'c_a';
	}

	

// MAIN QUERY: Assign the query string to the variable $query
$query = "SELECT COURSE_ID, COURSE_CODE, COURSE_TITLE, COURSE_CREDITS, DEPT_NAME ,(SELECT COUNT(1) FROM SECTIONS S, PROFESSORS P WHERE S.PROF_ID=P.PROF_ID AND S.COURSE_ID=C.COURSE_ID)as Number_of_Sections
		  FROM courses as c, departments as d
		  WHERE c.DEPT_ID = d.DEPT_ID 
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
	
	<td align="left"><b><a href="' . $link1 . '">Course Code </a></b></td>
	<td align="left"><b><a href="' . $link2 . '">Course Title </a></b></td>
	<td align="left"><b><a href="' . $link3 . '">Course Credits </a></b></td>
	<td align="left"><b><a href="' . $link4 . '">Dept Name </a></b></td>
	<td align="left"><b><a href="' . $link5 . '">Number of Sections </a></b></td>
	
	
</tr>';
//<td align="left"><b>Section Count</b></td>	

// Fetch and print all the records.
	$bg = '#eeeeee'; // Set the initial background color.

	if($result) //checks if the query ran correct
	{	
	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) 
		{
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	
		// Define the background color for the table row.
		echo '<tr bgcolor="' . $bg . '" > 
		<td align="left"><b><a href="edit_course.php?course_id='.$row['COURSE_ID'] .'">edit</a></b></td>
		<td align="left"><b><a href="delete_course.php?course_id='.$row['COURSE_ID'] .'">delete</a></b></td>
	
		<td align="left">' . $row['COURSE_CODE'] . '</td>
		<td align="left">' . $row['COURSE_TITLE'] . '</td>
		<td align="left">' . $row['COURSE_CREDITS'] . '</td>
		<td align="left">' . $row['DEPT_NAME'] . '</td>
		<td align="left">' . $row['Number_of_Sections'] . '</td>
		<td align="left"><a href="view_sections.php?course_id='.$row['COURSE_ID'] .'">View Sections</a></td>
		
		</tr>';
		}
	}
	else //If the query did not run OK.
	{
	 
	echo "<h1>System Error</h1>
	<p>We apologize for any inconvenience.</p>"; // Public message.
	echo "<p>" . mysqli_error($dbc) . "<br /><br />Query: $query </p>"; // Debugging message.

	} //Fetch and print all the records.
		
echo '</table>';  // Table completed

mysqli_free_result ($result); // Free up the resources.	
mysqli_close ($dbc); // Close the database connection.

#LINKS:

#echo 'num_pages:'.$num_pages;
// Make the links to other pages, if necessary.
if ($num_pages > 1) {
	
	echo '<br /><p>';
	// Determine what page the script is on.	
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a First button and a Previous button.
	if ($current_page != 1) {
		echo '<a href="view_courses.php?s=0&np=' . $num_pages .'&sort=' . $sort .'">First</a> ';
		echo '<a href="view_courses.php?s=' . ($start - $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Previous</a> ';
	}
	
	// Make all the numbered pages.
	for ($i = 1; $i <= $num_pages; $i++) {

		if ($i != $current_page) {
			echo '<a href="view_courses.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages .'&sort=' . $sort . '">
			' . $i . '</a>&nbsp;';
		} else {
			echo $i . ' ';
		}
	}
	
	// If it's not the last page, make a Last button and a Next button.
	if ($current_page != $num_pages) {
		echo '<a href="view_courses.php?s=' . ($start + $display) . '&np=' . $num_pages .'&sort=' . $sort .'">Next</a> ';
		echo '<a href="view_courses.php?s=' . (($num_pages-1) * $display) . '&np=' . $num_pages . '&sort=' . $sort .'">Last</a>';

	}
	
	echo '</p>';
	echo'<p> <a href="main_index.php">Go back to Main Menu </a>';
	
} // End of links section.
?>
