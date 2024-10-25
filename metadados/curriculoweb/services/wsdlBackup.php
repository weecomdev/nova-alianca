<?php 
include 'zipstream.php';
require_once('padraoServicos.php');
ini_set('memory_limit','1600M');
function addFolderToZip($dir, $zipArchive){ 
    if (is_dir($dir)) { 
        if ($dh = opendir($dir)) { 
            while (($file = readdir($dh)) !== false) { 
                if(!is_file($dir . $file)){                     
                    if( ($file !== ".") && ($file !== "..")){ 
                        addFolderToZip($dir . $file . "/", $zipArchive); 
                    } 
                }else{ 
                    $zipArchive->add_file_from_path(str_replace('../', '', $dir) . $file, $dir . $file); 
                } 
            } 
        } 
    } 
} 

function exportaBanco($zip){
    global $db;
    $resultadoTabelas = $db->execute('SHOW TABLES');
    $dadosBanco='';
    while(!$resultadoTabelas->EOF){
        $tabela = $resultadoTabelas->fields[0];
        if(strpos($tabela,"rh")!==false || strpos($tabela,"bf2")!==false ){
            $resultadoCampos = $db->execute('SHOW COLUMNS FROM '.$tabela);
            $campos=array();
            $i=0;
            $dadosBanco .= "DROP TABLE IF EXISTS ".$tabela.";\n";
            $resultadoDDL = $db->execute('SHOW CREATE TABLE '.$tabela);
            $dadosBanco .= $resultadoDDL->fields[1].";\n";
            while(!$resultadoCampos->EOF){
                $campos[$tabela][$i]['campo'] = $resultadoCampos->fields['Field'];
                $campos[$tabela][$i]['tipo'] = $resultadoCampos->fields['Type'];
                $i++;
                $resultadoCampos->MoveNext();
            }
            $dadosBanco .= exportaTabelaSql($db, $campos);            
        }
        $resultadoTabelas->MoveNext();
    }
    $zip->add_file('BD/banco.sql', utf8_encode($dadosBanco)); 
}
function exportaTabelaSql($db, $tabela){
    $retorno='';
    foreach($tabela as $c=>$v){
        $sql='';
        $sqlCampos='';
        $i=0;
        for($i=0; $i<count($v); $i++){
            if(trim($sqlCampos)!=''){
                $sqlCampos.=' , ';
            }
            $sqlCampos.=$v[$i]['campo'];
        }        
        
        $sql = "SELECT $sqlCampos FROM $c";
        $resultado = $db->execute($sql);
        $primeiro=true;
        $conta=0;
        while(!$resultado->EOF){
            $sqlValores='';
            $i=0;
            for($i=0; $i<count($v); $i++){            
                if(trim($sqlValores)!=''){
                    $sqlValores.=',';
                }
                if(is_null($resultado->fields[$v[$i]['campo']])){
                    $sqlValores.="NULL";
                }else{
                    if($v[$i]['tipo']=="mediumblob"){
                        $sqlValores.="0x".bin2hex($resultado->fields[$v[$i]['campo']])."";
                    }else if(strrpos($v[$i]['tipo'], 'int')>-1 || strrpos($v[$i]['tipo'], 'float')>-1){
                        $sqlValores.="".$resultado->fields[$v[$i]['campo']]."";
                    }
                    else{
                        $sqlValores.="'".str_replace(array("\r\n","\n"), array("\\r\\n","\\n"), addslashes($resultado->fields[$v[$i]['campo']]))."'";
                    }
                }
            }
            if($primeiro || $conta>=70000){
                if(!$primeiro){
                    $retorno .= ";\n";
                }
                $retorno .= "INSERT INTO $c ($sqlCampos) VALUES ";
                $conta=0;
            }
            else{
               $retorno .=",";                
            }
            $primeiro=false;
            $conta+=strlen($sqlValores);
            $retorno .="($sqlValores)";
            $resultado->MoveNext();
            if(!$resultado->EOF){
             $retorno .="\n";
            }            
        }
    }
    $retorno.=";\n";
    return $retorno;
}
require_once('lib/nusoap.php');

$server = new soap_server(); 							// Create the server instance
$server->configureWSDL('wsdlBackup', 'urn:wsdlBackup');	// Initialize WSDL support
class RetornoBuscaZip {
	var $AconteceuErro;
	var $Erro;
	var $Zip;
}

$server->wsdl->addComplexType(
    'RetornoBuscaZip',
    'complexType',
    'struct',
    'all',
    '',
	array(
		'AconteceuErro' => array('name' => 'erro', 'type' => 'xsd:boolean'),
		'Erro' => array('name' => 'descerro', 'type' => 'xsd:string'),
        'Zip' => array('name' => 'script', 'type' => 'xsd:string')	
	)
);
$server->register(
	"buscaZip",
array("ticketLogin"=>"xsd:string"),
array("return" => "tns:RetornoBuscaZip"),
	'urn:wsdlBackup',				// namespace
	'urn:wsdlBackup#buscaZip',		// soapaction
	"rpc",
	"encoded");
    
    
function buscaZip($ticketLogin){
    $ret = new RetornoBuscaZip();
    if(!tentaExcluirTicket($ticketLogin)){
        $ret->AconteceuErro = true;
		$ret->Erro = "Login inválido!";
		return $ret;
    }
    ob_start();
    $teste = new ZipStream();
    addFolderToZip('../',$teste);
    exportaBanco($teste);

    $teste->finish();
    $ret->Zip = base64_encode(ob_get_contents());
    ob_end_clean();
    $ret->AconteceuErro = false;
    $ret->Erro = "";
    return $ret;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$server->service($HTTP_RAW_POST_DATA);
$server->service(file_get_contents("php://input"));
?>