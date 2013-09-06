<?php
namespace Rasty\Forms\input;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\Logger;
/**
 * Input para time
 * 
 * @author bernardo
 * @since 14/08/2013
 */
class InputTime extends InputCombo{

	/**
	 * define cada cuánto tiempo se muestra la hora
	 * en el combo (en minutos)
	 * @var string
	 */
	private $interval;

	/**
	 * hora inicial del rango posible
	 * @var string
	 */
	private $from;
	
	/**
	 * hora final del rango posible
	 * @var string
	 */
	private $to;
	
	public function __construct(){
		
		$this->setFrom("0");
		$this->setTo("24");
		$this->setInterval(15);
		$this->setFormat("H:i");
		
	}
	

	public function initDefaults(){

		parent::initDefaults();
		
		$desde = new \DateTime();
		$desde->setTime($this->getFrom(),0,0);
		$duracion = $this->getInterval();
		
		$cantidadHorasDisponibles = $this->getTo() - $this->getFrom();
		$cantidadHorarios = $cantidadHorasDisponibles * ( 60 / $duracion );
		
		$items = array();
		 
		$i=1;
		while( $i <= $cantidadHorarios ){
			
			$items[$desde->format("H:i")] = $desde->format("H:i");
			
			$desde->modify("+$duracion minutes");
			
			$i++;	
			
		}
		
		$this->setOptions( $items );	
		
	}

	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::formatValue()
	 */
	public function formatValue( $value ){

		
		$res = "";
		if( !empty($value) ){

			$time = strtotime($value);
			//$date = new \DateTime( $time );
			//$res = $date;
			$res =  date( $this->getFormat(), $time );
			
			$dateTime = new \DateTime();
			$dateTime->setTime(date("H", $time), date("i", $time), date("s", $time));
	
			return $dateTime;
		}else{
			return null;
		}
		
	}    
    
	/**
	 * (non-PHPdoc)
	 * @see input/Rasty\Forms\input.InputText::unformatValue()
	 */
	public function unformatValue( $value ){
		
		if(!empty($value)){
			$value = $value->format($this->getFormat());
		}
    	return $value;
    }
	
	
	public function getType(){
		
		return "InputTime";
	}
	

	public function getInterval()
	{
	    return $this->interval;
	}

	public function setInterval($interval)
	{
	    $this->interval = $interval;
	}

	public function getFrom()
	{
	    return $this->from;
	}

	public function setFrom($from)
	{
	    $this->from = $from;
	}

	public function getTo()
	{
	    return $this->to;
	}

	public function setTo($to)
	{
	    $this->to = $to;
	}
}
?>