<?php
namespace Rasty\Forms\finder\model;

/**
 * 
 * Finder para el autocomplete.
 * 
 * @author bernardo
 * @since 08/08/2013
 */
interface IAutocompleteFinder {
	
	/**
	 * buscar entities dado un texto y un parent.
	 * @param string $text
	 * @param string $parent
	 */
	function findEntitiesByText( $text, $parent=null );

	/**
	 * buscar una entity dado su identificador.
	 * @param string $code
	 */
	function findEntityByCode( $code, $parent=null );
	
	/**
	 * atributos para mostrar en resultado del autocomplete.
	 */
	function getAttributes();

	/**
	 * atributos a retornar cuando se selecciona la entity.
	 */
	function getAttributesCallback();
	
	
	/**
	 * obtiene el id de la entity
	 * @param unknown_type $entity
	 */
	function getEntityCode( $entity );
	
	/**
	 * obtiene el label de la entity
	 * @param $entity
	 */
	function getEntityLabel( $entity );

	/**
	 * obtiene el nombre del atributo id de la entity
	 * @param $entity
	 */
	function getEntityFieldCode( $entity );

		
}
?>