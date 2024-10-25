<?php
class NumberUtil {
	
	public static function formatar($value, $dec = 2){
		if (empty($value)) $value = 0;
		return number_format($value, $dec, ',', '.');		
	}
	
	public static function formatarPonto($value){
		if (empty($value)) $value = 0;
		return number_format($value, 2, '.', '');		
	}
	
	public static function formatarSql($value){
		if (empty($value)) $value = 0;
		return str_replace(",",".",str_replace(".","",$value));
	}
	
}
?>