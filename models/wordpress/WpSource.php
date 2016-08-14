<?php

namespace app\models\wordpress;

use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use app\models\Sources;
use app\components\ContentHelper;

class WpSource extends Sources
{
	private $_globalWpTables = [
		'global_wp_postmeta',
		'global_wp_posts',
		'sources',
	];
	
	public function copyDataToGlobalTables($sourceId)
	{
		//saving siteUrl into sources table (in future, maybe, we can pass more data)
		$siteUrl = TmpWpOptions::find()->where(['option_name'=>'siteurl'])->one()->option_value;
		$this->updateData($sourceId, $siteUrl);
		
		//copy data to global posts table
		$posts = TmpWpPosts::find()->all();
		foreach ($posts as $oldPost) {
			//if such row does not exists in general table, lets save all data
			if(!GlobalWpPosts::find()->where(['source_id'=>$sourceId, 'post_id'=>$oldPost->ID])->exists())
			{
				$newPost = new GlobalWpPosts();
				$newPost->post_id = $oldPost->ID;
				$newPost->source_id = $sourceId;
				$newPost->link = $this->getPostLink($oldPost->ID, $siteUrl, $oldPost->post_name, $oldPost->post_type);
				$newPost->creator = $oldPost->author->user_login;
				$newPost->post_title = $oldPost->post_title;
				$newPost->post_date = $oldPost->post_date;
				$newPost->post_date_gmt = $oldPost->post_date_gmt;
				$newPost->post_content = $this->clearContent($oldPost->post_content);
				
				$newPost->save();
			}
		}
	}
	
	private function updateData($sourceId, $siteUrl)
	{
		$siteUrl = TmpWpOptions::find()->where(['option_name'=>'siteurl'])->one()->option_value;
		$source = WpSource::findOne($sourceId);
		$source->siteurl = $siteUrl;
		$source->save();
	}
	
	public function dropTmpTables()
	{
		foreach(Yii::$app->db->schema->tableNames as $tableName){
			if(!in_array($tableName, $this->_globalWpTables))
				Yii::$app->db->createCommand()->dropTable($tableName)->execute();
		}
	}
	
	private function getPostLink($postId, $siteUrl, $postName, $postType)
	{
		switch ($postType) {
			case 'post':
				$permalink = $siteUrl."/".$postName.'/';	
				break;
			
			case 'page':
				$permalink = $siteUrl."/".$postName.'/';
				break;
				
			case 'attachment':
				$permalink = $siteUrl."?attachment_id=".$postId;	
				break;
			
			default:
				$permalink = $siteUrl."?p=".$postId;
				break;
		}
			
		return $permalink;
	}
	
	private function clearContent($content)
	{
		$content = ContentHelper::clearImgs($content);
		$content = ContentHelper::clearLinks($content);
		
		return $content;
	}
	
}
