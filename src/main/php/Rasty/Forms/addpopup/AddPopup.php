<?php
namespace Rasty\Forms\addpopup;

use Rasty\Forms\finder\model\IAutocompleteFinder;

use Rasty\utils\RastyUtils;
use Rasty\utils\XTemplate;
use Rasty\utils\ReflectionUtils;
use Rasty\exception\RastyException;

use Rasty\components\RastyComponent;

use Rasty\factory\ComponentConfig;
use Rasty\factory\ComponentFactory;
/**
 * se consultan entities para seleccionar una de ellas
 * 
 * @author bernardo
 * @since 18/08/2013
 */
class AddPopup extends RastyComponent{


	private $onSuccessCallback;
	
	protected $formType;
	
	protected $form;

	
	public function getType(){
		
		return "AddPopup";
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		//$xtpl->assign("legend_resultados", $this->localize("filter.resultados") );
		$xtpl->assign("id", $this->getId());
	}
	

	public function getFormType()
	{
	    return $this->formType;
	}

	public function setFormType($formType)
	{
	    $this->formType = $formType;
	    
	    //generamos el form a partir del type.
	    $componentConfig = new ComponentConfig();
	    $componentConfig->setId( "form" );
		$componentConfig->setType( $formType );
		
		//esto setearlo en el .rasty
	    $this->form = ComponentFactory::buildByType($componentConfig, $this);
	    $this->form->setMethod( "POST" );
	    
	    $id = $this->getId();
	    
	    $this->form->setOnSuccessCallback( $this->getOnSuccessCallback() );
	}

	public function getForm()
	{
	    return $this->form;
	}

	public function setForm($form)
	{
	    $this->form = $form;
	}


	public function getOnSuccessCallback()
	{
	    return $this->onSuccessCallback;
	}

	public function setOnSuccessCallback($onSuccessCallback)
	{
	    $this->onSuccessCallback = $onSuccessCallback;
	}
}
?>