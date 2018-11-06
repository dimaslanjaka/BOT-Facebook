# BOT-Facebook
Script bot Facebook

## Install via git
```
git clone https://github.com/dimaslanjaka/BOT-Facebook.git
```

## Edit config.php
```php
//--- single account
$auth = array(
"user	"	=> 'username',
"pass" => 'password',
"token" => "", //blank for auto get token
"like_comments" => false, //true for autolike comments and replies
 );
 //** OR **//
//--- multiple accounts
$auth = array(
 array(
 "user" => "username",
 "pass" => "password",
 "token" => "", //blank for auto get token
 "like_comments" => false, //true for autolike comments and replies
 ),
 array(
 "user" => "username",
 "pass" => "password",
 "token" => "", //blank for auto get token
 "like_comments" => false, //true for autolike comments and replies
 ),
 array(
 "user" => "username",
 "pass" => "password",
 "token" => "", //blank for auto get token
 "like_comments" => false, //true for autolike comments and replies
 ),
);
```
