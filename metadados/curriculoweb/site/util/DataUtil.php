<?php
class DataUtil {
	
	public static function toTimestamp($data) {
		if (trim($data) == '' ){
			return "";
		}
		$dia = substr($data,0,2);
		$mes = substr($data,3,2);
		$ano = substr($data,6,4);
		
		return $ano . "-" . $mes . "-" . $dia; 
	}
	
	public function formatar($data) {
		 return DataUtil::formatDate($data);
	}

	public function formatDate($data, $format = "") {
		if ($format == ""){
			$format = "d/m/Y";
		}
		if ($data == "" || $data == "0000-00-00 00:00:00") return "";
		return date($format, strtotime($data)); 
	}

	public function formatDateTime($data) {
		$format = "d/m/y H:i:s";		
		return DataUtil::formatDate($data, $format); 
	}
	
	public function formatTime($data) {
		$format = "H:i:s";		
		return DataUtil::formatDate($data, $format); 
	}
	

	public function getMes($data, $format = "") {
		if ($format == ""){
			$format = "m";
		}
		
		return date($format, strtotime($data)); 
	}
	
	public function getAno($data, $format = "") {
		if ($format == ""){
			$format = "y";
		}
		
		return date($format, strtotime($data)); 
	}

	public function getDia($data, $format = "") {
		if ($format == ""){
			$format = "d";
		}
		
		return date($format, strtotime($data)); 
	}
		
	public function getDiaSemana($data) {
	
		$dia_ingles = date("l",strtotime($data)); //vê o dia da semana em inglês

		switch($dia_ingles) {
			case "Monday":
				$dia_port = "Segunda-Feira";
				break;
			case "Tuesday":
				$dia_port = "Terça-Feira";
				break;
			case "Wednesday":
				$dia_port = "Quarta-Feira";
				break;
			case "Thursday":
				$dia_port = "Quinta-Feira";
				break;
			case "Friday":
				$dia_port = "Sexta-Feira";
				break;
			case "Saturday":
				$dia_port = "Sábado";
				break;
			case "Sunday":
				$dia_port = "Domingo";
				break;
		}
		
		return $dia_port;	
	}
	
	public function getMesAbreviado($mes_ingles) {
		
		switch($mes_ingles) {
			case "1":
				$mes_port = "Jan";
				break;
			case "2":
				$mes_port = "Fev";
				break;
			case "3":
				$mes_port = "Mar";
				break;
			case "4":
				$mes_port = "Abr";
				break;
			case "5":				 
				$mes_port = "Mai";
				break;
			case "6":
				$mes_port = "Jun";
				break;
			case "7":
				$mes_port = "Jul";
				break;
			case "8":
				$mes_port = "Ago";
				break;
			case "9":
				$mes_port = "Set";
				break;
			case "10":
				$mes_port = "Out";
				break;
			case "11":
				$mes_port = "Nov";
				break;
			case "12":
				$mes_port = "Dez";
				break;
		}

		return $mes_port;
	}
	
	public function getMesPorExtenso($mes_ingles) {
		
		switch($mes_ingles) {
			case "1":
				$mes_port = "Janeiro";
				break;
			case "2":
				$mes_port = "Fevereiro";
				break;
			case "3":
				$mes_port = "Março";
				break;
			case "4":
				$mes_port = "Abril";
				break;
			case "5":				 
				$mes_port = "Maio";
				break;
			case "6":
				$mes_port = "Junho";
				break;
			case "7":
				$mes_port = "Julho";
				break;
			case "8":
				$mes_port = "Agosto";
				break;
			case "9":
				$mes_port = "Setembro";
				break;
			case "10":
				$mes_port = "Outubro";
				break;
			case "11":
				$mes_port = "Novembro";
				break;
			case "12":
				$mes_port = "Dezembro";
				break;
		}

		return $mes_port;
	}
	
	public function getDataExtenso($data, $diaDaSemana = true) {

		$dia_port = DataUtil::getDiaSemana($data);
		
		$mes_ingles = date("n",strtotime($data)); // vê o mês em Inglês
		
		$mes_port = DataUtil::getMesPorExtenso($mes_ingles);
		
		$dataCompleta = "";
		
		$dataCompleta = $dia_port . ", " . date("d",strtotime($data)) . " de " . $mes_port . " de " . date("Y",strtotime($data));

		return $dataCompleta;
	}
	
	public function getDataSimples($data, $diaDaSemana = true) {

		$dia_port = DataUtil::getDiaSemana($data);
		
		$mes_ingles = date("n",strtotime($data)); // vê o mês em Inglês
		
		$mes_port = DataUtil::getMesPorExtenso($mes_ingles);
		
		$dataCompleta = "";
		
		$dataCompleta .= date("d",strtotime($data)) . " de " . $mes_port . " de " . date("Y",strtotime($data));

		return $dataCompleta;
	}
	
	public function getDataSemDia($data, $diaDaSemana = true) {

		$dia_port = DataUtil::getDiaSemana($data);
		
		$mes_ingles = date("n",strtotime($data)); // vê o mês em Inglês
		
		$mes_port = DataUtil::getMesPorExtenso($mes_ingles);
		
		$dataCompleta = "";
		
		$dataCompleta .= $mes_port . " de " . date("Y",strtotime($data));

		return $dataCompleta;
	}
	
	public function getDataSemAno($data, $diaDaSemana = true) {

		$dia_port = DataUtil::getDiaSemana($data);
		
		$mes_ingles = date("n",strtotime($data)); // vê o mês em Inglês
		
		$mes_port = DataUtil::getMesPorExtenso($mes_ingles);
		
		$dataCompleta = "";
		
		$dataCompleta .= date("d",strtotime($data)) . " de " . $mes_port;

		return $dataCompleta;
	}   
    
    public function validaData($data){
        $formato = '';
        if (preg_match("/\d{2}\/\d{2}\/\d{4}/", $data))
        {
            $formato = 'DD/MM/AAAA';
        }
        if (preg_match("/\d{2}-\d{2}-\d{4}", $data))
        {
            $formato =  'DD-MM-AAAA';
        }
        if (preg_match("/\d{4}-\d{2}-\d{2}/", $data))
        {
            $formato =  'AAAA-MM-DD';     
        }
        if (preg_match("/\d{4}/\d{2}/\d{2}/", $data))
        {
            $formato =  'AAAA/MM/DD';  
        }        
        if (preg_match("/\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}/", $data))
        {
            $formato =  'DD/MM/AAAA HH:MM:SS';
        }
        if (preg_match("/\d{2}-\d{2}-\d{4}\s\d{2}:\d{2}:\d{2}/", $data))
        {
            $formato =  'DD-MM-AAAA HH:MM:SS';
        }
        if (preg_match("/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}/", $data))
        {
            $formato =  'AAAA-MM-DD HH:MM:SS';     
        }
        if (preg_match("/\d{4}/\d{2}/\d{2}\s\d{2}:\d{2}:\d{2}/", $data))
        {
            $formato =  'AAAA/MM/DD HH:MM:SS';              
        }

        if ($formato != '')
        {
            return true;
        }
        return false;
    }
    
    

}

?>