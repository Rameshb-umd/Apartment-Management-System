<?php # 

$page_title = 'Edit Apartment Bookings';
include ('connect_to_sql.php');
include ('menu.php');
include ('validate.php');
include ('common_functions.php');
echo '<link rel="stylesheet" href="styles.css" type="text/css">';

//Get Apartment Details
function getGuestDetails($db,$guest_id){
    $query = "select guest_id, guest_first_name,guest_last_name, DATE_FORMAT(guest_date_of_birth, '%Y-%m-%d') guest_date_of_birth, guest_gender
                from guests where guest_id=$guest_id";
    $result = @mysqli_query($db,$query); 
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    return $row;
}

// Create the form.
echo '<form action="edit_guests.php" method="post">';
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
    $guest_id = $_POST['guest_id'];
    $guest_first_name= $_POST["guest_first_name"];
    $guest_last_name= $_POST["guest_last_name"];
    $guest_date_of_birth= $_POST["guest_date_of_birth"];
    $guest_gender= $_POST["guest_gender"];
}

echo '<div class="container">';
echo '<h2>Edit Guest Detail</h2>' ;   

echo '  
<p>First Name: <input type="text" name="guest_first_name" size="10" maxlength="50" value="'.$guest_first_name.'" class="textbox"/></p>
<p>Last Name: <input type="text" name="guest_last_name" size="10" maxlength="50" value="'.$guest_last_name.'" class="textbox"/></p>
<p>Date of Birth: <input type="text" name="guest_date_of_birth" size="10" maxlength="10" value="'.$guest_date_of_birth.'" class="textbox"/>(YYYY-MM-DD)</p>
<p>Gender: <input type="text" name="guest_gender" size="10" maxlength="1" value="'.$guest_gender.'" class="textbox"/><label>(M/F)</label></p>

<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="guest_id" value="'. $guest_id.'" />
<p><input type="submit" name="submit" value="Submit" /></p>
</form>';
echo '</div>'; 

//Validate and Submit to the Database
if (isset($_POST['submitted'])) {
    
    echo '<div class="Message_bar">';
    $errors = array(); 
    checkIfEmpty($_POST['guest_first_name'],"Please enter first name.",$errors);
    checkIfEmpty($_POST['guest_last_name'],"Please enter last name.",$errors);
    checkIfEmpty($_POST['guest_date_of_birth'],"Please enter date of birth.",$errors);
    checkIfEmpty($_POST['guest_gender'],"Please enter gender.",$errors);
    validateDate($_POST['guest_date_of_birth'],"Please enter valid date of birth.",$errors);

     //if no errors in the vlaues selected, updation of the entries
    if (empty($errors)) { // If everything's OK.
        // Make the query.
        $query = "UPDATE guests SET 
        guest_first_name='$guest_first_name',
        guest_last_name='$guest_last_name', 
        guest_gender='$guest_gender', 
        guest_date_of_birth = '$guest_date_of_birth 00:00:00'
        WHERE guest_id = $guest_id";
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