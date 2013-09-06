<?php
namespace Rasty\Forms\input;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\utils\ReflectionUtils;
use Rasty\Forms\input\InputAutocomplete;


/**
 * Input para una entity.
 * 
 * @author bernardo
 * @since 07/08/2013
 */
class InputFindEntity extends InputText{

	/**
	 * finder para encontrar la entity.
	 * @var InputAutocomplete
	 */
	private $finder;
	
	/**
	 * para determinar si incluye la opción de agregar una nueva entity.
	 * @var boolean
	 */
	private $hasAddEntity;
	
	/**
	 * para determinar si incluye la búsqueda con popup.
	 * @var boolean
	 */
	private $hasPopup;
	
	/**
	 * tipo del filter para el popup
	 * @var unknown_type
	 */
	private $popupFilterType;

	/**
	 * función js definida por el usuario del componente
	 * que se ejecuta cuando una entity es seleccionada, la
	 * cual recibirá la entity en cuestión.
	 * @var string
	 */
	private $onSelectCallback;
	
	/**
	 * tipo de formulario para el popup
	 * @var string
	 */
	private $popupFormType;

	/**
	 * para determinar si incluye la ayuda
	 * @var boolean
	 */
	private $hasHelp=false;
	
	/**
	 * mensaje para la ayuda de la lupa
	 * @var string
	 */
	private $popupHelpMsg;
	
	/**
	 * mensaje para la ayuda del autocomplete
	 * @var string
	 */
	private $autocompleteHelpMsg;
	
	/**
	 * mensaje para la ayuda del add entity
	 * @var string
	 */
	private $addHelpMsg;
	

	public function setValue($value)
	{
		parent::setValue($value);

		$input = $this->getComponentById("inputCode");
		
		if(!empty($input))
			$input->setValue($this->getEntityId());
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);

		$xtpl->assign("finder",  urlencode($this->getFinder()) );
		
		$xtpl->assign("onSelectCallback",  $this->getOnSelectCallback() );
		
		$xtpl->assign("entityCode", $this->getEntityId() );
		
		if($this->getHasPopup()){
			
			$xtpl->assign("popupFilterType",  $this->getPopupFilterType() );	
			$xtpl->parse("main.popup");
			
		}
		if($this->hasAddEntity){
			$xtpl->assign("popupFormType",  $this->getPopupFormType() );
			$xtpl->parse("main.addentity");
		}
		
		if($this->hasHelp){
			$xtpl->assign("popupHelpMsg",  $this->getPopupHelpMsg() );
			$xtpl->assign("addHelpMsg",  $this->getAddHelpMsg() );
			$xtpl->assign("autocompleteHelpMsg",  $this->getAutocompleteHelpMsg() );
			$xtpl->parse("main.help");
		}
	}
	
	public function getAutocompleteId(){
		
		return "findentity_" . $this->getInputId() . "_autocomplete";
	}

	public function getInputCodeId(){
		
		return "findentity_" . $this->getInputId() . "_inputCode";
	}
	
	public function getInputCodeStyleCss(){
		
		return "findentity_inputCode";
	}
	
	public function getAutocompleteStyleCss(){
		
		return "findentity_autocomplete";
	}

	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::unformatValue()
	 */
	public function unformatValue($value){
		$finder = ReflectionUtils::newInstance( $this->getFinder() );
		return  $finder->getEntityCode( $value );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::formatValue()
	 */
	public function formatValue($value){

		//redefinimos ya que se popula el id de la entity.
		//entonces a partir del id buscamos la entity
		
		$finder = ReflectionUtils::newInstance( $this->getFinder() );
		
		return  $finder->findEntityByCode( $value );
	}
	
	public function getEntityId(){
		
		$finder = ReflectionUtils::newInstance( $this->getFinder() );
		return  $finder->getEntityCode( $this->getValue() );
	}
	
	public function getFunctionAutocompleteCallback(){
		
		return "findentity_" . $this->getInputId() . "_autocomplete_callback";
	}
	
	public function initDefaults(){

		parent::initDefaults();
		
	}
	
	public function getType(){
		
		return "InputFindEntity";
	}
	

	public function getFinder()
	{
	    return $this->finder;
	}

	public function setFinder($finder)
	{
	    $this->finder = $finder;
	}

	public function getHasAddEntity()
	{
	    return $this->hasAddEntity;
	}

	public function setHasAddEntity($hasAddEntity)
	{
	    $this->hasAddEntity = $hasAddEntity;
	}

	public function getHasPopup()
	{
	    return $this->hasPopup;
	}

	public function setHasPopup($hasPopup)
	{
	    $this->hasPopup = $hasPopup;
	}

	public function getPopupFilterType()
	{
	    return $this->popupFilterType;
	}

	public function setPopupFilterType($popupFilterType)
	{
	    $this->popupFilterType = $popupFilterType;
	}

	public function getOnSelectCallback()
	{
	    return $this->onSelectCallback;
	}

	public function setOnSelectCallback($onSelectCallback)
	{
	    $this->onSelectCallback = $onSelectCallback;
	}

	public function getPopupFormType()
	{
	    return $this->popupFormType;
	}

	public function setPopupFormType($popupFormType)
	{
	    $this->popupFormType = $popupFormType;
	}

	public function getHasHelp()
	{
	    return $this->hasHelp;
	}

	public function setHasHelp($hasHelp)
	{
	    $this->hasHelp = $hasHelp;
	}

	public function getPopupHelpMsg()
	{
	    return $this->popupHelpMsg;
	}

	public function setPopupHelpMsg($popupHelpMsg)
	{
	    $this->popupHelpMsg = $popupHelpMsg;
	}

	public function getAutocompleteHelpMsg()
	{
	    return $this->autocompleteHelpMsg;
	}

	public function setAutocompleteHelpMsg($autocompleteHelpMsg)
	{
	    $this->autocompleteHelpMsg = $autocompleteHelpMsg;
	}

	public function getAddHelpMsg()
	{
	    return $this->addHelpMsg;
	}

	public function setAddHelpMsg($addHelpMsg)
	{
	    $this->addHelpMsg = $addHelpMsg;
	}
}
?>