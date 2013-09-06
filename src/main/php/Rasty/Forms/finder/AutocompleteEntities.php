<?php
namespace Rasty\Forms\finder;

use Rasty\Forms\finder\model\IAutocompleteFinder;

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
class AutocompleteEntities extends RastyComponent{


	protected $propertiesCallback= array();
	protected $propertiesList= array();

	public function getType(){
		
		return "AutocompleteEntities";
	}
	
	protected function parseXTemplate(XTemplate $xtpl){
		
		$result = array();
		
		try {

			$query = RastyUtils::getParamGET("query");
			
			$parent = RastyUtils::getParamGET("parent");
			
			$finderClazz = RastyUtils::getParamGET("finder");
			
			$finder = ReflectionUtils::newInstance( $finderClazz );
			
			$entities = $finder->findEntitiesByText( $query, $parent );
		
			//$result = $this->formatResult( $entities, $finder, $query );
			
			//$xtpl->assign( "result", $result );
			
			$this->parseResult($xtpl, $entities, $finder, $query);
			
			
		} catch (RastyException $e) {
		
			$xtpl->assign( "error", $e->getMessage() );
			
		}
		
	}
	
	protected function parseResult( XTemplate $xtpl, $entities, IAutocompleteFinder $finder, $text ){
		
		//formato para resaltar el texto buscado dentro de cada item
		$textSearchFormat = "<span style=\"font-weight:bold;font-style:italic;\">$1</span>";
		
		//$content =  '<table>'."\n";
		$even = true;
		$index=0;
		
		foreach ($entities as $entity) {

			$even = !$even;
			
			//armamos lo que se muestra de la entity  en el dropdown.
			$this->parseItem( $xtpl, $entity, $finder, $text, $textSearchFormat, $even );

						
			$index++;
			
			if($index>10)
				break;	
		}
		
		if( count($entities)>0 ){
		
			//con resultados
			
		}else{
		 
			//sin resultados	
		}
	}
	
	protected function parseItem( XTemplate $xtpl, $entity, IAutocompleteFinder $finder, $text, $textSearchFormat, $even ){
		
		$label = $finder->getEntityLabel( $entity );
		$code = $finder->getEntityCode( $entity );

		//al label le marcamos el texto buscado con un formato.
		$p =  $label ;
		$p = preg_replace('/(' . $text . ')/i', $textSearchFormat, $p);

		//armamos el atributo "rel" con los atributos adicionales (separados por _ )
		$rel = $this->getRel( $entity, $finder );
		
		$li_style = ($even)? 'autocomplete_li_even': 'autocomplete_li_odd';

		$xtpl->assign("li_style", $li_style);
		$xtpl->assign("code", $code);
		$xtpl->assign("label", $label);
		$xtpl->assign("rel", $rel);
		$xtpl->assign("p", $p);

		$this->parseItemDetails($xtpl, $entity, $finder, $text, $textSearchFormat);
		
		$xtpl->parse("main.item");
		
		
	}
	
	protected function parseItemDetails( XTemplate $xtpl, $entity, IAutocompleteFinder $finder, $text, $textSearchFormat ){

		$propertiesValues= $this->getItemValues($entity, $finder);
		foreach ($propertiesValues as $value) {

			$value = preg_replace('/(' . $text . ')/i', $textSearchFormat, $value);
			
			$xtpl->assign("detail_value", $value);
			$xtpl->parse("main.item.detail");
		}
		
	}
	
	protected function formatResult( $entities, IAutocompleteFinder $finder, $text ){
		$content =  '<ul>'."\n";
		//$content =  '<table>'."\n";
		$even = true;
		$index=0;
		
		foreach ($entities as $entity) {

			$label = $finder->getEntityLabel( $entity );
			$code = $finder->getEntityCode( $entity );

			$p =  $label ;
			$p = preg_replace('/(' . $text . ')/i', '<span style="font-weight:bold;font-style:italic;">$1</span>', $p);

			//armamos el atributo "rel" con los atributos adicionales (separados por _ )
			$rel = $this->getRel( $entity, $finder );

			//armamos lo que se muestra de la entity  en el dropdown.
			$label_list = $this->getItemDropDown( $entity, $finder );

			$p .= "<br /> $label_list"  ;

			$li_style = ($even)? 'autocomplete_li_even': 'autocomplete_li_odd';

			//$content .= $p; 
			$content .= "\t".'<li class="' .  $li_style  .  '" id="autocomplete_'. $code .'" label="' .  $label .  '" rel="'. $rel .'">'. ( $p ) .'</li>'."\n";

			$even = !$even;
			
			$index++;
			
			if($index>10)
				break;	
		}
		
		if( count($entities)>0 )
		
			$content .= '</ul>';
		else 
			$content = $this->getEmptyResultContent();	
		
		
		
		//$content .=  '</table>';
		return $content;
	}
	
	protected function getRel( $entity, IAutocompleteFinder $finder ){
		
		$this->propertiesList = $finder->getAttributesCallback();
		
		//si no se definió nada, agregamos código
		if( count($this->propertiesCallback) == 0){
			$this->propertiesCallback[] = $finder->getEntityFieldCode($entity);
		}
		
		//armamos el atributo "rel" con los atributos para el callback(separados por _*_ )
		$propertiesValues= array();
		foreach ($this->propertiesCallback as $property) {
			
			$propertiesValues[] = ReflectionUtils::doGetter($entity, $property); 
		}
		
		$rel = implode("_*_", $propertiesValues);
		
		return $rel;
	}
	
	protected function getItemDropDown( $entity, IAutocompleteFinder $finder ){

		$dropdownItem = "<div id='autocomplete_item_desc'><table><tr>";
		
		$propertiesValues= $this->getItemValues($entity, $finder);
		foreach ($propertiesValues as $value) {
			
			$dropdownItem .= "<td>$value</td>";
		}
		
		$dropdownItem .= "</tr></table></div>";
		return $dropdownItem;
	}

	protected function getItemValues( $entity, IAutocompleteFinder $finder ){
		//si no hay nada mostramos código+label
		$this->propertiesList = $finder->getAttributes();
		if( count($this->propertiesList) == 0){
			$this->propertiesList[] = $finder->getEntityFieldCode($entity);
		}
		
		$propertiesValues= array();
		foreach ($this->propertiesList as $property) {
			
			$propertiesValues[] = ReflectionUtils::doGetter($entity, $property); 
		}
		return $propertiesValues;
				
	}
	
	protected function getEmptyResultContent(){
		
		return "";
		
	}
}
?>