<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function getYouTubeId($url){
	preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $url, $matches);
	return "http://www.youtube.com/embed/" . $matches[2];
}

function getVimeoId($url){
	preg_match('#vimeo\.com\/([0-9]{1,10})#', $url, $matches);
	return "http://player.vimeo.com/video/" . $matches[1] . "?title=1&amp;byline=0&amp;portrait=0";
}

function getVideoId($url){
	if (strpos($url, 'youtube') !== FALSE)
		return getYouTubeId($url);
	else if (strpos($url, 'vimeo') !== FALSE)
		return getVimeoId($url);
	return null;
}

function slugify($text)
{ 
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}

// price and money functions
function priceWithDots($v) {
	$v = OnlyNum($v);
	$n = strlen($v);
	if ($n > 2) {
		$l = substr($v, 0, $n-2);
		$r = substr($v, $n-2, $n);
		
		return sprintf('%0.2f',floatval($l.'.'.$r));
	} else
		return sprintf('%0.2f',$v);;
}

function PriceInWords($valor=0) {
	$len = strlen($valor);
	$price_f = FormatCurrency($valor);
	
	$price_show_exp = explode('.', $price_f);
	$price_show = $price_show_exp[0];
	
	if ($len == 0)
		return 'zero';
	else if ($len > 0 && $len <= 5) {
		if ($valor == 1) return $valor.' real';
		else return $valor.' reais';
	} else if ($len > 5 && $len <= 8)
		return $price_show.' mil';
	else if ($len > 8)
		return $price_show.'.'.substr($price_show_exp[1],0,2).' milhões';
}

function OnlyNum($str) {
	return filter_var($str, FILTER_SANITIZE_NUMBER_INT);
}

function FormatCurrency($price) {
	if (!empty($price)) {
		$price = trim(OnlyNum($price));
		$price_pos = substr($price,strlen($price)-2,strlen($price));
		$price_pre = substr($price,0,strlen($price)-2);
		$price_formatted = $price_pre.'.'.$price_pos;
	
		setlocale(LC_MONETARY, 'pt_BR');
		return number_format($price_formatted, 2, ',', '.');
	} else
		return '0,00';
}

// image relative functions
if (!function_exists('is_image')){
	function is_image($fullpath)
	{
		$real_mime = get_real_mime($fullpath);
		
		$img_mimes = array(
							'image/gif',
							'image/jpeg',
							'image/png',
						);

		return (in_array($real_mime, $img_mimes, TRUE)) ? TRUE : FALSE;
	}
}

if (!function_exists('get_real_mime')){
	function get_real_mime($fullpath)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		return finfo_file($finfo, $fullpath);
	}
}

function image_effects($file){
	if(preg_match("/.jpg/i", "$file")) $format = 'image/jpeg';

	if (preg_match("/.gif/i", "$file")) $format = 'image/gif';

   	if(preg_match("/.png/i", "$file")) $format = 'image/png';
	
	switch($format) {
           case 'image/jpeg':
           $image = imagecreatefromjpeg($file);
           break;

           case 'image/gif';
           $image = imagecreatefromgif($file);
           break;

           case 'image/png':
           $image = imagecreatefrompng($file);
           break;
       }
       
	imagefilter($image, IMG_FILTER_GRAYSCALE);
	imagejpeg($image, $file);			
}

function resize_then_crop($filein, $fileout, $imagethumbsize_w, $imagethumbsize_h) {
	$red = 255;
	$green = 255;
	$blue = 255;
	$white = 255;
	$percent = 0;
	// Get new dimensions
	list($width, $height) = getimagesize($filein);
	$new_width = $width * $percent;
	$new_height = $height * $percent;

	if(preg_match("/.jpg/i", "$filein")) $format = 'image/jpeg';

	if (preg_match("/.gif/i", "$filein")) $format = 'image/gif';

   	if(preg_match("/.png/i", "$filein")) $format = 'image/png';

       switch($format) {
           case 'image/jpeg':
           $image = imagecreatefromjpeg($filein);
           break;

           case 'image/gif';
           $image = imagecreatefromgif($filein);
           break;

           case 'image/png':
           $image = imagecreatefrompng($filein);
           break;
       }

	$width = $imagethumbsize_w ;
	$height = $imagethumbsize_h ;

	list($width_orig, $height_orig) = getimagesize($filein);

	if ($width_orig < $height_orig) {
		$height = ($imagethumbsize_w / $width_orig) * $height_orig;
	} else {
		$width = ($imagethumbsize_h / $height_orig) * $width_orig;
	}

	if ($width < $imagethumbsize_w) {
		//if the width is smaller than supplied thumbnail size 
		$width = $imagethumbsize_w;
		$height = ($imagethumbsize_w/ $width_orig) * $height_orig;;
	}

	if ($height < $imagethumbsize_h) {
		//if the height is smaller than supplied thumbnail size 
		$height = $imagethumbsize_h;
		$width = ($imagethumbsize_h / $height_orig) * $width_orig;
	}

	$thumb = imagecreatetruecolor($width , $height);  
	$bgcolor = imagecolorallocate($thumb, $red, $green, $blue);  
	ImageFilledRectangle($thumb, 0, 0, $width, $height, $bgcolor);
	imagealphablending($thumb, true);

	imagecopyresampled($thumb, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	$thumb2 = imagecreatetruecolor($imagethumbsize_w , $imagethumbsize_h);

	// true color for best quality
	$bgcolor = imagecolorallocate($thumb2, $red, $green, $blue);  
	ImageFilledRectangle($thumb2, 0, 0, $imagethumbsize_w , $imagethumbsize_h , $white);
	imagealphablending($thumb2, true);

	$w1 =($width/2) - ($imagethumbsize_w/2);
	$h1 = ($height/2) - ($imagethumbsize_h/2);

	imagecopyresampled($thumb2, $thumb, 0,0, $w1, $h1, $imagethumbsize_w , $imagethumbsize_h ,$imagethumbsize_w, $imagethumbsize_h);

	if ($fileout !="")imagejpeg($thumb2, $fileout, 100); //write to file
}

// data parsing to insert on database
if (!function_exists('StrtoDB')){
   function StrtoDB($s, $t='')
   {
      if (is_array($s)){
         return "{".implode(',', $s)."}";
      }else{
         if ($t == 'html') return $s;

         $s = trim(strip_tags($s));
         if ($s == '') return null;

         switch ($t) {
            case 'uc':
               $s = myUpper($s);
               break;
            case 'lc':
               $s = myLower($s);
               break;
            case 'pass':
               $CI =& get_instance();
               $s = md5($s.$CI->config->item('encryption_keyname'));
               break;
            case 'json':
               if ($s === 'false') $s = "[]";
               break;
            case 'date':
               $s = dateBRtoUS($s);
               break;
            case 'time':
               $s = date('H:i:s', strtotime($s));
               break;
            case 'int':
               $s = isInt($s) ? $s : OnlyNum($s);
               break;
            case 'float':
               $s = str_replace(".", "", $s);
               $s = str_replace(",", ".", $s);
               break;
         }
         return $s == '' ? null : $s;
      }
   }
}

if (!function_exists('SetData')){
	function setData($field, $t='', $fieldDB='')
	{
		if (empty($fieldDB)) $fieldDB = $field;
		
		$CI =& get_instance();
		$CI->db->set($fieldDB, StrtoDB($CI->input->post($field), $t));
	}
}

// uppercase with latin chars
if (!function_exists('myUpper')){
   function myUpper ($str)
   {
      return strtoupper(strtr($str, LATIN1_LC_CHARS, LATIN1_UC_CHARS));
   }
}

// lowercase with latin chars
if (!function_exists('myLower')){
   function myLower ($str)
   {
      return strtolower(strtr($str, LATIN1_UC_CHARS, LATIN1_LC_CHARS));
   }
}

// directories
if (!function_exists('create_dirs_recursive'))
{
    function create_dirs_recursive($pathname)
    {
    	$mode = NULL;
        // Check if directory already exists
        if (is_dir($pathname) || empty($pathname))
        {
            return true;
        }
      
        // Ensure a file does not already exist with the same name
        $pathname = str_replace(array('/', ''), '/', $pathname);
        if (is_file($pathname))
        {
            trigger_error('mkdirr() File exists', E_USER_WARNING);
            return false;
        }
      
        // Crawl up the directory tree
        $next_pathname = substr($pathname, 0, strrpos($pathname, '/'));
        if (create_dirs_recursive($next_pathname))
        {
            if (!file_exists($pathname))
            {
                return mkdir($pathname);
            }
        }
      
        return false;
    }
}

if (!function_exists('array_replace_recursive'))
{
  function array_replace_recursive($array, $array1)
  {
    function recurse($array, $array1)
    {
      foreach ($array1 as $key => $value)
      {
        // create new key in $array, if it is empty or not an array
        if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key])))
        {
          $array[$key] = array();
        }
 
        // overwrite the value in the base array
        if (is_array($value))
        {
          $value = recurse($array[$key], $value);
        }
        $array[$key] = $value;
      }
      return $array;
    }
 
    // handle the arguments, merge one by one
    $args = func_get_args();
    $array = $args[0];
    if (!is_array($array))
    {
      return $array;
    }
    for ($i = 1; $i < count($args); $i++)
    {
      if (is_array($args[$i]))
      {
        $array = recurse($array, $args[$i]);
      }
    }
    return $array;
  }
}

// dates
if (!function_exists('ExpectedDelivery')){
	function ExpectedDelivery($date)
	{
		$mkt = mysql_to_unix($date);
		return getMonthBR(date('m', $mkt)).'/'.date('Y', $mkt);
	}
}

if (!function_exists('formatDate'))
{
   function formatDate($date){
   	
   	$arrMonthsOfYear = array('JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO');
   	
   	return strftime("%d", strtotime($date)).' de '.$arrMonthsOfYear[strftime('%m', strtotime($date))-1].' de '.strftime("%Y", strtotime($date));
   }
}

if (!function_exists('getWeekdayBR')){
	function getWeekdayBR($date, $abbr=false, $lc=false)
	{
		$date = date('w',strtotime($date));
		$ret = '';
		switch($date) {
			case 0:
				if ($abbr) $ret =  'Dom';
				else $ret =  'Domingo';
				break;
			case 1:
				if ($abbr) $ret =  'Seg';
				else $ret =  'Segunda-feira';
				break;
			case 2:
				if ($abbr) $ret =  'Ter';
				else $ret =  'Terça-feira';
				break;
			case 3:
				if ($abbr) $ret =  'Qua';
				else $ret =  'Quarta-feira';
				break;
			case 4:
				if ($abbr) $ret =  'Qui';
				else $ret =  'Quinta-feira';
				break;
			case 5:
				if ($abbr) $ret =  'Sex';
				else $ret =  'Sexta-feira';
				break;
			case 6:
				if ($abbr) $ret =  'Sab';
				else $ret =  'Sábado';
				break;
			default:
				$ret =  'N/D';
		}
		
		if ($lc) $ret = myLower($ret);
		return $ret;
	}
}

if (!function_exists('getMonthBR')){
	function getMonthBR($date, $abbr=false, $lc=false,$lang='pt')
	{
		$ret = '';
        if($lang == 'en'){
    		switch($date) {
    			case 1:
    				if ($abbr) $ret =  'Jan';
    				else $ret =  'January';
    				break;
    			case 2:
    				if ($abbr) $ret =  'Feb';
    				else $ret =  'February';
    				break;
    			case 3:
    				if ($abbr) $ret =  'Mar';
    				else $ret =  'March';
    				break;
    			case 4:
    				if ($abbr) $ret =  'Apr';
    				else $ret =  'April';
    				break;
    			case 5:
    				if ($abbr) $ret =  'May';
    				else $ret =  'May';
    				break;
    			case 6:
    				if ($abbr) $ret =  'Jun';
    				else $ret =  'June';
    				break;
    			case 7:
    				if ($abbr) $ret =  'Jul';
    				else $ret =  'July';
    				break;
    			case 8:
    				if ($abbr) $ret =  'Aug';
    				else $ret =  'August';
    				break;
    			case 9:
    				if ($abbr) $ret =  'Sep';
    				else $ret =  'September';
    				break;
    			case 01:
                    if ($abbr) $ret =  'Jan';
                    else $ret =  'January';
                    break;
                case 02:
                    if ($abbr) $ret =  'Feb';
                    else $ret =  'February';
                    break;
                case 03:
                    if ($abbr) $ret =  'Mar';
                    else $ret =  'March';
                    break;
                case 04:
                    if ($abbr) $ret =  'Apr';
                    else $ret =  'April';
                    break;
                case 05:
                    if ($abbr) $ret =  'May';
                    else $ret =  'May';
                    break;
                case 06:
                    if ($abbr) $ret =  'Jun';
                    else $ret =  'June';
                    break;
                case 07:
                    if ($abbr) $ret =  'Jul';
                    else $ret =  'July';
                    break;
                case 08:
                    if ($abbr) $ret =  'Aug';
                    else $ret =  'August';
                    break;
                case 09:
                    if ($abbr) $ret =  'Sep';
                    else $ret =  'September';
                    break;
                case 10:
                    if ($abbr) $ret =  'Oct';
                    else $ret =  'October';
                    break;
                case 11:
                    if ($abbr) $ret =  'Nov';
                    else $ret =  'November';
                    break;
                case 12:
                    if ($abbr) $ret =  'Dec';
                    else $ret =  'December';
                    break;
    		}
        }else{
            switch($date) {
                case 1:
                    if ($abbr) $ret =  'Jan';
                    else $ret =  'Janeiro';
                    break;
                case 2:
                    if ($abbr) $ret =  'Fev';
                    else $ret =  'Fevereiro';
                    break;
                case 3:
                    if ($abbr) $ret =  'Mar';
                    else $ret =  'Março';
                    break;
                case 4:
                    if ($abbr) $ret =  'Abr';
                    else $ret =  'Abril';
                    break;
                case 5:
                    if ($abbr) $ret =  'Mai';
                    else $ret =  'Maio';
                    break;
                case 6:
                    if ($abbr) $ret =  'Jun';
                    else $ret =  'Junho';
                    break;
                case 7:
                    if ($abbr) $ret =  'Jul';
                    else $ret =  'Julho';
                    break;
                case 8:
                    if ($abbr) $ret =  'Ago';
                    else $ret =  'Agosto';
                    break;
                case 9:
                    if ($abbr) $ret =  'Set';
                    else $ret =  'Setembro';
                    break;
                case 01:
                    if ($abbr) $ret =  'Jan';
                    else $ret =  'Janeiro';
                    break;
                case 02:
                    if ($abbr) $ret =  'Fev';
                    else $ret =  'Fevereiro';
                    break;
                case 03:
                    if ($abbr) $ret =  'Mar';
                    else $ret =  'Março';
                    break;
                case 04:
                    if ($abbr) $ret =  'Abr';
                    else $ret =  'Abril';
                    break;
                case 05:
                    if ($abbr) $ret =  'Mai';
                    else $ret =  'Maio';
                    break;
                case 06:
                    if ($abbr) $ret =  'Jun';
                    else $ret =  'Junho';
                    break;
                case 07:
                    if ($abbr) $ret =  'Jul';
                    else $ret =  'Julho';
                    break;
                case 08:
                    if ($abbr) $ret =  'Ago';
                    else $ret =  'Agosto';
                    break;
                case 09:
                    if ($abbr) $ret =  'Set';
                    else $ret =  'Setembro';
                    break;
                case 10:
                    if ($abbr) $ret =  'Out';
                    else $ret =  'Outubro';
                    break;
                case 11:
                    if ($abbr) $ret =  'Nov';
                    else $ret =  'Novembro';
                    break;
                case 12:
                    if ($abbr) $ret =  'Dez';
                    else $ret =  'Dezembro';
                    break;
                default:
                    $ret =  'N/D';
            }
        }
		
		if ($lc) $ret = myLower($ret);
		return $ret;
	}
}

if (!function_exists('formatDateTime')){
	function formatDateTime($date,$just_hour=false){
		$x = datetimeToArray($date);
		$date_ = dateUStoBR($x[0]);
		$time_ = timelongToShort($x[1]);
		if($just_hour){
			return $time_;
		}else{
			return $date_.' às '.$time_;
		}
	}
}

if (!function_exists('datetimeToArray')){
   function datetimeToArray($date)
   {
      if (empty($date)) return NULL;
      $x = explode(" ", $date);
      return $x;
   }
}

if (!function_exists('dateBRtoUS')){
   function dateBRtoUS($date)
   {
      if (empty($date)) return NULL;
      $x = explode("/", $date);
      return $x[2]."-".$x[1]."-".$x[0];
   }
}

if (!function_exists('dateUStoBR')){
   function dateUStoBR($date)
   {
      if (empty($date)) return NULL;
      $x = explode("-", $date);
      return $x[2]."/".$x[1]."/".$x[0];
   }
}

if (!function_exists('timelongToShort')){
   function timelongToShort($time)
   {
      if (empty($time)) return NULL;
      $x = explode(":", $time);
      return $x[0].":".$x[1];
   }
}

// numbers
if (!function_exists('isInt'))
{
   function isInt($num='')
   {
      return $num != '' ? preg_match("/^[0-9]+$/", $num) : false;
   }
}

// strings
if (!function_exists('generatePassword'))
{
	function generatePassword($num=10) {
		$pass = random_string('alnum', $num);
		return array('plain'=>$pass, 'md5'=>md5($pass));
	}
}

//Mensagem de Erro em Imagens
if (!function_exists('ImageErrors'))
{
	
	function ImageErrors($error){
			$error = strip_tags($error);
		
			switch ($error)
			{
				case 'upload_invalid_dimensions':
						$message_error = 'As dimensões da imagem estão incorretas.'; 
						break;
				case 'upload_invalid_filesize': 
						$message_error = 'A imagem é muito grande.'; 
						break;
				case 'upload_invalid_filetype':
						$message_error = 'A extensão da imagem enviada não é permitida.';
						break;
				default:
						$message_error = 'Erro tratando imagem.';
						break;
			}

			return $message_error;
	}
}

function imageMask(&$img, &$mask, &$target_file) {

	$img = imagecreatefromjpeg($img);
	$mask = imagecreatefromjpeg($mask);

   $xSize = imagesx($img);
   $ySize = imagesy($img);
   $newPicture = imagecreatetruecolor($xSize, $ySize);
   imagesavealpha($newPicture, true);
   imagefill($newPicture, 0, 0, imagecolorallocatealpha($newPicture, 0, 0, 0, 127));
  
   if($xSize != imagesx($mask) || $ySize != imagesy($mask)) {
       $tempPic = imagecreatetruecolor($xSize, $ySize);
       imagecopyresampled($tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx($mask), imagesy($mask));
       imagedestroy($mask);
       $mask = $tempPic;
   }
          
   for($x = 0; $x < $xSize; $x++) {
       for($y = 0; $y < $ySize; $y++) {
           $alpha = imagecolorsforindex($mask, imagecolorat($mask, $x, $y));
           $alpha = 127 - floor($alpha['red'] / 2);
           $color = imagecolorsforindex($img, imagecolorat($img, $x, $y));
           imagesetpixel($newPicture, $x, $y, imagecolorallocatealpha($newPicture, $color['red'], $color['green'], $color['blue'], $alpha));
       }
   }
   
   imagedestroy($img);
   $img = $newPicture;

   imagepng($img, $target_file);

   return $target_file;
}