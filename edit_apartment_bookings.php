<?php # 

$page_title = 'Edit Apartment Bookings';
include ('connect_to_sql.php');
include ('menu.php');
include ('validate.php');
include ('common_functions.php');
echo '<link rel="stylesheet" href="styles.css" type="text/css">';


// Function to get Apartments and ID
function getApartments($db,$apt_id){
    $result = @mysqli_query($db, "select apt_id, concat(building_short_name,':',apt_number) apt_number  
                from apartments a, apartment_buildings ab where a.building_id=ab.building_id order by apt_number"); 
     echo '<select name="apt_id">';
    if($result){
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            if($row["apt_id"]==$apt_id){
                echo '<option value="'.$row["apt_id"].'" selected="selected">'.$row["apt_number"].'</option>';
            }else{
                 echo '<option value="'.$row["apt_id"].'">'.$row["apt_number"].'</option>';
            }
        }
    }
    echo '</select>';   
}

// Function to get Guests and ID
function getGuest($db,$guest_id){
    $result = @mysqli_query($db, "select guest_id, concat(guest_first_name,' ',guest_last_name) guest_name from guests order by guest_name"); 
     echo '<select name="guest_id">';
    if($result){
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            if($row["guest_id"]==$guest_id){
                echo '<option value="'.$row["guest_id"].'" selected="selected">'.$row["guest_name"].'</option>';
            }else{
                 echo '<option value="'.$row["guest_id"].'">'.$row["guest_name"].'</option>';
            }
        }
    }
    echo '</select>';   
}

// Function to get Booking Status and ID
function getBookingStatus($db,$booking_status_code){
    $result = @mysqli_query($db, "select booking_status_code,booking_status_description from ref_booking_status order by booking_status_code"); 
     echo '<select name="booking_status_code">';
    if($result){
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            if($row["booking_status_code"]==$booking_status_code){
                echo '<option value="'.$row["booking_status_code"].'" selected="selected">'.$row["booking_status_description"].'</option>';
            }else{
                 echo '<option value="'.$row["booking_status_code"].'">'.$row["booking_status_description"].'</option>';
            }
        }
    }
    echo '</select>';   
}

//Get Apartment Details
function getApartmentBookingDetails($db,$apt_booking_id){
    $query = "select apt_booking_id,apt_id,guest_id,booking_status_code,DATE_FORMAT(booking_start_date, '%Y-%m-%d') start_date,
    DATE_FORMAT(booking_end_date, '%Y-%m-%d') end_date from apartment_bookings where apt_booking_id=$apt_booking_id";
    $result = @mysqli_query($db,$query); 
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    return $row;
}

// Create the form.
echo '<form action="edit_apartment_bookings.php" method="post">';
$apt_booking_id = "";
$apt_id= "";
$guest_id= "";
$booking_status_code= "";
$start_date= "";
$end_date= "";
//Only if Apt id know we can edit the apartment
if (isset($_GET['apt_booking_id'])) {	
    $apt_booking_id = $_GET['apt_booking_id'];
    $bookings = getApartmentBookingDetails($dbc,$apt_booking_id);
    $apt_id= $bookings["apt_id"];
    $guest_id= $bookings["guest_id"];
    $booking_status_code= $bookings["booking_status_code"];
    $start_date= $bookings["start_date"];
    $end_date= $bookings["end_date"];
}
//Populate Value from Form Submit - Stickeness
if (isset($_POST['apt_booking_id'])) {	
    $apt_booking_id = $_POST['apt_booking_id'];
    $apt_id= $_POST["apt_id"];
    $guest_id= $_POST["guest_id"];
    $booking_status_code= $_POST["booking_status_code"];
    $start_date= $_POST["start_date"];
    $end_date= $_POST["end_date"];
}

echo '<div class="container">';
echo '<h2>Edit Apartment Booking</h2>' ;   
echo '<p>Apartment Number: '; 
getApartments($dbc,$apt_id);
echo '</p>
<p>Guest: ';
getGuest($dbc,$guest_id);
 echo '</p>
<p>Booking Status: ';
getBookingStatus($dbc,$booking_status_code);
 echo '</p>
<p>Booking Start Date: <input type="text" name="start_date" size="10" maxlength="10" value="'.$start_date.'" /><label>(YYYY-MM-DD)</label></p>
<p>Booking End Date: <input type="text" name="end_date" size="10" maxlength="10" value="'.$end_date.'" /><label>(YYYY-MM-DD)</label></p>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="apt_booking_id" value="'. $apt_booking_id.'" />
<p><input type="submit" name="submit" value="Submit" /></p>
</form>';
echo '</div>'; 

//Validate and Submit to the Database
if (isset($_POST['submitted'])) {
    
    echo '<div class="Message_bar">';
    $errors = array(); 
    checkIfEmpty($_POST['start_date'],"Please enter booking start date.",$errors);
    checkIfEmpty($_POST['end_date'],"Please enter booking end date.",$errors);
    validateDate($_POST['start_date'],"Please enter valid start date.",$errors);
    validateDate($_POST['end_date'],"Please enter valid end date.",$errors);
     //if no errors in the vlaues selected, updation of the entries
    if (empty($errors)) { // If everything's OK.
        // Make the query.
        $query = "UPDATE apartment_bookings SET 
        apt_id='$apt_id',
        guest_id='$guest_id', 
        booking_status_code='$booking_status_code', 
        booking_start_date = '$start_date 00:00:00', 
        booking_end_date = '$end_date 00:00:00' 
        WHERE apt_booking_id = $apt_booking_id";
        updateTable($dbc,$query);
    }else {  // Report the errors.
        echo '<div class="error"><p class="error">The following error(s) occurred:<br/><ul>';
		foreach ($errors as $msg) { // Print each error.
			echo "<li>$msg</li>";
		} // End of foreach
		echo '</ul></p><p>Please try again.</p>';
    }
    echo '</div>';
}

?>