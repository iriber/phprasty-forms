<?php
namespace Rasty\Forms\buttons;


use Rasty\utils\RastyUtils;
use Rasty\utils\XTemplate;
use Rasty\utils\ReflectionUtils;
use Rasty\exception\RastyException;

use Rasty\i18n\Locale;
use Rasty\components\RastyComponent;

/**
 * se consultan entities x json para el autocomplete
 * 
 * @author bernardo
 * @since 08/08/2013
 */
class Button extends RastyComponent{

	private $href;
	private $onclick;
	private $icon;
	private $label;
	private $style;
	
	public function __construct(){
		
		$this->setHref("#");
		
	}
	
	public function getType(){
		
		return "Button";
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		
		$xtpl->assign("onclick", $this->getOnclick());
		$xtpl->assign("href", $this->getHref());
		$xtpl->assign("icon", $this->getIcon());
		$xtpl->assign("label", $this->getLabel());
		$xtpl->assign("style", $this->getStyle());
		
	}
	


	public function getHref()
	{
	    return $this->href;
	}

	public function setHref($href)
	{
	    $this->href = $href;
	}

	public function getOnclick()
	{
	    return $this->onclick;
	}

	public function setOnclick($onclick)
	{
	    $this->onclick = $onclick;
	}

	public function getIcon()
	{
	    return $this->icon;
	}

	public function setIcon($icon)
	{
	    $this->icon = $icon;
	}

	public function getLabel()
	{
	    return $this->label;
	}

	public function setLabel($label)
	{
	    $this->label = $label;
	}

	public function getStyle()
	{
	    return $this->style;
	}

	public function setStyle($style)
	{
	    $this->style = $style;
	}
}
?>