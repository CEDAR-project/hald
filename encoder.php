<?php

class Encoder {
      public $input_vars;
      public $output_vars;
      private $dict = array(
      	      "men" => "M",
	      "women" => "V"
      );

      function __construct($__input_vars) {
      	      $this->input_vars = $__input_vars;
	      $this->encode();
      }

      private function encode() {
      	      $this->output_vars = $this->dict[$this->input_vars];
      }
      
}

?>