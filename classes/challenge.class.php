<?php
class challenge{
	public $challenge;
	//constructor
	public function __construct() {
	 	$this->challenge = array(
								  array( 'title' => "Challenge Title 1",'description' => 'Short Description 1','health' => 80),
								  array( 'title' => "Challenge Title 2",'description' => 'Short Description 2','stamina' => 70),
								  array( 'title' => "Challenge Title 3",'description' => 'Short Description 3','speed' => 100),
								  array( 'title' => "Challenge Title 4",'description' => 'Short Description 4','strength' => 90),
								  array( 'title' => "Challenge Title 5",'description' => 'Short Description 5','strength' => 100),
								  array( 'title' => "Challenge Title 6",'description' => 'Short Description 6','strength' => 90),
								  array( 'title' => "Challenge Title 7",'description' => 'Short Description 7','strength' => 100)
				                );
   }
   /**
   * Get Challenge List
   */
  public function get_challenges() {
    	return $this->challenge[array_rand($this->challenge,1)];
  }
}