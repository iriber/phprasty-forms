<?php
namespace Rasty\Forms\input;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\Logger;
/**
 * Input para números

 * @author bernardo
 * @since 14/08/2013
 */
class InputNumber extends InputText{

	
	public function __construct(){
		
		$this->setInvalidFormatMessage( $this->localize("number.format.invalid") );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::parseXTemplate()
	 */
	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
	}

	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::formatValue()
	 */
	public function formatValue( $value ){

		//TODO se podría formatear en un formato específico utilizando mask

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
	
		//TODO se podría formatear en un formato específico utilizando mask
		
    }
	
	public function initDefaults(){

		parent::initDefaults();
		
	}
	
	public function getType(){
		
		return "InputNumber";
	}
	
}
?>