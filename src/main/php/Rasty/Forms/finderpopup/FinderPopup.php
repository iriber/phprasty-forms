<?php
namespace Rasty\Forms\finderpopup;

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
 * @since 08/08/2013
 */
class FinderPopup extends RastyComponent{


	private $onSelectCallback;
	
	protected $filterType;
	
	protected $filter;

	
	public function getType(){
		
		return "FinderPopup";
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		$xtpl->assign("legend_resultados", $this->localize("filter.resultados") );
	}
	

	public function getFilterType()
	{
	    return $this->filterType;
	}

	public function setFilterType($filterType)
	{
	    $this->filterType = $filterType;
	    
	    //generamos el filter a partir del type.
	    $componentConfig = new ComponentConfig();
	    $componentConfig->setId( "filter" );
		$componentConfig->setType( $filterType );
		
		//TODO esto setearlo en el .rasty
	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);
	    $this->filter->setLegend( $this->localize("filter.buscar") );
	    $this->filter->setLegendAgain( $this->localize("filter.buscar.again") );
	    $this->filter->setResultDiv( "popup_searchdiv" );
	    $this->filter->setSelectRowCallback( $this->getOnSelectCallback() );
	}

	public function getFilter()
	{
	    return $this->filter;
	}

	public function setFilter($filter)
	{
	    $this->filter = $filter;
	}

	public function getOnSelectCallback()
	{
	    return $this->onSelectCallback;
	}

	public function setOnSelectCallback($onSelectCallback)
	{
	    $this->onSelectCallback = $onSelectCallback;
	}
}
?>