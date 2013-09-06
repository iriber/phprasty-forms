<?php
namespace Rasty\Forms\input;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;

/**
 * Input hidden

 * @author bernardo
 * @since 14/08/2013
 */
class InputHidden extends InputText{

	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign( "inputId",  $this->getInputId());
		$xtpl->assign( "inputName",  $this->getName() );
		$xtpl->assign( "value",  $this->getValue() );
		
	}
	
}
?>