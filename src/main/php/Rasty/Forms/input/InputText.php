<?php
namespace Rasty\Forms\input;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\utils\Logger;

/**
 * Input para textos

 * @author bernardo
 * @since 07/08/2013
 */
class InputText extends RastyComponent{

	private $name;

	private $inputId;
	
	private $requiredMessage;
	
	private $invalidFormatMessage;
	
	private $size;

	private $value;
	
	private $placeholder;
	
	private $format;

	private $isEditable=true;
	
	private $isVisible=true;
	
	private $styleCss;
	
	protected function parseXTemplate(XTemplate $xtpl){

		$this->initDefaults();
		
		$xtpl->assign( "inputId",  $this->getInputId());
		$xtpl->assign( "inputName",  $this->getName() );
		
		$this->parseProperty($xtpl, "id",  $this->getInputId());
		
		$this->parseProperty($xtpl, "name",  $this->getName() );
		
		$this->parseProperty($xtpl, "size", $this->getSize() );		
		
		$this->parseProperty($xtpl, "value", $this->unformatValue( $this->getValue() ) );
		
		$this->parseProperty($xtpl, "placeholder", $this->getPlaceholder() );
		
		$this->parseProperty($xtpl, "class", $this->getStyleCss() );
		
		$xtpl->assign("invalidFormatMessage", $this->getInvalidFormatMessage());
		
		$this->renderFormat($xtpl, $this->getFormat());
		
		if( $this->getRequiredMessage() ){
			$xtpl->assign("requiredMessage",  $this->getRequiredMessage());
			$xtpl->parse("main.required");
		}else{
			
			$xtpl->parse("main.no_required");
		}
		
		if(!$this->getIsEditable())
			$this->parseNoEditable($xtpl);
			
		
		
	}

	protected function parseNoEditable(XTemplate $xtpl){
		
		//$this->parseProperty($xtpl, "readOnly", "readOnly" );
		$this->parseProperty($xtpl, "disabled", "disabled" );
		
		$xtpl->assign( "name",  $this->getName() );
		$xtpl->assign( "value", $this->unformatValue( $this->getValue() ) );
		
		$xtpl->parse("main.readOnly");
	}
	
	/**
	 * retorna el valor populado en el input.
	 * @param string $method
	 */
	public function getPopulatedValue($method="POST"){
		$value = "";
		if( strtoupper($method)=="POST" ){

			$value = RastyUtils::getParamPOST( $this->getName() );
				
		}else{
			
			$value = RastyUtils::getParamGET( $this->getName() );
		}
		
		return  $this->formatValue( $value );
	}
	
	/**
	 * se inicializan valores por default
	 * Ver de hacerlo desde los parámetros iniciales.
	 */
	public function initDefaults(){
		
		//$this->setIsEditable( true );
		//$this->setIsVisible( true );
		
	}
	
	public function renderFormat(XTemplate $xtpl, $format){
		
		$xtpl->assign("format",  $format);
	}
	
	protected function parseProperty(XTemplate $xtpl, $name, $value){
		
		if( $value!=null ){
			$xtpl->assign("name",  $name);
			$xtpl->assign("value",  $value );
			$xtpl->parse("main.property");
		}
	}
	
	public function formatValue( $value ){
		
		return $value;
	}
	
	public function unformatValue( $value ){
		
		return $value;
	}
	
	public function getName()
	{
	    return $this->name;
	}

	public function setName($name)
	{
	    $this->name = $name;
	}

	public function getRequiredMessage()
	{
	    return $this->requiredMessage;
	}

	public function setRequiredMessage($requiredMessage)
	{
	    $this->requiredMessage = $requiredMessage;
	}

	public function getSize()
	{
	    return $this->size;
	}

	public function setSize($size)
	{
	    $this->size = $size;
	}
	
	public function getType(){
		
		return "InputText";
	}
	

	public function getValue()
	{
	    return $this->value;
	}

	public function setValue($value)
	{

	    $this->value = $value;
	}

	public function getPlaceholder()
	{
	    return $this->placeholder;
	}

	public function setPlaceholder($placeholder)
	{
	    $this->placeholder = $placeholder;
	}

	public function getFormat()
	{
	    return $this->format;
	}

	public function setFormat($format)
	{
	    $this->format = $format;
	}

	public function getIsEditable()
	{
	    return $this->isEditable;
	}

	public function setIsEditable($isEditable)
	{
	    $this->isEditable = $isEditable;
	}

	public function getIsVisible()
	{
	    return $this->isVisible;
	}

	public function setIsVisible($isVisible)
	{
	    $this->isVisible = $isVisible;
	}

	public function getInputId()
	{
	    return $this->inputId;
	}

	public function setInputId($inputId)
	{
	    $this->inputId = $inputId;
	}

	public function getStyleCss()
	{
	    return $this->styleCss;
	}

	public function setStyleCss($styleCss)
	{
	    $this->styleCss = $styleCss;
	}

	public function getInvalidFormatMessage()
	{
	    return $this->invalidFormatMessage;
	}

	public function setInvalidFormatMessage($invalidFormatMessage)
	{
	    $this->invalidFormatMessage = $invalidFormatMessage;
	}
}
?>