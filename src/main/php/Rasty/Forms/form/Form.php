<?php

namespace Rasty\Forms\form;


use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\utils\ReflectionUtils;
use Rasty\utils\Logger;
/**
 * Formulario

 * @author bernardo
 * @since 08/08/2013
 */
abstract class Form extends RastyComponent{
		
	/**
	 * legend para el fieldset.
	 * @var string
	 */
	private $legend;
	
	/**
	 * action del form
	 * @var string
	 */
	private $action;

	/**
	 * method del form
	 * @var string
	 */
	private $method;
	
	/**
	 * label para el submit
	 * @var string
	 */
	private $labelSubmit;

	private $properties;

	/**
	 * para el mensaje de error
	 * @var string
	 */
	private $error;

	/**
	 * nombre de la página a consultar en el cancel
	 * 
	 * @var string
	 */
	private $backToOnCancel;
	
	/**
	 * nombre de la página a consultar en el success
	 * 
	 * @var unknown_type
	 */
	private $backToOnSuccess;

	private $isEditable;
	
	private $onClickCancel;
	
	private $onSuccessCallback;
	
	public function __construct(){
		
		$this->setLabelSubmit("form.aceptar");
		$this->properties = array();
		$this->method = "GET";
		$this->isEditable = true;
		
	}

	public function addProperty($property){
		$this->properties[] = $property;
	}
	
	
	public function fillEntity( $entity ){
		
		foreach ($this->properties as $property) {
			
			//$value = RastyUtils::getParamPOST($property);
			
			$input = $this->getComponentById($property);
			$value = $input->getPopulatedValue( $this->getMethod() );			
			ReflectionUtils::doSetter( $entity, $property, $value );
			
		}
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend", $this->getLegend() );
		$xtpl->assign("action", $this->getAction() );
		$xtpl->assign("method", $this->getMethod() );
		$xtpl->assign("lbl_submit", $this->localize( $this->getLabelSubmit() ) );
		
		$msg = $this->getError();
		
		if( !empty($msg) ){
			
			$xtpl->assign("msg", $msg);
			//$xtpl->assign("msg",  );
			$xtpl->parse("main.msg_error" );
		}
		
		
		$xtpl->assign("onClickCancel", $this->getOnClickCancel());
		$xtpl->assign("onSuccessCallback", $this->getOnSuccessCallback());
		
		
		$this->cleanSavedProperties();	
	}

	public function getLegend()
	{
	    return $this->legend;
	}

	public function setLegend($legend)
	{
	    $this->legend = $legend;
	}

	public function getAction()
	{
	    return $this->action;
	}

	public function setAction($action)
	{
	    $this->action = $action;
	}

	public function getLabelSubmit()
	{
	    return $this->labelSubmit;
	}

	public function setLabelSubmit($labelSubmit)
	{
	    $this->labelSubmit = $labelSubmit;
	}


	public function getMethod()
	{
	    return $this->method;
	}

	public function setMethod($method)
	{
	    $this->method = $method;
	}

	public function getProperties()
	{
	    return $this->properties;
	}

	public function setProperties($properties)
	{
	    $this->properties = $properties;
	}

	public function getError()
	{
	    return $this->error;
	}

	public function setError($error)
	{
	    $this->error = $error;
	}

	public function getBackToOnCancel()
	{
	    return $this->backToOnCancel;
	}

	public function setBackToOnCancel($backToOnCancel)
	{
		if(!empty($backToOnCancel) )
	    	$this->backToOnCancel = $backToOnCancel;
	}

	public function getBackToOnSuccess()
	{
	    return $this->backToOnSuccess;
	}

	public function setBackToOnSuccess($backToOnSuccess)
	{
		if(!empty($backToOnSuccess) )
	    	$this->backToOnSuccess = $backToOnSuccess;
	}
	
	/**
	 * llena el filtro con los valores guardados en sesión.
	 */
	public function fillFromSaved($entity=null){
	
		//$page = RastyUtils::getParamSESSION("page",1);
    	//$this->setPage($page);

		Logger::log("begin fillFromSaved");
		
		foreach ($this->properties as $property) {
			
			$value = $this->getSavedProperty($property);

			
			if(!empty($value )){
				
				$input = $this->getComponentById($property);
				$value = $input->formatValue($value);
				$input->setValue($value);	
				
				if(!empty($entity))
					ReflectionUtils::doSetter( $entity, $property, $value );
			}
			
		}
	}

	
	/**
	 * setea en sesión los valores del form.
	 */
	public function save(){
		
		//primero limpiamos la búsqueda anterior.
		$this->cleanSavedProperties();
		
		Logger::log("begin save");
		foreach ($this->properties as $property) {

			$input = $this->getComponentById($property);
			
			$value = $input->getPopulatedValue( $this->getMethod() );
			$value = $input->unformatValue($value);

			if( !empty($value) ){
					
				$this->saveProperty($property, $value);
					
			}
		}
		
	}
	public function saveProperty($name, $value){
		
		$nametosave = str_replace('.', '_', $name);
		$_SESSION[get_class($this)][$nametosave] = $value;
		
		Logger::log("savedProperty($name): $nametosave => $value to " . get_class($this));
		
	}
	
	public function getSavedProperty($name){
		
		$nametosave = str_replace('.', '_', $name);
		$value = (isset($_SESSION[ get_class($this) ][$nametosave] ))?$_SESSION[get_class($this)][$nametosave] :null;
		
		Logger::log("getSavedProperty($name): $nametosave => $value from " . get_class($this));
		
		return $value;
		
	}
	
	public function cleanSavedProperties(){
		Logger::log("cleanSavedProperties from " . get_class($this));
		
		unset( $_SESSION[ get_class($this) ] );
	}
	

	public function getOnClickCancel()
	{
	    return $this->onClickCancel;
	}

	public function setOnClickCancel($onClickCancel)
	{
	    $this->onClickCancel = $onClickCancel;
	}

	public function getOnSuccessCallback()
	{
	    return $this->onSuccessCallback;
	}

	public function setOnSuccessCallback($onSuccessCallback)
	{
	    $this->onSuccessCallback = $onSuccessCallback;
	}

	public function getIsEditable()
	{
	    return $this->isEditable;
	}

	public function setIsEditable($isEditable)
	{
	    $this->isEditable = $isEditable;
	}
}
?>