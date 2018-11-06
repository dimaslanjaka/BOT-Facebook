<?php
///*** FREE OF USE ***///
require('config.php');
require_once('lib/fb.php');

$r_male		= 3; // reaction if user MALE , like = 1, love = 2, wow = 3, haha = 4, sad = 7, angry = 8
$r_female	= 2; // reaction if user FEMALE , like = 1, love = 2, wow = 3, haha = 4, sad = 7, angry = 8
$max_status	= 4; // Limit Reaction of post
$token = ''; //Leave blank for Auto Fetch Token
$useragent = "Mozilla/5.0 (Linux; Android 7.0; Redmi Note 4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.80 Mobile Safari/537.36"; // user agent for bot
$cpu_limit = 50; //50 Percent CPU usage
//Script tidak akan dijalankan bila server cpu melewati persen diatas

$config['cookie_file'] = 'cookie.txt';
$config['useragent'] = $useragent;
if (!file_exists($config['cookie_file'])) {
    $fp = @fopen($config['cookie_file'], 'w');
    @fclose($fp);
}

if ($auth["user"]){
    $options["like_comments"] = (isset($auth["like_comments"]) && $auth["like_comments"] === true ? true : false);
  $user = (isset($auth["user"]) ? $auth["user"] : false);
  echo "Result for ".$user."\n";
  $pass = (isset($auth["pass"]) ? $auth["pass"] : false);
  if (false === $user || $pass === false){ die("username/password required"); }
$reaction = new Reaction();
$user = $reaction->open_ssl("encrypt", $user);
$pass = $reaction->open_ssl("encrypt", $pass);
$reaction->React($user, $pass, $token, $r_male, $r_female, $max_status, $options);
} else foreach (array_filter($auth) as $data){
  $options["like_comments"] = (isset($data["like_comments"]) && $data["like_comments"] === true ? true : false);
  $user = (isset($data["user"]) ? $data["user"] : false);
  echo "Result for ".$user."\n";
  $pass = (isset($data["pass"]) ? $data["pass"] : false);
  if (false === $user || $pass === false){ continue; }
$reaction = new Reaction();
$user = $reaction->open_ssl("encrypt", $user);
$pass = $reaction->open_ssl("encrypt", $pass);
$reaction->React($user, $pass, $token, $r_male, $r_female, $max_status, $options);
}