<?php

/** 
 * @author owenlees
 * 
 */
class Bsfb {
	
	/**
	 */
	protected $target;
	protected $method;
	protected $formFields = array();
	protected $formButtons = array();
	protected $formId;
	
	public $gridValues = array();
	
	function __construct($formId) {
		$this->formId = $formId;
	}
	
	/**
	 * Sets the target file for the form processor
	 * 
	 * @param string $target
	 * @param string $method
	 */
	function setTarget($target,$method="POST"){
		$this->target = $target;
		if (!empty($method)) {
			$this->method = strtoupper($method);
		}		
		return null;
	}
	
	/**
	 * setGrid
	 * 
	 * takes a simple array as follows:
	 * 1,2,1,3 etc for number of items on row
	 * divides 12 cols by number of items.
	 * 
	 * Max Value 4 Min 1
	 * 
	 * @param array $gridvalues
	 */
	function setGrid($gridvalues){
		if(is_array($gridvalues)){
			foreach ($gridvalues as $gv){
				if ($gv > 4){
					exit("Value of grid can not be greater than 4");
				}
			}
			//all ok
			$this->gridValues = $gridvalues;
			
			return;
			
		}else{
			echo "Grid must be an array!";
			exit();
		}
	}
	
	/**
	 * adds a button
	 * default is Submit
	 * 
	 * @param array $values
	 */
	function addButton($values){
		$this->formButtons[] = $values;
	}
	
	/**
	 * adds a form control
	 * 
	 * @param array $values
	 */
	function addControl($values){
		$this->formFields[] = $values;
	}
	
	
	/**
	 * makes the form with the fields
	 */
	function makeForm() {
		//steps
		//1. make the form shell
		//2. make the grid
		//3. insert the fields
		//4. pray
		
		$output[] = "<form role='form' id='{$this->formId}' method='{$this->method}' name='{$this->formId}' target='{$this->target}'>";
		
		//if no grid is required, then calculate number of fields and make a grid array temporarily
		//and foreach across that..
		if(empty($this->gridValues)){
			$rows = count($this->formFields);
			for ($i = 1; $i <= $rows; ++$i) {
				$gridValues[] = 1;
			}

		}else{
			$gridValues = $this->gridValues;
		}
		//determine this grid row
		foreach ($gridValues as $gv){
			
			//<input type="text" id="email" name="email" value="" class="form-control" placeholder="Your Email" />

			//gv tells us what division to do..
			$colWidth = 12 / $gv;
			
			$output[] = "<div class='form-group'>";
			
			//loop across the grid
			for ($i = 0; $i < $gv; $i++) {

				$output[] = "<div class='col-md-{$colWidth}'>";
			
				//get the next form field and remove from main array
				$rowData = array_shift($this->formFields);
			
				//make the control
				$output[] = $this->makeControl($rowData);
			
				$output[] = "</div>";
			
			} //end grid loop
			
			$output[] = "</div>";
			
		}
		
		//button area
		$output[] = "<div class='form-group'><div class='col-md-12'>";
		//add buttons as required
		foreach ($this->formButtons as $fb){
			$output[] = $this->makeButton($fb);
		}
		$output[] = "</div></div>";
		
		//finish form
		$output[] = "</form>";
		
		return $output;
	}
	
	/**
	 * function makeControl
	 * makes the control using the array to determine type etc
	 * 
	 * @param array $values
	 */
	private function makeControl($values){
		
		//empty control var
		$control = "";
		
		$control .= "<label for='{$values['id']}'>{$values['placeholder']}</label>";
		switch ($values['type']){
						
			case "textarea" :
				$control .= "<textarea id='{$values['id']}' name='{$values['id']}' class='form-control mceNoEditor' rows='{$values['rows']}'>";
				$control .= $values['value'];
				$control .= "</textarea>";
			break;
			
			case "select" :
								
				$control .= "<select id='{$values['id']}' name='{$values['id']}' class='form-control'>";
				foreach ($values['options'] as $val){
					//use the array content to make a value
					//check for dual-data first
					
					//default is nothing for selected
					$selected = "";
					
					if(isset($values['dual-data']) && $values['dual-data']){
						// we use dual data
						//test for preselected item
						if($values['value'] == $val[0] || $values['value'] == $val[1]){
							$selected = "selected='selected'";
						}
						//make it
						$control .= "<option $selected value='{$val[0]}' >".$val[1]."</option>";
					}else{
						//single select data
						//test for preselected item
						if($values['value'] == $val){
							$selected = "selected='selected'";
						}
						$control .= "<option $selected >".$val."</option>";
					}
					
				}
				$control .= "</select>";
			break;
			
			case "password" :
				$control .= "<input type='password' id='{$values['id']}' name='{$values['id']}' class='form-control' ";
				$control .= "value='{$values['value']}' placeholder='{$values['placeholder']}'>";
			break;
				
			default :
				$control .= "<input type='text' id='{$values['id']}' name='{$values['id']}' class='form-control' ";
				$control .= "value='{$values['value']}' placeholder='{$values['placeholder']}'>";
			break;
		}

		
		return $control;
	}
	
	/**
	 * make Button
	 * function which makes the button up
	 * 
	 * @param array $values
	 *
	 */
	function makeButton($values){
		
		//use the array of values to make the button
		$button = "<button type='{$values['type']}' style='margin-left:5px;' class='btn btn-{$values['version']} {$values['css']}'>";
		$button .= $values['value'];
		$button .= "</button>";
		
		return $button;
	}
	
	/**
	 * optionally displays the form
	 * (its as easy to echo the makeForm)
	 */
	function displayForm() {
		
		foreach ($this->makeForm() as $mf){
			echo $mf;
		}
	}
	
	/**
	 */
	function __destruct() {
	}
}

?>