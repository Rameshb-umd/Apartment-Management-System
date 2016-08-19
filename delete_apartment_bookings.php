<?php # edit_course.php

$page_title = 'Delete Apartment Booking';
include ('connect_to_sql.php');
include ('menu.php');
include ('validate.php');
include ('common_functions.php');
echo '<link rel="stylesheet" href="styles.css" type="text/css">';

//Get Apartment Details
function getApartmentBookingDetails($db,$apt_booking_id){
    $query = "SELECT 
                        ab.apt_booking_id,
                        concat(ap.building_short_name,':',aa.apt_number) apartment,
                        concat(g.guest_first_name,' ',g.guest_last_name) guest,
                        bs.booking_status_description,
                        DATE_FORMAT(booking_start_date, '%m-%d-%Y') start_date,
                        DATE_FORMAT(booking_end_date, '%m-%d-%Y') end_date
                    FROM
                        apartment_bookings ab,
                        apartments aa,
                        guests g,
                        ref_booking_status bs,
                        Apartment_buildings ap
                    WHERE
                        ab.apt_id = aa.apt_id
                            AND ab.guest_id = g.guest_id
                            AND ab.booking_status_code = bs.booking_status_code
                            AND aa.building_id = ap.building_id and ab.apt_booking_id=$apt_booking_id";
    $result = @mysqli_query($db,$query); 
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    return $row;
}

// Create the form.
echo '<form action="delete_apartment_bookings.php" method="post">';
$apt_booking_id = "";
$apt_num= "";
$guest_name= "";
$booking_status= "";
$start_date= "";
$end_date= "";

//Only if Apt booking id know we can edit the apartment booking
if (isset($_GET['apt_booking_id'])) {	
    $apt_booking_id = $_GET['apt_booking_id'];
    $bookings = getApartmentBookingDetails($dbc,$apt_booking_id);
    $apt_num= $bookings["apartment"];
    $guest_name= $bookings["guest"];
    $booking_status= $bookings["booking_status_description"];
    $start_date= $bookings["start_date"];
    $end_date= $bookings["end_date"];
}

//Populate Value from Form Submit - Stickeness
if (isset($_POST['apt_booking_id'])) {	
    $apt_booking_id = $_POST['apt_booking_id'];
    $bookings = getApartmentBookingDetails($dbc,$apt_booking_id);
    $apt_num= $bookings["apartment"];
    $guest_name= $bookings["guest"];
    $booking_status= $bookings["booking_status_description"];
    $start_date= $bookings["start_date"];
    $end_date= $bookings["end_date"];
}

echo '<div class="container">';
echo '<h2>Delete apartment booking</h2>
        <h3>Apartment : ' . $apt_num . '</h3>
        <h3>Guest: ' . $guest_name . '</h3>
        <h3>Booking Status: ' . $booking_status. '</h3>
        <h3>Booking Start Date: ' . $start_date. '</h3>
        <h3>Booking End Date: ' . $end_date. '</h3>';	

//Create Form Elements
if(isset($_GET['apt_booking_id'])){
	echo '<p>Are you sure you want to delete this Course?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	<p><input type="submit" name="submit" value="Submit!" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="apt_booking_id" value="' . $apt_booking_id . '" /> '; 		
}
echo '</form>';
echo '</div>';

// Performing Business Logic When Submitted
if (isset($_POST['submitted'])) {
    echo '<div class="Message_bar">';
    if ($_POST['sure'] == 'Yes') {
            echo '<h3 id="mainhead">Message from Database:</h3>';
            $query = "delete from view_unit_status where apt_booking_id=$apt_booking_id";
            deleteTable($dbc,$query);
			$query = "DELETE FROM apartment_bookings WHERE apt_booking_id=$apt_booking_id";
            deleteTable($dbc,$query);
		}else{ 
			echo '<h3 id="mainhead">Message from Database:</h3>';
            echo'<p>This record has NOT been deleted.</p>';	
		} 
    echo '</div>';
}

?>