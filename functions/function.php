<?php
//require user classes for user and item
require_once("classes/terrans.class.php");
require_once("classes/zerg.class.php");
require_once("classes/protoss.class.php");
require_once("classes/item.class.php");
require_once("classes/challenge.class.php");

// create slug string
function create_slug($string){
   $slug = preg_replace('/[^A-Za-z0-9-]+/', '_', $string);
   return strtolower($slug);
}


function call_user_class($user)
{
	//Call user class
	if($user=='terrans')
		$userClass = new terrans();
	else if($user=='zerg')
		$userClass = new zerg();
	else if($user=='protoss')
		$userClass = new protoss();
	return $userClass;
}
function get_user_values($user)
{
	//get user values
	$userClass = call_user_class($user);
	$getUserValues = $userClass->get_values();
	return $getUserValues[$user];
}

//get item based on challenge property
function get_user_item($challenge)
{
	$userItems = new item();
	$propertyArray = array('health','stamina','speed','strength'); //default user property
	foreach($propertyArray as $value){
		if(array_key_exists($value,$challenge)){ // get challenge property type
			return $userItems->get_items_list($value); // get item based on challenge property
		}
	}
}

//Returns remain pc users array with 
function pc_users($user,$challenge,$itemlist)
{	
	$userArray = array('terrans','zerg','protoss'); //default users
	foreach($userArray as $value){
		if($value!=$user){
			$remainUser[] = array("slug_name"=>create_slug($value),"name"=>$value,"user"=>get_user_values($value),"point"=>50,"challenge"=>$challenge,"item"=>$itemlist);
		}
	}
	return $remainUser;
}

//Set session values by key
function set_session($key,$value)
{
	$_SESSION[$key] = $value;
}
//Get session values by key
function get_session($key)
{
	return $_SESSION[$key];
}

//get challenge property name
function get_challenge_property($property)
{
	$propertyArray = array('health','stamina','speed','strength'); //default user property
	foreach($propertyArray as $value){
		if(array_key_exists($value,$property)){ // get challenge property type
			$propertyValue['property'] = $value;
			$propertyValue['value'] = $property[$value];
			return $propertyValue;
			break;
		}
	}
}

//get user property name
function get_user_property($s,$property)
{
		if(array_key_exists($s,$property)){ // get user property type
			$propertyValue['property'] = $s;
			$propertyValue['value'] = $property[$s];
			return $propertyValue;
			break;
		}
}
//Remove remain users
function remove_remain_users($i)
{
	//session key
	$seesionKey = 'user_session';
 	/*$j=0;
	while($j<sizeof($_SESSION[$seesionKey]))
	{
		if($i==$j){
			
		}
		else{
			$reamin_user[] = $j;	
		}
		$j++;
	}
	
	$array = $_SESSION[$seesionKey];
	
	foreach($reamin_user as $val)
	{
		//unset($_SESSION[$seesionKey][$val]);
		//unset($array[$val]);
	}*/
	
	
	if($i==0){
		unset($_SESSION[$seesionKey][1]);
		unset($_SESSION[$seesionKey][2]);
	}
	else if($i==1){
		unset($_SESSION[$seesionKey][2]);
	}
	
	//unset($_SESSION[$seesionKey]);
	//$_SESSION[$seesionKey] = array_values($array);
	
	 
}
?>