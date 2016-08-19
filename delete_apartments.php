<?php # edit_course.php

$page_title = 'Delete Apartment';
include ('connect_to_sql.php');
include ('menu.php');
include ('validate.php');
include ('common_functions.php');
echo '<link rel="stylesheet" href="styles.css" type="text/css">';

//Get Apartment Details
function getApartmentDetails($db,$apt_id){
    $query = "SELECT   ab.building_full_name,
                        ab.building_short_name,
                        a.building_id,
                        a.apt_number,a.apt_id,
                        at.apt_type_description,a.bathroom_count,a.bedroom_count
                    FROM
                        apartments a,
                        apartment_buildings ab,
                        ref_apartment_types at
                    WHERE a.building_id = ab.building_id
                            AND a.apt_type_code = at.apt_type_code and a.apt_id=$apt_id";
    $result = @mysqli_query($db,$query); 
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    return $row;
}

// Create the form.
echo '<form action="delete_apartments.php" method="post">';
$building_name="";
$apt_num="";
$apt_type_desc="";

//Only if Apt id know we can delete the apartment
if (isset($_GET['apt_id'])) {	
    $apt_id = $_GET['apt_id'];
    $apartment = getApartmentDetails($dbc,$apt_id);
    $building_name = $apartment["building_full_name"];
    $apt_num=$apartment["apt_number"];
    $apt_type_desc=$apartment["apt_type_description"];
}

//Populate Value from Form Submit - Stickeness
if (isset($_POST['apt_id'])) {	
    $apt_id = $_POST['apt_id'];
    $apartment = getApartmentDetails($dbc,$apt_id);
    $building_name = $apartment["building_full_name"];
    $apt_num=$apartment["apt_number"];
    $apt_type_desc=$apartment["apt_type_description"];
}

echo '<div class="container">';
echo '<h2>Delete apartment</h2>
        <h3>Apartment Number: ' . $apt_num . '</h3>
        <h3>Building Name: ' . $building_name . '</h3>
        <h3>Apartment Type: ' . $apt_type_desc. '</h3>';	

//Create Form Elements
if(isset($_GET['apt_id'])){
	echo '<p>Are you sure you want to delete this Course?<br />
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No</p>
	<p><input type="submit" name="submit" value="Submit!" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="apt_id" value="' . $apt_id . '" /> '; 		
}
echo '</form>';
echo '</div>';

// Performing Business Logic When Submitted
if (isset($_POST['submitted'])) {
    echo '<div class="Message_bar">';
    if ($_POST['sure'] == 'Yes') {
            echo '<h3 id="mainhead">Message from Database:</h3>';
			$query = "DELETE FROM apartments WHERE apt_id=$apt_id";
            if(!checkApartmentBooked($dbc,$apt_id)){
			     deleteTable($dbc,$query);
                echo'<p>The Apartment <b>'.$apt_num.'</b> of type <b>'.$apt_type_desc.'</b> in building 
                <b>'.$building_name.'</b> has been deleted.</p>';
            }else{
                echo'<p>The Apartment <b>'.$apt_num.'</b> of type <b>'.$apt_type_desc.'</b> in building 
                <b>'.$building_name.'</b> cannot be deleted since there is a open booking for the apartment.</p>';
            }
		}else{ 
			echo '<h3 id="mainhead">Message from Database:</h3>';
            echo'<p>The Apartment <b>'.$apt_num.'</b> of type <b>'.$apt_type_desc.'</b> in building 
            <b>'.$building_name.'</b> has NOT been deleted.</p>';	
		} 
    echo '</div>';
}




?>