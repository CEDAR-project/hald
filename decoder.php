<?php

class Decoder {
  public $query;
  public $output_params = array();
  private $dict = array(
			"men" => "men",
			"women" => "women",
			"persons" => array("men", "women"),
			"people" => array("men", "women")
			);

  function __construct($__query) {
    $this->query = $__query;
    $this->decode();
  }

  private function decode() {
    $words = explode(" ", $this->query);
    foreach ($words as $word) {
      if (array_key_exists($word, $this->dict)) {
	if (is_array($this->dict[$word])) {
	  foreach ($this->dict[$word] as $value) {
	    array_push($this->output_params, $value);
	  }
	} else {
	  array_push($this->output_params, $this->dict[$word]);
	}
      }
    }
  }
      
}

?>