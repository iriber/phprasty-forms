<?php
namespace Rasty\Forms\input;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;

/**
 * Input para opciones (select)
 * 
 * @author bernardo
 * @since 07/08/2013
 */
class InputCombo extends InputText{

	/**
	 * valores posibles para el select (options).
	 * @var array
	 */
	private $options;

	/**
	 * label para el valor vacío.
	 * @var unknown_type
	 */
	private $emptyOptionLabel;
	
	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);
		
	    //renderizamos las opciones del select.
    		
    	$emptyLabel = $this->getEmptyOptionLabel();
    	if( !empty( $emptyLabel ) ){
    		$xtpl->assign( "empty_label", $emptyLabel );
    		$xtpl->parse( "main.option_empty" );
    	}
    	
    	$selected = $this->unformatValue( $this->getValue() );
    	foreach ($this->getOptions() as $value => $label) {
    		
    		$xtpl->assign( "label", $label );
    		$xtpl->assign( "value", RastyUtils::selected( $value, $selected) );
    		$xtpl->parse( "main.option" );
    	}
    	
	}
	
	
	public function initDefaults(){

		parent::initDefaults();
		
		if(empty($this->options))
			$this->setOptions( array() );
		
	}
	
	public function getType(){
		
		return "InputCombo";
	}
	

	public function getOptions()
	{
	    return $this->options;
	}

	public function setOptions($options)
	{
	    $this->options = $options;
	}



	public function getEmptyOptionLabel()
	{
	    return $this->emptyOptionLabel;
	}

	public function setEmptyOptionLabel($emptyOptionLabel)
	{
	    $this->emptyOptionLabel = $emptyOptionLabel;
	}
}
?>