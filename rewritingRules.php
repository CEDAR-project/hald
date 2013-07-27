<?php

class RewritingRules {
  
  public $value_dict = array(
			     "men" => "M",
			     "women" => "V"
			     );
  
  public static function instance() {
    static $inst = null;
    if ($inst === null) {
      $inst = new RewritingRules();
    }
    return $inst;
  }

  private function __construct() {

  }
      
  public function getValue($param) {
    $values = array();
    foreach ($param as $p) {
      array_push($values, $this->value_dict[$p]);
    }
    return $values;
  }

}

?>