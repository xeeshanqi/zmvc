<?php
class Services{
	// A utility function to get the url leading up to the current script.
	// Used to make the example portable to other locations.
	public static function getScriptUrl(){
        $scriptName = explode('/',$_SERVER['SCRIPT_NAME']);
		unset($scriptName[sizeof($scriptName)-1]);
		$scriptName = array_values($scriptName);
		return 'http://'.$_SERVER['SERVER_NAME'].implode('/',$scriptName).'/';
    }

    static function ip_is_private ($ip) {
		    $pri_addrs = array (
		                      '10.0.0.0|10.255.255.255', // single class A network
		                      '172.16.0.0|172.31.255.255', // 16 contiguous class B network
		                      '192.168.0.0|192.168.255.255', // 256 contiguous class C network
		                      '169.254.0.0|169.254.255.255', // Link-local address also refered to as Automatic Private IP Addressing
		                      '127.0.0.0|127.255.255.255' // localhost
		                     );

		    $long_ip = ip2long ($ip);
		    if ($long_ip != -1) {

		        foreach ($pri_addrs AS $pri_addr) {
		            list ($start, $end) = explode('|', $pri_addr);

		             // IF IS PRIVATE
		             if ($long_ip >= ip2long ($start) && $long_ip <= ip2long ($end)) {
		                 return true;
		             }
		        }
		    }

		    return false;
	}

	public static function QueryStringer(){
		$parts = explode("?", $_SERVER['REQUEST_URI']);
		return $parts[1];
	}

	public static function UADetector ( $type = NULL ) {
          $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
          if ( $type == 'bot' ) {
                  // matches popular bots
                  if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
                          return true;
                          // watchmouse|pingdom\.com are "uptime services"
                  }
          } else if ( $type == 'browser' ) {
                  // matches core browser types
                  if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
                          return true;
                  }
          } else if ( $type == 'mobile' ) {
                  // matches popular mobile devices that have small screens and/or touch inputs
                  // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
                  // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
                  if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
                          // these are the most common
                          return true;
                  } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
                          // these are less common, and might not be worth checking
                          return true;
                  }
          }
          return false;
     }

    public static function getRealIpAddr(){
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

    public static function getBaseUrlMob(){
	  $scriptName = explode('/',$_SERVER['SCRIPT_NAME']);
	  $whitelist = array('127.0.0.1', '::1');
	  if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){ $url = 'http://'.$_SERVER['SERVER_NAME'].'/'; } 
	  else { $url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$scriptName[1].'/'; }
	  return $url;
	}

    public static function MobPath(){
    	$baseURL = self::getBaseUrl();
		if($baseURL=="http://localhost/mpp/"){
			$baseURL = $baseURL;
			$coreUrl = "http://localhost/mpp/";
		} else {
			$baseURL = $baseURL . "/";
			$coreUrl = "http://mypakproperties.com/";
		}
    }

    public static function getBaseUrl(){
        $scriptName = explode('/',$_SERVER['SCRIPT_NAME']);
        $whitelist = array('127.0.0.1', '::1');        
        if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){$url = 'http://'.$_SERVER['SERVER_NAME'].'/'.$scriptName[1].'/';}
		else {$url = 'http://'.$_SERVER['SERVER_NAME'].'/';}
		return $url;
    }

    private function crypto_rand_secure($min, $max){
			$range = $max - $min;
			if ($range < 0) return $min; // not so random...
			$log = log($range, 2);
			$bytes = (int) ($log / 8) + 1; // length in bytes
			$bits = (int) $log + 1; // length in bits
			$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
			do {
				$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
				$rnd = $rnd & $filter; // discard irrelevant bits
			} while ($rnd >= $range);
			return $min + $rnd;
	}

	public function getToken($length=32){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "0123456789";
		for($i=0;$i<$length;$i++){
			$token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
		}
		return $token;
	}
		
	public static function normalizeString ($str = ''){
		$str = strip_tags($str); 
		$str = preg_replace('/[\r\n\t ]+/', ' ', $str);
		$str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
		$str = strtolower($str);
		$str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
		$str = htmlentities($str, ENT_QUOTES, "utf-8");
		$str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
		$str = str_replace(' ', '-', $str);
		$str = rawurlencode($str);
		$str = str_replace('%', '-', $str);
		$str = str_replace('@', '-', $str);
		$str = preg_replace("/[^A-Za-z0-9 ]/", '', $str);
		return $str;
	}

	public static function gen_uuid(){
		    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		        // 32 bits for "time_low"
		        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), 

		        // 16 bits for "time_mid"
		        mt_rand( 0, 0xffff ),

		        // 16 bits for "time_hi_and_version",
		        // four most significant bits holds version number 4
		        mt_rand( 0, 0x0fff ) | 0x4000,

		        // 16 bits, 8 bits for "clk_seq_hi_res",
		        // 8 bits for "clk_seq_low",
		        // two most significant bits holds zero and one for variant DCE1.1
		        mt_rand( 0, 0x3fff ) | 0x8000,

		        // 48 bits for "node"
		        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		    );
	}

	public static function cypher($textToEncrypt, $encryptionMethod="AES-256-CBC", $secretHash ="9AW3WKIHW7LNZFAJLIVu2nrzhmOFGRYI"){
    		$secret_iv = 'ponka';
			$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
		    return openssl_encrypt($textToEncrypt, $encryptionMethod, $secretHash, 0, $iv);
	}

	public static function dcypher($encryptedMessage, $encryptionMethod="AES-256-CBC", $secretHash ="9AW3WKIHW7LNZFAJLIVu2nrzhmOFGRYI"){
			$secret_iv = 'ponka';
			$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
		    return openssl_decrypt($encryptedMessage, $encryptionMethod, $secretHash, 0, $iv);
	}
}
?>