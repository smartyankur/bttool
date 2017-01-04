<?php
/**
* Class for Utility Funtions
*
* @package LMS
* @copyright Venza Group <http://www.venzagroup.com/>
* @author Venza Group
* @version 2011
**/

class Utility {


	/**
	* Class constructor
	*
	* @access public
	* @param void
	* @return void
	**/
	function Utility() {
	}

	/**
	* Function to convert php to JSON
	*
	* @access public
	* @param mixed
	* @return JSON
	**/

  function php_to_js($var) {
    switch (gettype($var)) {
      case 'boolean':
        return $var ? 'true' : 'false'; // Lowercase necessary!
      case 'integer':
      case 'double':
        return $var;
      case 'resource':
      case 'string':
        return '"'. str_replace(array("\r", "\n", "<", ">", "&"),
                                array('\r', '\n', '\x3c', '\x3e', '\x26'),
                                addslashes($var)) .'"';
      case 'array':
        // Arrays in JSON can't be associative. If the array is empty or if it
        // has sequential whole number keys starting with 0, it's not associative
        // so we can go ahead and convert it as an array.
        if (empty ($var) || array_keys($var) === range(0, sizeof($var) - 1)) {
          $output = array();
          foreach ($var as $v) {
            $output[] = $this->php_to_js($v);
          }
          return '[ '. implode(', ', $output) .' ]';
        }
        // Otherwise, fall through to convert the array as an object.
      case 'object':
        $output = array();
        foreach ($var as $k => $v) {
          $output[] = $this->php_to_js(strval($k)) .': '. $this->php_to_js($v);
        }
        return '{ '. implode(', ', $output) .' }';
      default:
        return 'null';
    }
  }



  function generate_toggle_select($attr = array(), $default = '') {
    $attr['style'] = 'width:120px;';
    return $this->generate_select(array(0 => 'Off', 1 => 'On'), $attr, $default, false);
  }

  function generate_toggle_select_yesno($attr = array(), $default = '') {
    $attr['style'] = 'width:120px;';
    return $this->generate_select(array(0 => 'No', 1 => 'Yes'), $attr, $default, false);
  }

  function generate_select($options = array(), $attr = array(), $default = '', $select = true) {
    $str = '<select ';
    $str .= $this->get_attributes($attr);
    $str .= ' >';
    if ($select) {
      if (is_string($select)) {
        $str .= '<option value="0" >'. $select .'</option> ';
      }
      else {
        $str .= '<option value="0" >Select</option> ';
      }
    }
    foreach ($options as $k => $v) {
      $selected = ($default == $k ? ' selected = "selected" ':'');
      $str .= '<option value="'. $k .'" '. $selected .'>'. htmlentities($v) .'</option> ';
    }
    $str .= '</select>';
    return $str;
  }

  function get_attributes($attr = array()) {
    $str = '';
    foreach ($attr as $k=>$v) {
      $str .= $k .'="'. htmlentities($v) .'" ';
    }
    return $str;
  }

  function force_download($content = '', $type = 'txt', $name = 'file') {

    //Gather relevent info about file
    $len = strlen($content);
    $filename = $name.'.'.$type;
    $file_extension = $type;

    //This will set the Content-Type to the appropriate setting for the file
    switch( $file_extension ) {
      case "pdf": $ctype="application/pdf"; break;
      case "exe": $ctype="application/octet-stream"; break;
      case "zip": $ctype="application/zip"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
      case "jpeg":
      case "jpg": $ctype="image/jpg"; break;
      case "mp3": $ctype="audio/mpeg"; break;
      case "wav": $ctype="audio/x-wav"; break;
      case "mpeg":
      case "mpg":
      case "mpe": $ctype="video/mpeg"; break;
      case "mov": $ctype="video/quicktime"; break;
      case "avi": $ctype="video/x-msvideo"; break;
      default: $ctype="application/force-download";
    }

    //Begin writing headers
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");

    //Use the switch-generated Content-Type
    header("Content-Type: $ctype");

    //Force the download
    header("Content-Disposition: attachment; filename=".$filename.";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$len);
    echo $content;
    exit;

	}

    // first parameter must be greater date --
    public static function date_difference($timestamp1, $timestamp2) {

      // configure the base date here
      $base_day = date("j", $timestamp2); // no leading "0"
      $base_mon = date("n", $timestamp2); // no leading "0"
      $base_yr  = date("Y", $timestamp2); // use 4 digit years!
      $base_hr  = date("G", $timestamp2);
      $base_min = date("i", $timestamp2);
      $base_sec = date("s", $timestamp2);
      // get the current date(today) -- change this if you need a fixed date
      $current_day = date("j", $timestamp1);
      $current_mon = date("n", $timestamp1);
      $current_yr  = date("Y", $timestamp1);
      $current_hr  = date("G", $timestamp1);
      $current_min = date("i", $timestamp1);
      $current_sec = date("s", $timestamp1);

      // and now .... calculate the difference! :-)

      // overflow is always caused by max days of $base_mon
      // so we need to know how many days $base_mon had
      $base_mon_max = date("t", mktime(0,0,0,$base_mon,$base_day,$base_yr));

      // sec left till the end of that min
      $base_sec_diff = 60 - $base_sec;
      // min left till the end of that hour
      $base_min_diff = 60 - $base_min -1;
      // hour left till the end of that day
      $base_hr_diff = 24 - $base_hr -1;

      // days left till the end of that month
      $base_day_diff = $base_mon_max - $base_day;

      // month left till end of that year
      // substract one to handle overflow correctly
      $base_mon_diff = 12 - $base_mon - 1;

      // start on jan 1st of the next year
      $start_day = 1;
      $start_mon = 1;
      $start_yr = $base_yr + 1;

      // difference to that 1st of jan
      $sec_diff = $current_sec;
      $min_diff = $current_min;
      $hr_diff = $current_hr;
      $day_diff = ($current_day - $start_day); // add today
      $mon_diff = ($current_mon - $start_mon) + 1; // add current month
      $yr_diff = ($current_yr - $start_yr);

      // and add the rest of $base_yr
      $sec_diff = $sec_diff + $base_sec_diff;
      $min_diff = $min_diff + $base_min_diff;
      $hr_diff = $hr_diff + $base_hr_diff;
      $day_diff = $day_diff + $base_day_diff;
      $mon_diff = $mon_diff + $base_mon_diff;

      // handle overflow of secs
      if ($sec_diff >= 60) {
      $sec_diff = $sec_diff - 60;
      $min_diff = $min_diff + 1;
      }
      // handle overflow of mins
      if ($min_diff >= 60) {
      $min_diff = $min_diff - 60;
      $hr_diff = $hr_diff + 1;
      }
      // handle overflow of days
      if ($hr_diff >= 24) {
      $hr_diff = $hr_diff - 24;
      $day_diff = $day_diff + 1;
      }

      // handle overflow of days
      if ($day_diff >= $base_mon_max) {
      $day_diff = $day_diff - $base_mon_max;
      $mon_diff = $mon_diff + 1;
      }

      // handle overflow of months
      if ($mon_diff >= 12) {
      $mon_diff = $mon_diff - 12;
      $yr_diff = $yr_diff + 1;
      }
      // ****************************************************************************
      $date = new stdClass();
      $date->years   = $yr_diff;
      $date->months  = $mon_diff;
      $date->days    = $day_diff;
      $date->hours   = $hr_diff;
      $date->minutes = $min_diff;
      $date->seconds = $sec_diff;
      return $date;
    }



	public function is_valid_date($date) {
	  // if ( preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date) ) {
		  list($year , $month , $day) = explode('-',$date);
		  return checkdate($month , $day , $year);
	 //  } else {
	//	  return false;
	 //  }
	}



	public function is_incorrect_pattern($pattern,$value)
	{
		if(preg_match($pattern, $value) > 0)
		{	
			return false;
		}	
		else
		{
			return true;
		}
	}
	public function utfEncode($data) {
		$utfEncoded = iconv("UTF-8", "UTF-8//IGNORE", (string)$data);
		return $this->outputEncode($utfEncoded);
	}

	public function outputEncode($data){
		$encodedData = htmlentities($data, ENT_QUOTES, "UTF-8", false);
		return $encodedData;
	}

	public function incorrect_email_address($email)
	{
		if (empty($email))
		{
			return true;
		}
		else
		{
			$pattern = "/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/";
			if(preg_match($pattern, $email))
			{	
				return false;
			}	
			else
			{
				return true;
			}
			
		} 
	}

	public function dataValidator($type, $data,$custom_pattern = null) {
		$data = $this->forceUTF($data);
		$decodeData = html_entity_decode($data, ENT_QUOTES, 'UTF-8');

		$typeArray = array(
		  "number" => '/^[0-9]+$/',
		  "letter" => '/^[a-zA-Z]+$/',
		  "alphan" => '/^[a-zA-Z0-9]+$/',
			"custom"=>$custom_pattern
		);

		// Implement a second array for sanitizing.  Anything that
		// doesn't match will be removed later in the code.
		$sanitizeArray = array(
		  "number" => '/[^0-9]/',
		  "letter" => '/[^a-zA-Z\ ]/',
		  "alphan" => '/[^a-zA-Z0-9\ ]/',
			"custom"=>$custom_pattern
		);

		if (preg_match($typeArray[$type], $decodeData)) {
		  // Return the input data because it passed the validation.
		  return $decodeData;
		} else {
		  // The validation failed, therefore some bad data was 
		  // passed that needs to be removed.  Then return the
		  // sanitized data.
		  $sanitized = preg_replace($sanitizeArray[$type], '', $decodeData);
		  return $sanitized;
		}
	  }

	public function forceUTF($data) {
		$utfEncoded = iconv("UTF-8", "UTF-8//IGNORE", $data);
		return $utfEncoded;
	}

	// Create a function that takes in the type of data
  // and the actual data itself.  The data type will 
  // be used to determine what kind of regex to use.
  function dataValidator1($type, $data,$custom_pattern = null) {

    // Decode the data into a standard character
    // set before performing any checks
    $decodeData = html_entity_decode($data, ENT_QUOTES, 'UTF-8');

    // Declare an array that defines each data type 
    // name along with the regex.  In this example,
    // we are only defining three types to accept: 
    // number - only numbers in the data, letter - 
    // only alphabet characters in the data, and 
    // alphan - alphanumeric characters in the data.
    $typeArray = array(
      "number" => '/^[0-9]+$/',
      "letter" => '/^[a-zA-Z]+$/',
      "alphan" => '/^[a-zA-Z0-9]+$/',
			"custom"=>$custom_pattern
    );

    // Use the PHP preg_match function to determine 
    // if the data only contains those characters.
    // Select the regex type by passing the "type" 
    // submitted to the function in to the array.
    // If there is a match, then the data is good
    // and the if statement returns true, otherwise
    // return false.
    if (preg_match($typeArray[$type], $decodeData)) {
      return true;
    } else {
      return false;
    }
  }



	//log error in file
	function log_error($print,$file,$message){
		$handle = fopen($file,"a+");
		$message = "[".date('Y-m-d H:i:s')."] -  ".$message;
		if($print) {
			echo $message.'<br />';
		}
		fwrite($handle, $message."\n");
		fclose($handle);
	}

}