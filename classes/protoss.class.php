<?php
//require parent class
require_once("character.class.php");
class protoss extends Character {
  //declare properties of the class
  public $name;
  public $health;
  public $stamina;
  public $speed;
  public $strength;
  public $items = array();
  public $success = 50;
  
  //constructor
  public function __construct() {
	/**
   	  * Set Values For Protoss
   	  */
    parent::__construct('Protoss',100,40,30,50);
    $this->name = parent::get_name();
	$this->health = parent::get_health();
	$this->stamina = parent::get_stamina();
	$this->strength = parent::get_strength();
	$this->speed = parent::get_speed();
	$this->items = parent::get_items();
  }
  /**
   * Get Values For Protoss
   */
  public function get_values() {
    	return array('protoss'=>array('name'=>$this->name,'health'=>$this->health,'stamina'=>$this->stamina,'strength'=>$this->strength,'speed'=>$this->speed,'success_point'=>$this->success));
  }
  /**
   * WinTool item For Protoss
   */
  public function WinTool() {
    	return array('items'=>$this->items);
  }
    /**
   * LoseTool item For Protoss
   */
  public function loseTool() {
    	unset($this->items);
		return 1;
  }
}