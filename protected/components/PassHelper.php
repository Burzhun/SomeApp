<?
class PassHelper
{


public static function salt ()
{

	$salt = md5(rand().time()."edfv");
	return $salt;
}

public static function hash ($password,$salt) 
{

	$hash = md5(md5($password.$salt).sha1($password).$salt);
	return $hash;

}





}