<?php
    global $traducao;
	$traducao["RHPESSOAS"]["PAI"]="1";
	$traducao["RHPESSOAS"]["MAE"]="2";
	$traducao["RHPESSOAS"]["LOCALNASCIMENTO"]="3";
	$traducao["RHPESSOAS"]["UFNASCIMENTO"]="4";
	$traducao["RHPESSOAS"]["ESTADOCIVIL"]="5";
	$traducao["RHPESSOAS"]["GRAUINSTRUCAO"]="6";
	$traducao["RHPESSOAS"]["PRETENSAOSALARIAL"]="7";
	$traducao["RHPESSOAS"]["NACIONALIDADE"]="8";
	$traducao["RHPESSOAS"]["VALIDADEVISTO"]="9";
	$traducao["RHPESSOAS"]["ANOCHEGADABRASIL"]="10";
	$traducao["RHPESSOAS"]["TIPOVISTO"]="11";
	$traducao["RHPESSOAS"]["IDENTIDADE"]="12";
	$traducao["RHPESSOAS"]["TIPOIDENTIDADE"]="13";
	$traducao["RHPESSOAS"]["CONSELHOCLASSE"]="14";
	$traducao["RHPESSOAS"]["REGISTROCONSELHO"]="15";
	$traducao["RHPESSOAS"]["DATAREGISTRO"]="DataRegistro";
	$traducao["RHPESSOAS"]["RUA"]="Rua";
	$traducao["RHPESSOAS"]["NRORUA"]="NroRua";
	$traducao["RHPESSOAS"]["COMPLEMENTO"]="Complemento";
	$traducao["RHPESSOAS"]["BAIRRO"]="Bairro";
	$traducao["RHPESSOAS"]["CIDADE"]="Cidade";
	$traducao["RHPESSOAS"]["UF"]="UF";
	$traducao["RHPESSOAS"]["DDD"]="DDD";
	$traducao["RHPESSOAS"]["TELEFONE"]="Telefone";
	$traducao["RHPESSOAS"]["DDDCELULAR"]="DDDCelular";
	$traducao["RHPESSOAS"]["TELEFONECELULAR"]="TelefoneCelular";
	$traducao["RHPESSOAS"]["EMAIL"]="Email";
	$traducao["RHPESSOAS"]["REGISTROHABILITACAO"]="RegistroHabilitacao";
	$traducao["RHPESSOAS"]["CATEGORIAHABILITACAO"]="CategoriaHabilitacao";
	$traducao["RHPESSOAS"]["VALIDADEHABILITACAO"]="ValidadeHabilitacao";
    $traducao["RHPESSOAS"]["PIS"]="PIS";    
    $traducao["RHPESSOAS"]["DATAPIS"]="DataPIS";
	
	$traducao["RHEMPRESASANTERIORES"]["SALARIOFINAL"]="SalarioFinal";
	$traducao["RHEMPRESASANTERIORES"]["OBSERVACOES"]="Observacoes";
	
	$traducao["RHPESSOACURSOSRS"]["DESCRICAO40"]="Descricao40";
	$traducao["RHPESSOACURSOSRS"]["CAR_HORARIA"]="Car_Horaria";
	$traducao["RHPESSOACURSOSRS"]["DT_INICIO"]="Dt_Inicio";
	$traducao["RHPESSOACURSOSRS"]["DT_ENCERRA"]="Dt_Encerra";
	
class  CamposObrigatorios{
	var $listaVariaveis;
	
	function AdicionaListaVariaveis($variavel){
		$this->listaVariaveis[]=$variavel;	
	}
	
	function ExisteVariavel($variavel){
		if (is_array($this->listaVariaveis )){		
			foreach ($this->listaVariaveis as $value) {
				if($variavel==$value){
					return  true;
				}
			}	
		}
			return  false;
	}
}	
?>