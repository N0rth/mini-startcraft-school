<?php
class item{
	public $item;
	//constructor
	public function __construct() {
	 	$this->item = array(
							  array( 'title' => "Item 1",'strength' => 100),
							  array( 'title' => "Item 2",'speed' => 90),
							  array( 'title' => "Item 3",'stamina' => 80),
							  array( 'title' => "Item 4",'health' => 70)
						   );
    }
   /**
   * Get Item List Based on Challenge property
   */
  public function get_items_list($key) {
    	$itemList = $this->item;
		foreach($this->item as $item){
			if(isset($item[$key])){
				return $item;
				break;
			}
		}
		//return $this->item[array_rand($this->item,1)];
  }
}