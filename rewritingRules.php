<?php

class RewritingRules {
  
  public $gender_dict = array(
			     "men" => "M",
			     "women" => "V"
			     );
  public $marital_dict = array(
			       "married" => "G",
			       "unmarried" => "O"
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
    $values = array("gender" => array(), "marital" => array());
    foreach ($param as $p) {
      if (array_key_exists($p, $this->gender_dict)) {
	array_push($values["gender"], $this->gender_dict[$p]);
      }
      if (array_key_exists($p, $this->marital_dict)) {
	array_push($values["marital"], $this->marital_dict[$p]);
      }
    }
    // Fill the output dictionaries if they are empty
    if (sizeof($values["gender"]) == 0) {
      foreach ($this->gender_dict as $gender) {
	array_push($values["gender"], $gender);
      }
    }
    if (sizeof($values["marital"]) == 0) {
      foreach ($this->marital_dict as $marital) {
	array_push($values["marital"], $marital);
      }
    }
    return $values;
  }

}

?>