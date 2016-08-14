<?php
namespace app\models\wordpress;

use Yii;
use app\models\wordpress\GlobalWpPosts;

class RssFeed  {
	
	private $sourceIds = [];
	public $xmlns = 'xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
				xmlns:content="http://purl.org/rss/1.0/modules/content/"
				xmlns:wfw="http://wellformedweb.org/CommentAPI/"
				xmlns:dc="http://purl.org/dc/elements/1.1/"
				xmlns:wp="http://wordpress.org/export/1.2/"';
	public $channelProperties;
	
	public function __construct($sourceIds, $aChannel){
		// initialize
		$this->sourceIds = $sourceIds;
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
		foreach($this->sourceIds as $sourceId)
		{
			$rssItems = GlobalWpPosts::find()->where(['source_id'=>$sourceId])->all();
			foreach($rssItems as $rssItem)
			{
				$xml.= '<item>' . "\n";
					$xml.= '<title>' . $rssItem->post_title . '</title>' . "\n";
					$xml.= '<link>' . $rssItem->link . '</link>' . "\n";
					
					$date = \DateTime::createFromFormat('Y-m-d H:i:s', $rssItem->post_date);
					$xml.= '<pubDate>' . $date->format(DATE_RSS) . '</pubDate>' . "\n";
					$xml.= '<guid isPermaLink="false">'.$rssItem->guid.'</guid>' . "\n";
					$xml.= '<description></description>' . "\n";
					$xml.= '<content:encoded><![CDATA['.$rssItem->post_content.']]></content:encoded>' . "\n";
					$xml.= '<excerpt:encoded><![CDATA['.$rssItem->post_excerpt.']]></excerpt:encoded>' . "\n";
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
		}
		
		$xml.= '</channel>';
		$xml.= '</rss>';
		
		return $xml;
	}

}
?>