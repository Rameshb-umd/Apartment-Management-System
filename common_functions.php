<?php

//This Page contains all common Methods for the Application

// Number of records to show per page:
$display = 5;

//Get Number of Records in the table
function getTotalPages($db,$limit,$query){
        $result = @mysqli_query($db, $query); 
        $row = mysqli_fetch_array($result, MYSQL_NUM);
        $noOfrecords=$row[0];
    
        if ($noOfrecords > $limit) { // More than 1 page.
            $num_pages = ceil ($noOfrecords/$limit);
        } else {
            $num_pages = 1;
        }
    return $num_pages;
    
}

//Pagination
function pagination($totalpages,$Start_page,$display,$action,$sortby,$orderby){
    if ($totalpages > 1) {

        echo '<div class="Pagination">';
        // Determine what page the script is on.	
        $current_page = ($Start_page/$display) + 1;

        // If it's not the first page, make a First button and a Previous button.
        if ($current_page != 1) {
            echo '<a href="'.$action.'?s=0&np=' . $totalpages . '&sort=' . $sortby . '&orderby=' . $orderby . '">First</a> ';
            echo '<a href="'.$action.'?s=' . ($Start_page - $display) . '&np=' . $totalpages . '&sort=' . $sortby . '&orderby=' . $orderby . '
            ">Previous</a> ';
        }

        // Make all the numbered pages.
        for ($i = 1; $i <= $totalpages; $i++) {
            if ($i != $current_page) {
                echo '<a href="'.$action.'?s=' . (($display * ($i - 1))) . '&np=' . $totalpages . '&sort=' . $sortby . '&orderby=' . $orderby . '">
                ' . $i . '</a> ';
            } else {
                echo $i . ' ';
            }
        }

        // If it's not the last page, make a Last button and a Next button.
        if ($current_page != $totalpages) {
            echo '<a href="'.$action.'?s=' . ($Start_page + $display) . '&np=' . $totalpages . '&sort=' . $sortby . '&orderby=' . $orderby . '">Next</a> ';
            echo '<a href="'.$action.'?s=' . (($totalpages-1) * $display) . '&np=' . $totalpages . '&sort=' . $sortby . '&orderby=' . $orderby . '">Last</a>';

        }	
        echo '</div>';

    } 
}

//update data in the table
function updateTable($dbc,$query){
    $result = @mysqli_query ($dbc, $query); // Run the query.
    if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
        echo 'The record has been edited.<br/>';								
    } else { // If query did not run OK.
        echo '<p class="error">The record could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
        exit();
    }
}

//Add data in the table
function addTable($dbc,$query){
    $result = @mysqli_query ($dbc, $query); // Run the query.
    if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
        echo 'The record has been added.<br/>';								
    } else { // If query did not run OK.
        echo '<p class="error">The record could not be added due to a system error. We apologize for any inconvenience.</p>'; // Public message.
        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
        exit();
    }
}


//Delete record from the Table
function deleteTable($dbc,$query){
    $result = @mysqli_query ($dbc, $query); // Run the query.
    if ((mysqli_affected_rows($dbc) == 1) || (mysqli_affected_rows($dbc) == 0)) { 
        echo 'This record has been deleted.<br/>';								
    } else { // If query did not run OK.
        echo '<p class="error">The record could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
        echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>'; // Debugging message.
        exit();
    }
}

// Check if the apartment is under use.
function checkApartmentBooked($dbc,$apt_id){
    $query = "select count(1) from apartment_bookings where apt_id=$apt_id";
    $result = @mysqli_query ($dbc, $query); // Run the query.
    $row = mysqli_fetch_array($result, MYSQL_NUM);
    $noOfrecords=$row[0];
    if($noOfrecords>1){
        return true;
    }else{
        return false;
    }
}

//get max apartment id
function getApartmentId($dbc){
    $query = "select max(apt_id) from apartments";
    $result = @mysqli_query ($dbc, $query); // Run the query.
    $row = mysqli_fetch_array($result, MYSQL_NUM);
    $noOfrecords=$row[0];
    return $noOfrecords;
}

//print submit button
function printFormSubmit(){
    echo '<input type="hidden" name="submitted" value="TRUE" />
    <p><input type="submit" name="submit" value="Submit" /></p>';
    echo '</form></div>';
}

?>

