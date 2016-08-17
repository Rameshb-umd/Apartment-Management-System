<?php # 

$page_title = 'View Guests';
include ('connect_to_sql.php');
include ('common_functions.php');
include ('menu.php');


echo '<link rel="stylesheet" href="styles.css" type="text/css">';


//Print the table Header
function printTableHeader($sortby){
    
    $current_link = $_SERVER['PHP_SELF'];
    switch ($sortby) {
        case 'guest_first_name':
            $link1="$current_link?sort=guest_first_name&orderby=desc";
            $link2="$current_link?sort=guest_last_name&orderby=asc";
            $link3="$current_link?sort=dob&orderby=asc";
            $link4="$current_link?sort=Guest_gender&orderby=asc";
            break;
        case 'guest_last_name':
            $link1="$current_link?sort=guest_first_name&orderby=asc";
            $link2="$current_link?sort=guest_last_name&orderby=desc";
            $link3="$current_link?sort=dob&orderby=asc";            
            $link4="$current_link?sort=Guest_gender&orderby=asc";
            break;
        case 'dob':
            $link1="$current_link?sort=guest_first_name&orderby=asc";
            $link2="$current_link?sort=guest_last_name&orderby=asc";
            $link3="$current_link?sort=dob&orderby=desc";            
            $link4="$current_link?sort=Guest_gender&orderby=asc";
			break;
        case 'Guest_gender':
            $link1="$current_link?sort=guest_first_name&orderby=asc";
            $link2="$current_link?sort=guest_last_name&orderby=asc";
            $link3="$current_link?sort=dob&orderby=asc";            
            $link4="$current_link?sort=Guest_gender&orderby=desc";
			break;
		default:
			break;
    }
     
    echo '<tr class="header">
                <th> Edit </th>
                <th> Delete </th>
                <th> <a href="'.$link1.'">First Name</a></th>
                <th> <a href="'.$link2.'">last Name </a></th>
                <th> <a href="'.$link3.'">Date of Birth</a></th>
                <th> <a href="'.$link4.'">Guests Gender</a></th>
        </tr>'; 
}

//Function to get List of Guests;
function getListofGuest ($db,$start,$noOfRecords,$sortby,$orderby){     
        $query = " select guest_id, guest_first_name,guest_last_name, date_format(guest_date_of_birth,'%m-%d-%Y') dob, Guest_gender from guests
        order by $sortby $orderby LIMIT $start,$noOfRecords ";
        $result = @mysqli_query($db, $query); 
        if($result){
            $count=0;$css="even";
            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
                if($count%2==0){$css="even";}else{$css="odd";}
                $count++;
                echo '<tr class="detail '.$css.'">
                        <td><a href="edit_guests.php?guest_id='.$row['guest_id'].'">Edit</a></td>
                        <td><a href="delete_guests.php?guest_id='.$row['guest_id'].'">Delete</a></td>
                        <td> '.$row['guest_first_name'].'</td>
                        <td> '.$row['guest_last_name'].'</td>  
                        <td> '.$row['dob'].'</td>  
                        <td> '.$row['Guest_gender'].'</td>
                        </tr>'; 
            }
        }
}



// Get Number of pages from Parameter, If not found query Database
if (isset($_GET['np'])) {
    $pages = $_GET['np'];
}else{
    $pages = getTotalPages($dbc,$display,"select count(*) from guests");    
}
//Get start record from parameter, if not found use zero
if (isset($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}

if (isset($_GET['sort'])) {
	$sortby = $_GET['sort'];
} else {
	$sortby="guest_first_name";
}
if (isset($_GET['orderby'])) {
	$orderby = $_GET['orderby'];
} else {
	$orderby="asc";
}
echo '<div class="container">';
echo '<div style="width:80%">';
//Page Header
echo '<h1>Guest Directory</h1>';

//Pagination Top
pagination($pages,$start,$display,'view_guests.php',$sortby,$orderby);

echo '<table>';
printTableHeader($sortby);
getListofGuest($dbc,$start,$display,$sortby,$orderby);
echo '</table>';

//Pagination Bottom
pagination($pages,$start,$display,'view_guests.php',$sortby,$orderby);
echo '</div>';
echo '</div>';


?>