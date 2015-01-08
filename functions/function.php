<?php
error_reporting(0);
//require user classes for user and item
require_once("classes/terrans.class.php");
require_once("classes/zerg.class.php");
require_once("classes/protoss.class.php");
require_once("classes/item.class.php");
require_once("classes/challenge.class.php");

//session key
$seesionKey = 'user_session';


	
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
function pc_users($user,$challenge)
{	
	//get random item
	$userArray = array('terrans','zerg','protoss'); //default users
	foreach($userArray as $value){
		if($value!=$user){
			$remainUser[] = array("slug_name"=>create_slug($value),"name"=>$value,"user"=>get_user_values($value),"point"=>50,"challenge"=>$challenge,"item"=>array(get_user_item($challenge)));
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
	return @$_SESSION[$key];
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
//Remove users temp challenge values with temp challenge value and user result
function remove_users_temp_values($i)
{
	global $seesionKey;	
	if($i==0){
		//unset($_SESSION[$seesionKey]);
		
		//unset($_SESSION[$seesionKey][1]['user']['temp_challenge_value']);
		//unset($_SESSION[$seesionKey][2]);
		if(@$_SESSION[$seesionKey][1]!=NULL){
			$_SESSION[$seesionKey][1]['user']['temp_challenge_value'] = 0;
			$_SESSION[$seesionKey][1]['user']['result'] = '';
		}
		
		if(@$_SESSION[$seesionKey][2]!=NULL){
			$_SESSION[$seesionKey][2]['user']['temp_challenge_value'] = 0;
			$_SESSION[$seesionKey][2]['user']['result'] = '';
		}
	}
	else if($i==1){
		//unset($_SESSION[$seesionKey][2]);
		
		if(@$_SESSION[$seesionKey][2]!=NULL){
			$_SESSION[$seesionKey][2]['user']['temp_challenge_value'] = 0;
			$_SESSION[$seesionKey][2]['user']['result'] = '';
		}
	}
}

//Set user position based on challenge property
function set_users_position($challenge_property,$i)
{
	global $seesionKey;
	//calcuate user property
	$j=0;
	while($j<sizeof(@$_SESSION[$seesionKey]))
	{
		if($i==$j){
			$_SESSION[$seesionKey][$i]['user']['position'] = 1;
			//if user win add new item
			winTool($i);
		}
		else{
			$remain_user[] = $j;
		}
		$j++;
	}
	
	if(@$_SESSION[$seesionKey][$remain_user[0]]!=NULL){
		
		if(@$_SESSION[$seesionKey][$remain_user[0]]['user'][@$challenge_property]>@$_SESSION[$seesionKey][$remain_user[1]]['user'][@$challenge_property]){
				$_SESSION[$seesionKey][$remain_user[0]]['user']['position'] = 2;
				//unset($_SESSION[$seesionKey][$remain_user[0]]['item'][end($_SESSION[$seesionKey][$remain_user[0]]['item'])]);
		}
		else{
			$_SESSION[$seesionKey][$remain_user[0]]['user']['position'] = 3;
		}
	}
	
	if(@$_SESSION[$seesionKey][$remain_user[1]]!=NULL){
		if(@$_SESSION[$seesionKey][$remain_user[1]]['user'][$challenge_property]>@$_SESSION[$seesionKey][$remain_user[0]]['user'][$challenge_property]){
				$_SESSION[$seesionKey][$remain_user[1]]['user']['position'] = 2;
		}
		else{
			$_SESSION[$seesionKey][$remain_user[1]]['user']['position'] = 3;
		}
	}
	
	//remove item if user lose
	loseTool(@$remain_user);
	#return $reamin_user;	
}

//set new random challenge
function set_new_random_challenge()
{
	global $seesionKey;
 	//regenerate new challenge after set position
	$challenge = new challenge();
	$challenges_list = $challenge->get_challenges();
	//set randomly selected challenge to session
	set_session('user_challenge',$challenges_list);	
 	$j=0;
	while($j<sizeof($_SESSION[$seesionKey]))
	{
		$challenges_list['name'] = $_SESSION[$seesionKey][$j]['user']['name'];
		$_SESSION[$seesionKey][$j]['challenge'] = $challenges_list;
		$j++;
	}	
	
	/*$challenge = new challenge();
	$challenges_list = $challenge->get_challenges();
	//set randomly selected challenge to session
	set_session('user_challenge',$challenges_list);	
	$challenges_list['name'] = $_SESSION[$seesionKey][$i]['user']['name'];
	$_SESSION[$seesionKey][$i]['challenge'] = $challenges_list;
	foreach($remain_user as $user){
		$_SESSION[$seesionKey][$user]['challenge'] = $challenges_list;
	}*/
}

//set challenge property in array and return
function set_challenge_property_value($property,$value)
{
	return array('challenge_property'=>$property,'challenge_value'=>$value);
}

//reindex user session
function reindex_user_session()
{
	global $seesionKey;
	if(@$_SESSION[$seesionKey]!=NULL){
		$_SESSION[$seesionKey] = array_values(@$_SESSION[$seesionKey]);
	}
}

//increase and decrease success point
function increase_decrease_success_point($challengeType)
{
	if($challengeType=='carryOutChallenge')
		$successPoints = array(array('position'=>1,'point'=>15),array('position'=>2,'point'=>0),array('position'=>3,'point'=>(-5)));
	else if($challengeType=='carryOutChallengeWithCompanion')
		$successPoints = array(array('position'=>1,'point'=>9),array('position'=>2,'point'=>0),array('position'=>3,'point'=>(-5)));
	if($successPoints!=NULL)
	{	
	
 		global $seesionKey;
		
		
		//check if real user win remove all session
		$j=0;
		while($j<sizeof(@$_SESSION[$seesionKey]))
		{
			$userSuccessPoint = @$_SESSION[$seesionKey][$j]['user']['success_point'];
			if($userSuccessPoint<=0 || $userSuccessPoint>=100){
				if($_SESSION[$seesionKey][$j]['slug_name']==$_SESSION['real_user_name']['slug_name']){
						unset($_SESSION[$seesionKey]);
				}
 			}
			unset($userSuccessPoint);
			$j++;	
		}
		
		
	  		
		//checking success point limit stop increase and decrease if user success point reach 0 or 100
		$j=0;
		while($j<sizeof(@$_SESSION[$seesionKey]))
		{
			$userSuccessPoint = @$_SESSION[$seesionKey][$j]['user']['success_point'];
			if($userSuccessPoint<=0 || $userSuccessPoint>=100){
					//$_SESSION[$seesionKey][$j]['user']['success_point'] = "REMOVE THIS USER";
					$_SESSION[$seesionKey][$j] = '';
					unset($_SESSION[$seesionKey][$j]);
 			}
			unset($userSuccessPoint);
			$j++;	
		}
		
		reindex_user_session();
  
 		$j=0;
		while($j<sizeof(@$_SESSION[$seesionKey]))
		{
			$getPos = @$_SESSION[$seesionKey][$j]['user']['position'];
			$userSuccessPoint = @$_SESSION[$seesionKey][$j]['user']['success_point'];
			//get success point with position and match users position
			foreach($successPoints as $points)
			{
					if($points['position']==$getPos){
						if ($points['point']>0){
							 $_SESSION[$seesionKey][$j]['user']['success_point'] = ($userSuccessPoint + $points['point']);
						}
						else{
							 $_SESSION[$seesionKey][$j]['user']['success_point'] = ($userSuccessPoint - (abs($points['point'])));
 						}
					}
			}
			unset($userSuccessPoint);
			unset($getPos);
			$j++;	
		}
	}
}
//Add new random item when user win in session
function winTool($i)
{
	global $seesionKey;
	$userItems = new item();
	//get random item
	$newItem = $userItems->get_items_list(false);
	if($newItem!=NULL && (count($_SESSION[$seesionKey][$i]['item'])<3)){
		$_SESSION[$seesionKey][$i]['item'][] = $newItem;
	}
}
//Remove item when user lose in session
function loseTool($remain_user)
{
	global $seesionKey;
	//calcuate user property
	$j=0;
	while($j<sizeof($remain_user))
	{
		//return $_SESSION[$seesionKey][$remain_user[$j]]['item'];
		unset($_SESSION[$seesionKey][$remain_user[$j]]['item'][(count($_SESSION[$seesionKey][$remain_user[$j]]['item'])-1)]);
		$j++;	
	}
}

//play together decrease success point
function play_challenge_together()
{
		global $seesionKey;
		if($_SESSION[$seesionKey][0]!=NULL && $_SESSION[$seesionKey][1]!=NULL){
        	$_SESSION[$seesionKey][0]['user']['success_point'] = ($_SESSION[$seesionKey][0]['user']['success_point']-5);
			$_SESSION[$seesionKey][1]['user']['success_point'] = ($_SESSION[$seesionKey][1]['user']['success_point']-5);
		}
}
//decrease user success point new challenge
function new_challenge()
{
		global $seesionKey;
		if($_SESSION[$seesionKey][0]!=NULL){
        	$_SESSION[$seesionKey][0]['user']['success_point'] = ($_SESSION[$seesionKey][0]['user']['success_point']-5);
		}
}
?>