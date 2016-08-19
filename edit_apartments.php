<?php # 

$page_title = 'Edit Apartment';
include ('connect_to_sql.php');
include ('menu.php');
include ('validate.php');
include ('common_functions.php');
echo '<link rel="stylesheet" href="styles.css" type="text/css">';


// Function to get Building Name and ID
function getBuilding($db,$building_id){
    $result = @mysqli_query($db, "select building_id, building_full_name from apartment_buildings"); 
     echo '<select name="building_id">';
    if($result){
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
            if($row["building_id"]==$building_id){
                echo '<option value="'.$row["building_id"].'" selected="selected">'.$row["building_full_name"].'</option>';
            }else{
                 echo '<option value="'.$row["building_id"].'">'.$row["building_full_name"].'</option>';
            }
        }
    }
    echo '</select>';   
}

// Function to get Apt type code and description
function getAptType($db,$apt_type){
    $result = @mysqli_query($db, "select apt_type_code,apt_type_description from ref_apartment_types"); 
     echo '<select name="apt_type_code">';
    if($result){
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
             if($row["apt_type_code"]==$apt_type){
                echo '<option value="'.$row["apt_type_code"].'" selected="selected">'.$row["apt_type_description"].'</option>';
             }else{
                echo '<option value="'.$row["apt_type_code"].'">'.$row["apt_type_description"].'</option>';
             }
        }
    }
    echo '</select>';   
}

//Get Apartment Details
function getApartmentDetails($db,$apt_id){
    $query = "select apt_id,building_id,apt_type_code,apt_number,bathroom_count,bedroom_count,room_count from apartments where apt_id=$apt_id";
    $result = @mysqli_query($db,$query); 
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    return $row;
}

// Create the form.
echo '<form action="edit_apartments.php" method="post">';
$building_id = "";
$apt_type= "";
$apt_num= "";
$bed_count= "";
$bath_count= "";
$room_count= "";
$apt_id = "";

//Only if Apt id know we can edit the apartment
if (isset($_GET['apt_id'])) {	
    $apt_id = $_GET['apt_id'];
    $apartment = getApartmentDetails($dbc,$apt_id);
    $building_id = $apartment["building_id"];
    $apt_type=$apartment["apt_type_code"];
    $apt_num=$apartment["apt_number"];
    $bed_count=$apartment["bedroom_count"];
    $bath_count=$apartment["bathroom_count"];
    $room_count=$apartment["room_count"];
}

//Populate Value from Form Submit - Stickeness
if (isset($_POST['apt_id'])) {	
    $apt_id = $_POST['apt_id'];
    $building_id = $_POST["building_id"];
    $apt_type=$_POST["apt_type_code"];
    $apt_num=$_POST["apt_number"];
    $bed_count=$_POST["bedroom_count"];
    $bath_count=$_POST["bathroom_count"];
    $room_count=$_POST["room_count"];
}

echo '<div class="container">';
echo '<h2>Edit Apartment -  Apartment Number:'.$apt_num.'</h2>' ;   
echo '<p>Apartment Building: '; 
getBuilding($dbc,$building_id);
echo '</p>
<p>Apartment Type: ';
getAptType($dbc,$apt_type);
 echo '</p>
<p>Apartment Number: <input type="text" name="apt_number" size="10" maxlength="10" value="'.$apt_num.'" /><label>(Numeric)</label></p>
<p>Bedroom Count: <input type="text" name="bedroom_count" size="10" maxlength="10" value="'.$bed_count.'" /><label>(Numeric)</label></p>
<p>Bathroom Count: <input type="text" name="bathroom_count" size="10" maxlength="10" value="'.$bath_count.'" /><label>(Numeric)</label></p>
<p>Total rooms: <input type="text" name="room_count" size="10" maxlength="10" value="'.$room_count.'" /><label>(Numeric)</label></p>

<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="apt_id" value="'. $apt_id.'" />
<p><input type="submit" name="submit" value="Submit" /></p>
</form>';
echo '</div>'; 

//Validate and Submit to the Database
if (isset($_POST['submitted'])) {
    
    echo '<div class="Message_bar">';
    $errors = array(); 
    checkIfEmpty($_POST['building_id'],"Please Select a building.",$errors);
    checkIfEmpty($_POST['apt_type_code'],"Please Select apartment type.",$errors);
    checkIfEmpty($_POST['apt_number'],"Please input apartment number.",$errors);
    checkIfEmpty($_POST['bathroom_count'],"Please input bathroom count.",$errors);
    checkIfEmpty($_POST['bedroom_count'],"Please input bedroom count.",$errors);
    checkIfEmpty($_POST['room_count'],"Please input total room count.",$errors);
    checkIfNumeric($_POST['apt_number'],"Please input numeric value for Apt Number count.",$errors);
    checkIfNumeric($_POST['bathroom_count'],"Please input numeric value for bathroom count.",$errors);
    checkIfNumeric($_POST['bedroom_count'],"Please input numeric value for bedroom count.",$errors);
    checkIfNumeric($_POST['room_count'],"Please input numeric value for total room count.",$errors);

    //if no errors in the vlaues selected, updation of the entries
    if (empty($errors)) { // If everything's OK.
        // Make the query.
        $query = "UPDATE apartments SET 
        building_id='$building_id',
        apt_type_code='$apt_type', 
        apt_number='$apt_num', 
        bathroom_count='$bath_count', 
        bedroom_count='$bed_count', 
        room_count='$room_count'
        WHERE apt_id = $apt_id";
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