<?php

//Check if the field is Empty
function checkIfEmpty($value,$message,& $errors){
    if (empty($value)) {
		$errors[] = $message;
	}  
}
//Check if the field is Numeric
function checkIfNumeric($value,$message,& $errors){
    if (!empty($value)&&!is_numeric($value)) {
		$errors[] = $message;
	}  
}

?>