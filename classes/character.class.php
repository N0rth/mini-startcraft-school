<?php
require_once("item.class.php");
class Character extends item{
  // properties
  // declare properties of the class
  protected $name;
  protected $health = 100;
  protected $stamina = 20;
  protected $speed = 50;
  protected $strength = 10;
  protected $items = array();

  //constructor
  public function __construct($name,$health,$stamina,$strength,$speed) {
	
	//construct parent class item
	parent::__construct();
	  
    $this->name = $name;
	$this->health = $health;
	$this->stamina = $stamina;
	$this->strength = $strength;
	$this->speed = $speed;
	//$this->items = parent::get_items_list(1);
  }
  /**
   * GETTERS & SETTERS
   *
   */
  public function get_name() {
    return $this->name;
  }
  public function get_health() {
    return $this->health;
  }
  public function get_stamina() {
    return $this->stamina;
  }
  public function get_strength() {
    return $this->strength;
  }
  public function get_speed() {
    return $this->speed;
  }
  public function get_items() {
    return $this->items;
  }
}