<?php
class item{
	public $item;
	//constructor
	public function __construct() {
	 	$this->item = array(
							  array( 'title' => "Item 1",'strength' => 100),
							  array( 'title' => "Item 2",'speed' => 90),
							  array( 'title' => "Item 3",'stamina' => 80),
							  array( 'title' => "Item 4",'health' => 70),
							  array( 'title' => "Item 5",'strength' => 90),
							  array( 'title' => "Item 6",'speed' => 80),
							  array( 'title' => "Item 7",'stamina' => 70),
							  array( 'title' => "Item 8",'health' => 100)
							  
						   );
    }
   /**
   * Get Item List Based on Challenge property
   */
  public function get_items_list($key) {
    	$itemList = $this->item;
 		if($key==false){
			return $this->item[array_rand($this->item,1)];
		}
		else{
			foreach($this->item as $item){
				if(isset($item[$key])){
					$randomItems[] = $item;
				}
			}
			return $randomItems[array_rand($randomItems,1)];
		}
   }
}