<?php
namespace app\components;

class ContentHelper
{
	
	public static function clearImgs($content){
	    return preg_replace("/<img[^>]+\>/i", "(image) ", $content); 
	}
	
	public static function clearLinks($content){
		return preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $content);
	}
	
}
?>