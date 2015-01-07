<?php
//require config and functions
require_once("config.php");
require_once("functions/function.php");

$q = trim($_REQUEST['q']);

if($q=='start')
{
	
	
	$userItems = new item();
	
	#var_dump($userItems->get_items_list('health'));
	
		//get name and requested user name
		$name = trim(@$_REQUEST['name']);
		$user = trim(@$_REQUEST['user']);
		$slug_name = create_slug($name);
		
		//Call challenge class
		require_once("classes/challenge.class.php");
		$challenge = new challenge();
		$challenges_list = $challenge->get_challenges();
		$challenges_list['name'] = $user;
		
		#var_dump($challenges_list);
		
		//storing user session based on selected character
/*		$user_session = array( 
								array($slug_name=>array("name"=>$name,"user"=>get_user_values($user),"point"=>50,"challenge"=>$challenges_list,"item"=>get_user_item($challenges_list)))
								
							 );
*/		

  		//storing user session variable with random challenge and item
		$user_session = array( 
								array("slug_name"=>$slug_name,"name"=>$name,"user"=>get_user_values($user),"point"=>50,"challenge"=>$challenges_list,"item"=>array(get_user_item($challenges_list)))
							 );
							 
	 						
		$user_session = array_merge($user_session,pc_users($user,$user_session[0]['challenge'],$user_session[0]['item']));
		
 
							 
		#echo "<pre>";
		#print_r($user_session);
		#echo "</pre>";
		
		#exit;
		
		//storing user variable in session
		set_session('user_session',$user_session);
		
		//set session for selected challange
		set_session('user_challenge',$challenges_list);
		
		echo json_encode($challenges_list);
}
else if($q=='choose_challenge')
{
		//get user session details
		$getUsers = get_session('user_session');
		echo json_encode($getUsers);
		#echo "<pre>";
		#print_r($getUsers);
		#echo "</pre>";

}
else if($q=='play_challenge' || $q=='next_challenge')
{	
			//session key
			$seesionKey = 'user_session';
		
			if($q=='play_challenge'){
				
			}
			else if($q=='next_challenge'){
				set_new_random_challenge();
			}
			//get user session details
			$getUsers = get_session($seesionKey);
			
			//increase and decrease user property values
			$j = 0;
			while($j<sizeof($getUsers))
			{
				
				//get challenge property
				$getUsers_challenge = get_session($seesionKey);
				$challenge_property = get_challenge_property($getUsers_challenge[0]['challenge']);
			
				//get user property based on challenge property
				$gerUserProperty = get_user_property($challenge_property['property'],$getUsers_challenge[$j]['user']);
				
				//if($challenge_property['value']!=NULL)
				//{
					//$_SESSION[$seesionKey][$j]['user'][$gerUserProperty['property']] = 0;
					//decrease user property with challenge property and updating result
					$decreaseProperty = ($challenge_property['value']-$gerUserProperty['value']);
					if(($decreaseProperty)<=0){
						@$_SESSION[$seesionKey][0]['challenge'][$challenge_property['property']] = 0;
						if(@$_SESSION[$seesionKey][1]!=NULL){
							$_SESSION[$seesionKey][1]['challenge'][$challenge_property['property']] = 0;
						}
						if(@$_SESSION[$seesionKey][2]!=NULL){
							$_SESSION[$seesionKey][2]['challenge'][$challenge_property['property']] = 0;
						}
						
						$_SESSION[$seesionKey][$j]['user']['result'] = 'won';
						$_SESSION[$seesionKey][$j]['user']['temp_challenge_value'] = 0;
						//remove temp challenge values
						remove_users_temp_values($j);
						//remove temp challenge values
						set_users_position($challenge_property['property'],$j);
						break;
					}
					else{
						@$_SESSION[$seesionKey][0]['challenge'][$challenge_property['property']] = $decreaseProperty;
						
						if(@$_SESSION[$seesionKey][1]!=NULL){
							$_SESSION[$seesionKey][1]['challenge'][$challenge_property['property']] = $decreaseProperty;
						}
						if(@$_SESSION[$seesionKey][2]!=NULL){
							$_SESSION[$seesionKey][2]['challenge'][$challenge_property['property']] = $decreaseProperty;
						}
						
						$_SESSION[$seesionKey][$j]['user']['temp_challenge_value'] = $_SESSION[$seesionKey][0]['challenge'][$challenge_property['property']];
						//player loose the game
						$_SESSION[$seesionKey][$j]['user']['result'] = 'lose';
					}
	
					
					 
				//{
					
					
				//}
				//else{
				//	$_SESSION[$seesionKey][$j]['user']['result'] = 'won';
				//	break;
				//}
				
				unset($gerUserProperty,$decreaseProperty,$challenge_property,$getUsers_challenge);
				$j++;
			}
			
			
			//var_dump(increase_decrease_success_point('carryOutChallenge'));
			//increase and decrease success point based on user position
			increase_decrease_success_point('carryOutChallenge');
			
			
			
			//$_SESSION[$seesionKey][0]['user']['health'] = 60;
			#var_dump($challenge_property);
			
		
		//get challenge values and property
		$challenge_property_data = get_challenge_property(get_session('user_challenge'));
 		
		//get user session details
		$getUsers = array_merge(array(array_values(get_session($seesionKey))),array(set_challenge_property_value($challenge_property_data['property'],$challenge_property_data['value'])));
		//$getUsers = array_merge(get_session($seesionKey),array('challenge_property'=>$challenge_property_data['property']));
		
		#var_dump($getUsers);
 		
		#exit;
		#echo "<pre>";
		#print_r($getUsers);
		#echo "</pre>";
		echo json_encode($getUsers);
}
?>