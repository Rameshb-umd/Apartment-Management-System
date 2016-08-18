<?php # 

$page_title = 'View Facilities';
include ('connect_to_sql.php');
include ('common_functions.php');
include ('menu.php');
echo '<link rel="stylesheet" href="styles.css" type="text/css">';


//Print the table Header
function printTableHeader(){
    echo '<tr class="header">
                <th> Apartment Number </th>
                <th> Facilties Information </th>
        </tr>'; 
}

//Function to get List of Guests;
function getListofFacilities ($db,$apt_id){     
        $query = " select apt_number, facility_description from apartments aa,apartment_facilities a, ref_apartment_facilitiies rf where aa.apt_id = a.apt_id and               a.facility_code=rf.facility_code and a.apt_id=$apt_id order by facility_description asc ";
        $result = @mysqli_query($db, $query); 
        if($result){
            $count=0;$css="even";
            while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
                if($count%2==0){$css="even";}else{$css="odd";}
                $count++;
                echo '<tr class="detail '.$css.'">
                        <td>'.$row['apt_number'].'</td>
                        <td>'.$row['facility_description'].'</td>
                    </tr>'; 
            }
            if($count==0){
                 echo '<tr class="detail '.$css.'">
                        <td colspan=2>No Data found for this apartment.</td>
                    </tr>'; 
            }
        }
}

if (isset($_GET['apt_id'])) {
	$apt_id = $_GET['apt_id'];
} else {
	$apt_id="0";
}

echo '<div class="container">';
echo '<div style="width:80%">';
//Page Header
echo '<h1>Available Facilities</h1>';
echo '<table>';
printTableHeader();
getListofFacilities($dbc,$apt_id);
echo '</table>';
echo '</div>';
echo '</div>';


?>