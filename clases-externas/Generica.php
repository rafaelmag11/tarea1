<?php
class Generica{
	public function formatoFolio($usuarioid,$consecutivo){
		return str_pad($usuarioid, 3, '0', STR_PAD_LEFT) . str_pad($consecutivo, 4, '0', STR_PAD_LEFT);
	}
}
?>