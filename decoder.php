<?php

class Decoder {
  public $query;
  public $output_params = array();
  public $target;
  private $params_dict = array(
			       "men" => "men",
			       "women" => "women",
			       "persons" => array("men", "women"),
			       "people" => array("men", "women"),
			       "married" => "married",
			       "single" => "unmarried",
			       "unmarried" => "unmarried",
			       "not married" => "unmarried",
			       "years old" => "age",
			       "year old" => "age",
			       "old" => "age",
			       "age" => "age"
			       );
  private $target_dict = array(
			       "how many" => "population",
			       "how much" => "population",
			       "the number" => "population"
			       );

  function __construct($__query) {
    $this->query = $__query;
    $this->decodeParams();
    $this->decodeTarget();
  }

  private function decodeParams() {
    $words = explode(" ", $this->query);
    foreach ($words as $word) {
      if (array_key_exists($word, $this->params_dict)) {
	if (is_array($this->params_dict[$word])) {
	  foreach ($this->params_dict[$word] as $value) {
	    array_push($this->output_params, $value);
	  }
	} else {
	  array_push($this->output_params, $this->params_dict[$word]);
	}
      }
    }
  }

  private function decodeTarget() {
    $words = explode(" ", $this->query);
    $lastword = "";
    foreach ($words as $word) {
      if (array_key_exists($lastword . " " . $word, $this->target_dict)) {
	$this->target = $this->target_dict[$lastword . " " . $word];
      }
      $lastword = $word;
    }
  }
      

}

?>