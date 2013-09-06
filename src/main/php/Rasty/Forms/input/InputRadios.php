<?php
namespace Rasty\Forms\input;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\Logger;
/**
 * Input radio button

 * @author bernardo
 * @since 01/09/2013
 */
class InputRadios extends InputText{

	
	private $isChecked;
		
	public function __construct(){
		
		//$this->setInvalidFormatMessage( $this->localize("number.format.invalid") );
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::setValue()
	 */
	public function setValue($value){
		
	    parent::setValue($value);
	    
	    if( $value == 1 || $value == true )
	    	$this->setIsChecked(true);
			
	}
	
	public function getIsChecked()
	{
	    return $this->isChecked;
	}

	public function setIsChecked($isChecked)
	{
	    $this->isChecked = $isChecked;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::parseXTemplate()
	 */
	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
		$custom = "";
		
		if( $this->getIsChecked() ){
			
			$custom = " checked ";
		}
		
		$xtpl->assign( "custom", $custom );
		
		
	}

	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::formatValue()
	 */
	public function formatValue( $value ){

		return parent::formatValue($value);
	}    
    
	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::unformatValue()
	 */
	public function unformatValue( $value ){
		
		//TODO se podría formatear en un formato específico utilizando mask
		
		return parent::unformatValue($value);
    }
	
	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::renderFormat()
	 */
    public function renderFormat(XTemplate $xtpl, $format){
	
		
    }
	
	public function initDefaults(){

		parent::initDefaults();
		
	}
	
	public function getType(){
		
		return "InputRadioButton";
	}
	
}
?>