<?php
namespace app\models\wordpress;

use Yii;
use app\models\wordpress\GlobalWpPosts;

class RssFeed  {
	
	private $sourceId;
	public $xmlns;
	public $channelProperties;
	
	public function __construct($sourceId, $xmlns, $aChannel){
		// initialize
		$this->sourceId = $sourceId;
		$this->xmlns = ($xmlns ? ' ' . $xmlns : '');
		$this->channelProperties = $aChannel;
	}

	/**
	 * Generate RSS 2.0 feed
	 *
	 * @return string RSS 2.0 xml
	 */
	public function createFeed(){		
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
		$xml .= '<rss version="2.0"' . $this->xmlns . '>' . "\n";
	
		// channel required properties
		$xml.= '<channel>' . "\n";
		$xml.= '<title>' . $this->channelProperties["title"] . '</title>' . "\n";
		$xml.= '<link>' . $this->channelProperties["link"] . '</link>' . "\n";
		$xml.= '<description>' . $this->channelProperties["description"] . '</description>' . "\n";
		$xml.= '<language>' . $this->channelProperties["language"] . '</language>' . "\n";
	
		// get RSS channel items
		$rssItems = GlobalWpPosts::find()->where(['source_id'=>$this->sourceId])->all();
		foreach($rssItems as $rssItem)
		{
			$xml.= '<item>' . "\n";
				$xml.= '<title>' . $rssItem->post_title . '</title>' . "\n";
				$xml.= '<link>' . $rssItem->link . '</link>' . "\n";
				//$xml.= '<description>' . $rssItem->post_content . '</description>' . "\n";
				
				$date = \DateTime::createFromFormat('Y-m-d H:i:s', $rssItem->post_date);
				$xml.= '<pubDate>' . $date->format(DATE_RSS) . '</pubDate>' . "\n";
				
				$xml.= '<guid isPermaLink="false">'.$rssItem->guid.'</guid>' . "\n";
				$xml.= '<description></description>' . "\n";
				$xml.= '<content:encoded><![CDATA['.$rssItem->post_content.']]></content:encoded>' . "\n";
				$xml.= '<excerpt:encoded><![CDATA['.$rssItem->post_content.']]></excerpt:encoded>' . "\n";
				$xml.= '<wp:post_id>'.$rssItem->post_id.'</wp:post_id>' . "\n";
				$xml.= '<wp:post_date>'.$rssItem->post_date.'</wp:post_date>' . "\n";
				$xml.= '<wp:post_date_gmt>'.$rssItem->post_date_gmt.'</wp:post_date_gmt>' . "\n";
				$xml.= '<wp:comment_status>'.$rssItem->comment_status.'</wp:comment_status>' . "\n";
				$xml.= '<wp:ping_status>'.$rssItem->ping_status.'</wp:ping_status>' . "\n";
				$xml.= '<wp:post_name>'.$rssItem->post_name.'</wp:post_name>' . "\n";
				$xml.= '<wp:status>'.$rssItem->post_status.'</wp:status>' . "\n";
				$xml.= '<wp:post_parent>'.$rssItem->post_parent.'</wp:post_parent>' . "\n";
				$xml.= '<wp:menu_order>'.$rssItem->menu_order.'</wp:menu_order>' . "\n";
				$xml.= '<wp:post_type>'.$rssItem->post_type.'</wp:post_type>' . "\n";
				$xml.= '<wp:post_password>'.$rssItem->post_password.'</wp:post_password>' . "\n";
				
			$xml.= '</item>' . "\n";
		}
	
		$xml.= '</channel>';
		$xml.= '</rss>';
		
		return $xml;
	}

	private function test($str){
		return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
		/*return preg_replace_callback('#[\\xA1-\\xFF](?![\\x80-\\xBF]{2,})#', function ($m) {
		    return utf8_encode($m[0]);
		}, $str);*/
	}
 
}
?>