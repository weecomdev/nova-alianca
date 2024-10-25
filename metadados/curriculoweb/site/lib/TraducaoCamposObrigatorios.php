<?php
    global $traducao;
	$traducao["RHPESSOAS"]["PAI"]="Pai";
	$traducao["RHPESSOAS"]["MAE"]="Mae";
	$traducao["RHPESSOAS"]["LOCALNASCIMENTO"]="LocalNascimento";
    $traducao["RHPESSOAS"]["DEFICIENTEFISICO"]="DeficienteFisico";
	$traducao["RHPESSOAS"]["UFNASCIMENTO"]="UFNascimento";
	$traducao["RHPESSOAS"]["ESTADOCIVIL"]="EstadoCivil";
	$traducao["RHPESSOAS"]["GRAUINSTRUCAO"]="GrauInstrucao";
	$traducao["RHPESSOAS"]["PRETENSAOSALARIAL"]="PretensaoSalarial";
	$traducao["RHPESSOAS"]["NACIONALIDADE"]="Nacionalidade";
	$traducao["RHPESSOAS"]["VALIDADEVISTO"]="ValidadeVisto";
	$traducao["RHPESSOAS"]["ANOCHEGADABRASIL"]="AnoChegadaBrasil";
	$traducao["RHPESSOAS"]["TIPOVISTO"]="TipoVisto";
	$traducao["RHPESSOAS"]["IDENTIDADE"]="Identidade";
	$traducao["RHPESSOAS"]["TIPOIDENTIDADE"]="TipoIdentidade";
	$traducao["RHPESSOAS"]["CONSELHOCLASSE"]="ConselhoClasse";
	$traducao["RHPESSOAS"]["REGISTROCONSELHO"]="RegistroConselho";
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
    $traducao["RHPESSOAS"]["CEP"]="Cep";
	
	$traducao["RHEMPRESASANTERIORES"]["SALARIOFINAL"]="SalarioFinal";
	$traducao["RHEMPRESASANTERIORES"]["OBSERVACOES"]="Observacoes";
	
	$traducao["RHPESSOACURSOSRS"]["DESCRICAO40"]="Descricao40";
	$traducao["RHPESSOACURSOSRS"]["CAR_HORARIA"]="Car_Horaria";
	$traducao["RHPESSOACURSOSRS"]["DT_INICIO"]="Dt_Inicio";
	$traducao["RHPESSOACURSOSRS"]["DT_ENCERRA"]="Dt_Encerra";

    $traducao["RHPESSOASANEXOS"]["ARQUIVOBLOB"]="ArquivoBlob";
    $traducao["RHPESSOASFOTOS"]["FOTO"]="Foto";
	
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