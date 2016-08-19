<?php # edit_course.php

$page_title = 'Delete Guest Information';
include ('connect_to_sql.php');
include ('menu.php');
include ('validate.php');
include ('common_functions.php');
echo '<link rel="stylesheet" href="styles.css" type="text/css">';

//Get Apartment Details
function getGuestDetails($db,$guest_id){
    $query = "select guest_id, guest_first_name,guest_last_name, 
    date_format(guest_date_of_birth,'%m-%d-%Y') guest_date_of_birth, guest_gender from guests 
    where guest_id=$guest_id";
    $result = @mysqli_query($db,$query); 
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    return $row;
}

// Create the form.
echo '<form action="delete_guests.php" method="post">';
$guest_id = "";
$guest_first_name= "";
$guest_last_name= "";
$guest_date_of_birth= "";
$guest_gender="";

//Only if Apt id know we can edit the apartment
if (isset($_GET['guest_id'])) {	
    $guest_id = $_GET['guest_id'];
    $guests = getGuestDetails($dbc,$guest_id);
    $guest_first_name= $guests["guest_first_name"];
    $guest_last_name= $guests["guest_last_name"];
    $guest_date_of_birth= $guests["guest_date_of_birth"];
    $guest_gender= $guests["guest_gender"];
}

//Populate Value from Form Submit - Stickeness
if (isset($_POST['guest_id'])) {	
    $guest_id = $_POST['guest_id'];$guests = getGuestDetails($dbc,$guest_id);
    $guest_first_name= $guests["guest_first_name"];
    $guest_last_name= $guests["guest_last_name"];
    $guest_date_of_birth= $guests["guest_date_of_birth"];
    $guest_gender= $guests["guest_gender"];
}

echo '<div class="container">';
echo '<h2>Delete Guests</h2>
        <h3>First Name : ' . $guest_first_name . '</h3>
        <h3>Last Name: ' . $guest_last_name . '</h3>
        <h3>Date of birth: ' . $guest_date_of_birth. '</h3>
        <h3>Gender: ' . $guest_gender. '</h3>';	

//Create Form Elements
if(isset($_GET['guest_id'])){
	echo '<p>Are you sure you want to delete this Course?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	<p><input type="submit" name="submit" value="Submit!" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="guest_id" value="' . $guest_id . '" /> '; 		
}
echo '</form>';
echo '</div>';

// Performing Business Logic When Submitted
if (isset($_POST['submitted'])) {
    echo '<div class="Message_bar">';
    if ($_POST['sure'] == 'Yes') {
            echo '<h3 id="mainhead">Message from Database:</h3>';
           	$query = "DELETE FROM guests WHERE guest_id=$guest_id";
            deleteTable($dbc,$query);
		}else{ 
			echo '<h3 id="mainhead">Message from Database:</h3>';
            echo'<p>This record has NOT been deleted.</p>';	
		} 
    echo '</div>';
}

?>