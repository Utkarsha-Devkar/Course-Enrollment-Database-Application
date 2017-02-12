<?php # view_sections.php


// Page header.

// Check for a valid course ID, through GET.
if ( (isset($_GET['course_id'])) && (is_numeric($_GET['course_id'])) ) { // Accessed through view_courses.php
	$course_id = $_GET['course_id'];
	} 
	else { // No valid ID, kill the script.
	echo '<h1 id="mainhead">Page Error</h1>
	<p class="error">This page has been accessed in error.</p><p><br /><br /></p>';
	exit();
}

include ('mysqli_connect_to_devkar_courses.php');
$page_title = 'View Sections';

$course_title="";
$course_code="";

// Number of records to show per page:
$display = 5;

// Determine how many pages there are. 
if (isset($_GET['np'])) { // Already been determined.
	$num_pages = $_GET['np'];
	} 
	else { // Need to determine.

 	// Count the number of records
	$query = "SELECT COUNT(*) FROM sections WHERE course_id=$course_id";
	$result = @mysqli_query ($dbc, $query);
	$row = mysqli_fetch_array ($result, MYSQL_NUM);
	$num_records = $row[0];
	
	// Calculate the number of pages.
	if ($num_records > $display) { // More than 1 page.
		$num_pages = ceil ($num_records/$display);
		} else {
		$num_pages = 1;
		}

	} // End of else of np IF.


// Determine where in the database to start returning results.
	if (isset($_GET['s'])) {
		$start = $_GET['s'];
	} else {
	$start = 0;
	}
	



// Default column links.
	$link1 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=c_a";
	$link2 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=s_a";
	$link3 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=y_a";
	$link4 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=p_a";


// Determine the sorting order.
if (isset($_GET['sort'])) {

	// Use existing sorting order.
	switch ($_GET['sort']) {
		case 'c_a':
			$order_by = 'section_code ASC';
			$link1 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=c_d";
			break;
		case 'c_d':
			$order_by = 'section_code DESC';
			$link1 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=c_a";
			break;
			
		case 's_a':
			$order_by = 'semester ASC';
			$link2 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=s_d";
			break;
		case 's_d':
			$order_by = 'semester DESC';
			$link2 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=s_a";
			break;
			
		case 'y_a':
			$order_by = 'year ASC';
			$link3 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=y_d";
			break;
		case 'y_d':
			$order_by = 'year DESC';
			$link3 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=y_a";
			break;
			
		case 'p_a':
			$order_by = 'prof_name ASC';
			$link4 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=p_d";
			break;
		case 'p_d':
			$order_by = 'prof_name DESC';
			$link4 = "{$_SERVER['PHP_SELF']}?course_id=$course_id&sort=p_a";
			break;
	}
	
	// $sort will be appended to the pagination links.
	$sort = $_GET['sort'];
	
	} else { // Use the default sorting order.
	$order_by = 'section_code ASC';
	$sort = 'c_a';
	}

$query_cnt = "SELECT count(1)
		  FROM sections, courses, professors 
		  WHERE sections.course_id=courses.course_id AND sections.prof_id=professors.prof_id AND sections.course_id=$course_id";		
$result_cnt = @mysqli_query ($dbc, $query_cnt);
$num_rows = mysqli_fetch_array ($result_cnt, MYSQL_NUM);

$query = "SELECT section_id, section_code, year, semester, courses.course_id, course_code, course_title, professors.prof_id, CONCAT(prof_fname, ' ', prof_lname) as prof_name
		  FROM sections, courses, professors 
		  WHERE sections.course_id=courses.course_id AND sections.prof_id=professors.prof_id AND sections.course_id=$course_id ORDER BY $order_by LIMIT $start, $display";		
$result = @mysqli_query ($dbc, $query); // Run the query.


if($result && $num_rows[0] > 0){

$row = mysqli_fetch_array($result, MYSQL_ASSOC);

// Page header.
echo '<h1 id="mainhead">Sections of the selected Course: ' . $row['course_code'].' - '.$row['course_title'] . '</h1>';


// Table header.
echo "Ordered by $order_by";
echo '<table align="center" cellspacing="0" cellpadding="5">
<tr>
	<td align="left"><b>Edit</b></td>
	<td align="left"><b>Delete</b></td>
	<td align="left"><b><a href="' . $link1 . '">Section Code </a></b></td>
	<td align="left"><b><a href="' . $link2 . '">Semester</a></b></td>
	<td align="left"><b><a href="' . $link3 . '">Year</a></b></td>
	<td align="left"><b><a href="' . $link4 . '">Professor Name</a></b></td>
</tr>';

	#Again Query:
	$query = "SELECT section_id, section_code, year, semester, courses.course_id, course_code, course_title, professors.prof_id, CONCAT(prof_fname, ' ', prof_lname) as prof_name
		  FROM sections, courses, professors 
		  WHERE sections.course_id=courses.course_id AND sections.prof_id=professors.prof_id AND sections.course_id=$course_id ORDER BY $order_by LIMIT $start, $display";	
		  
	$result = @mysqli_query ($dbc, $query); // Run the query.

// Fetch and print all the records.
	$bg = '#eeeeee'; // Set the initial background color.

	
		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) 
			{
			$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
		
			#use later:"delete_course.php?course_id='.$row['COURSE_ID'] .'"
			// Define the background color for the table row.
			echo '<tr bgcolor="' . $bg . '" > 
			<td align="left"><b><a href="edit_section.php?section_id='.$row['section_id'] .'">edit</a></b></td>
			<td align="left"><b><a href="delete_section.php?section_id='.$row['section_id'] .'">delete</a></b></td>
			
			<td align="left">' . $row['section_code'] . '</td>
			<td align="left">' . $row['semester'] . '</td>
			<td align="left">' . $row['year'] . '</td>
			<td align="left">' . $row['prof_name'] . '</td>
			
			</tr>
			';
			}
	 //Fetched and printed all the records.
		

echo '</table>';
}else{
	// Page header.
	//echo '<h1 id="mainhead">Sections of the selected Course: ' . $row['course_code'].' - '.$row['course_title'] . '</h1>';
	echo '<p>This course does not have any section. <br>';
}
mysqli_free_result ($result); // Free up the resources.	

mysqli_close($dbc); // Close the database connection.

#LINKS:

if ($num_pages > 1) {
	
	echo '<br /><p>';
	// Determine what page the script is on.	
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a First button and a Previous button.
	if ($current_page != 1) {
		echo '<a href="view_sections.php?s=0&np=' . $num_pages . '&course_id=' . $course_id . '&sort=' . $sort .'">First</a> ';
		echo '<a href="view_sections.php?s=' . ($start - $display) . '&np=' . $num_pages . '&course_id=' . $course_id . '&sort=' . $sort .'">Previous</a> ';
	}
	
	// Make all the numbered pages.
	for ($i = 1; $i <= $num_pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="view_sections.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '&course_id=' . $course_id . '&sort=' . $sort .'">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	}
	
	// If it's not the last page, make a Last button and a Next button.
	if ($current_page != $num_pages) {
		echo '<a href="view_sections.php?s=' . ($start + $display) . '&np=' . $num_pages . '&course_id=' . $course_id . '&sort=' . $sort .'">Next</a> ';
		echo '<a href="view_sections.php?s=' . (($num_pages-1) * $display) . '&np=' . $num_pages . '&course_id=' . $course_id . '&sort=' . $sort .'">Last</a>';

	}
	
	echo '</p>';
	
} // End of links section.

echo '<p><a href="add_section.php?course_id='.$course_id.'">Add a new Section to this Course.</a></p>';
echo '<p> <a href="view_courses.php">Go back to View All Courses </a>';
?>


