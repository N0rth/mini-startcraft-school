<?php
//require parent class
require_once("character.class.php");
class zerg extends Character {
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
   	  * Set Values For Zerg
   	  */
    parent::__construct('Zerg',100,50,10,30);
    $this->name = parent::get_name();
	$this->health = parent::get_health();
	$this->stamina = parent::get_stamina();
	$this->strength = parent::get_strength();
	$this->speed = parent::get_speed();
	$this->items = parent::get_items();
  }
  /**
   * Get Values For Zerg
   */
  public function get_values() {
    	return array('zerg'=>array('name'=>$this->name,'health'=>$this->health,'stamina'=>$this->stamina,'strength'=>$this->strength,'speed'=>$this->speed,'success'=>$this->success));
  }
   /**
   * WinTool item For Zerg
   */
  public function WinTool() {
    	return array('items'=>$this->items);
  }
   /**
   * LoseTool item For Zerg
   */
  public function loseTool() {
    	unset($this->items);
		return 1;
  }
}