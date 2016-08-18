<?php # 

$page_title = 'Add Guests';
include ('connect_to_sql.php');
include ('menu.php');
include ('validate.php');
include ('common_functions.php');
echo '<link rel="stylesheet" href="styles.css" type="text/css">';


// Create the form.
echo '<form action="add_guests.php" method="post">';
$guest_id = "";
$guest_first_name= "";
$guest_last_name= "";
$guest_date_of_birth= "";
$guest_gender="";
//Populate Value from Form Submit - Stickeness
if (isset($_POST['submitted'])) {   
    $guest_first_name= $_POST["guest_first_name"];
    $guest_last_name= $_POST["guest_last_name"];
    $guest_date_of_birth= $_POST["guest_date_of_birth"];
    $guest_gender= $_POST["guest_gender"];
}

echo '<div class="container">';
echo '<h2>Add Guest Detail</h2>' ;   

echo '  
<p>First Name: <input type="text" name="guest_first_name" size="10" maxlength="10" value="'.$guest_first_name.'" /></p>
<p>Last Name: <input type="text" name="guest_last_name" size="10" maxlength="10" value="'.$guest_last_name.'" /></p>
<p>Date of Birth: <input type="text" name="guest_date_of_birth" size="10" maxlength="10" value="'.$guest_date_of_birth.'" /></p>
<p>Gender: <input type="text" name="guest_gender" size="10" maxlength="1" value="'.$guest_gender.'" /></p>';


if(!isset($_POST['submitted'])){
    printFormSubmit();
}

//Validate and Submit to the Database
if (isset($_POST['submitted'])) {
    
    $errors = array(); 
    checkIfEmpty($_POST['guest_first_name'],"Please enter first name.",$errors);
    checkIfEmpty($_POST['guest_last_name'],"Please enter last name.",$errors);
    checkIfEmpty($_POST['guest_date_of_birth'],"Please enter date of birth.",$errors);
    checkIfEmpty($_POST['guest_gender'],"Please enter gender.",$errors);
    if (!empty($errors)) { 
         printFormSubmit();
    }else{
        echo '</form></div>';
    }
    
    echo '<div class="Message_bar">';

     //if no errors in the vlaues selected, updation of the entries
    if (empty($errors)) { // If everything's OK.
         // Make the query.
        $query = "INSERT INTO guests(guest_first_name,guest_last_name,guest_date_of_birth,guest_gender)
        VALUES ('$guest_first_name','$guest_last_name','$guest_date_of_birth 00:00:00','$guest_gender')";
        addTable($dbc,$query);
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