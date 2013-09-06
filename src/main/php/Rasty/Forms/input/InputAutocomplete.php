<?php
namespace Rasty\Forms\input;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\ReflectionUtils;
use Rasty\Forms\finder\model\IAutocompleteFinder;
/**
 * Input para autocompletes

 * @author bernardo
 * @since 07/08/2013
 */
class InputAutocomplete extends InputText{

	/**
	 * colabora para encontrar y formatear las entities.
	 * @var IAutocompleteFinder
	 */
	private $finder;
	
	/**
	 * función javascript a invocar cuando
	 * se selecciona una entity.
	 * @var string
	 */
	private $functionCallback;

	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::parseXTemplate()
	 */
	protected function parseXTemplate(XTemplate $xtpl){

		
		parent::parseXTemplate($xtpl);

		$xtpl->assign( "finder", urlencode(  $this->getFinder() ) );
		
		if(!empty($this->functionCallback))
			$xtpl->assign("functionCallback", ", " . $this->getFunctionCallback() );
		
	}

	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::parseNoEditable()
	 */
	protected function parseNoEditable(XTemplate $xtpl){
		
		$this->parseProperty($xtpl, "disabled", "disabled" );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::unformatValue()
	 */
	public function unformatValue( $value ){
		
		try {

			$finder = ReflectionUtils::newInstance( $this->getFinder() );
			return  $finder->getEntityLabel( $value );
		}catch(\Exception $ex){
			return $ex->getMessage();
		}
		
		
	}
	
	
	public function initDefaults(){

		parent::initDefaults();
		
	}
	
	public function getType(){
		
		return "InputAutocomplete";
	}


	public function getFinder()
	{
	    return $this->finder;
	}

	public function setFinder($finder)
	{
	    $this->finder = $finder;
	}

	public function getFunctionCallback()
	{
	    return $this->functionCallback;
	}

	public function setFunctionCallback($functionCallback)
	{
	    $this->functionCallback = $functionCallback;
	}
}
?>