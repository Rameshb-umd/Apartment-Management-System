<?php # 

$page_title = 'View Apartment booking';
include ('connect_to_sql.php');
include ('common_functions.php');
include ('menu.php');
echo '<link rel="stylesheet" href="styles.css" type="text/css">';

//Print the table Header
function printTableHeader($sortby){
    
    $current_link = $_SERVER['PHP_SELF'];
    switch ($sortby) {
        case 'apartment':
            $link1="$current_link?sort=apartment&orderby=desc";
            $link2="$current_link?sort=guest&orderby=asc";
            $link3="$current_link?sort=start_date&orderby=asc";
            $link4="$current_link?sort=end_date&orderby=asc";
            $link5="$current_link?sort=booking_status_description&orderby=asc";
            break;
        case 'guest':
            $link1="$current_link?sort=apartment&orderby=asc";
            $link2="$current_link?sort=guest&orderby=desc";
            $link3="$current_link?sort=start_date&orderby=asc";            
            $link4="$current_link?sort=end_date&orderby=asc";
            $link5="$current_link?sort=booking_status_description&orderby=asc";
            break;
        case 'start_date':
            $link1="$current_link?sort=apartment&orderby=asc";
            $link2="$current_link?sort=guest&orderby=asc";
            $link3="$current_link?sort=start_date&orderby=desc";            
            $link4="$current_link?sort=end_date&orderby=asc";
            $link5="$current_link?sort=booking_status_description&orderby=asc";
			break;
        case 'end_date':
            $link1="$current_link?sort=apartment&orderby=asc";
            $link2="$current_link?sort=guest&orderby=asc";
            $link3="$current_link?sort=start_date&orderby=asc";            
            $link4="$current_link?sort=end_date&orderby=desc";
            $link5="$current_link?sort=booking_status_description&orderby=asc";
			break;
        case 'booking_status_description':
            $link1="$current_link?sort=apartment&orderby=asc";
            $link2="$current_link?sort=guest&orderby=asc";
            $link3="$current_link?sort=start_date&orderby=asc";            
            $link4="$current_link?sort=end_date&orderby=asc";
            $link5="$current_link?sort=booking_status_description&orderby=desc";
			break;
		default:
			break;
    }
     
    echo '<tr class="header">
                <th> Edit </th>
                <th> Delete </th>
                <th> <a href="'.$link1.'">Apartment Number</a></th>
                <th> <a href="'.$link2.'">Guest Name</a></th>
                <th> <a href="'.$link3.'">Start Date</a></th>
                <th> <a href="'.$link4.'">End Date</a></th>
                <th> <a href="'.$link5.'">Booking Status</a></th>
        </tr>'; 
}

//Function to get List of Apartment;
function getListofApartmentBookings ($db,$start,$noOfRecords,$sortby,$orderby){     
        $query = " SELECT 
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
                            AND aa.building_id = ap.building_id
        order by $sortby $orderby LIMIT $start,$noOfRecords ";
        $result = @mysqli_query($db, $query); 
        if($result){
            $count=0;$css="even";
            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
                if($count%2==0){$css="even";}else{$css="odd";}
                $count++;
                echo '<tr class="detail '.$css.'">
                        <td><a href="edit_apartment_bookings.php?apt_booking_id='.$row['apt_booking_id'].'">Edit</a></td>
                        <td><a href="delete_apartment_bookings.php?apt_booking_id='.$row['apt_booking_id'].'">Delete</a></td>
                        <td> '.$row['apartment'].'</td>
                        <td> '.$row['guest'].'</td>  
                        <td> '.$row['start_date'].'</td>
                        <td> '.$row['end_date'].'</td>
                        <td> '.$row['booking_status_description'].'</td>
                        </tr>'; 
            }
        }
}



// Get Number of pages from Parameter, If not found query Database
if (isset($_GET['np'])) {
    $pages = $_GET['np'];
}else{
    $pages = getTotalPages($dbc,$display,"select count(1) from apartment_bookings");    
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
	$sortby="apartment";
}
if (isset($_GET['orderby'])) {
	$orderby = $_GET['orderby'];
} else {
	$orderby="asc";
}

//Forms
echo '<div class="container">';
echo '<div style="width:80%">';
//Page Header
echo '<h1>Apartment Bookings Details</h1>';
//Pagination Top
pagination($pages,$start,$display,'view_apartment_bookings.php',$sortby,$orderby);
echo '<table>';
printTableHeader($sortby);
getListofApartmentBookings($dbc,$start,$display,$sortby,$orderby);
echo '</table>';
//Pagination Bottom
pagination($pages,$start,$display,'view_apartment_bookings.php',$sortby,$orderby);
echo '</div>';
echo '</div>';
?>