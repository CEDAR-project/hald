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
    return $this->value_dict[$param];
  }

}

?>