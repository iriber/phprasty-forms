<?php
namespace Rasty\Forms\input;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;

/**
 * Input para texts área

 * @author bernardo
 * @since 16/08/2013
 */
class InputTextArea extends InputText{

	private $rows;
	
	private $cols;
		
	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		$xtpl->assign( "rows",  $this->getRows());
		$xtpl->assign( "cols",  $this->getCols() );
		$xtpl->assign( "inputValue",  $this->getValue() );
		
	}

	public function initDefaults(){

		parent::initDefaults();
		
		//$this->setCols(25);
		//$this->setRows(5);
		
	}
	
	public function getType(){
		
		return "InputTextArea";
	}
	
	public function getRows()
	{
	    return $this->rows;
	}

	public function setRows($rows)
	{
	    $this->rows = $rows;
	}

	public function getCols()
	{
	    return $this->cols;
	}

	public function setCols($cols)
	{
	    $this->cols = $cols;
	}
}
?>