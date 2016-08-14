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
				$newPost->post_date = $oldPost->post_date;
				$newPost->post_date_gmt = $oldPost->post_date_gmt;
				$newPost->post_content = $this->clearContent($oldPost->post_content);
				$newPost->post_title = $oldPost->post_title;
				$newPost->post_excerpt = $oldPost->post_excerpt;
				$newPost->post_status = $oldPost->post_status;
				$newPost->comment_status = $oldPost->comment_status;
				$newPost->ping_status = $oldPost->ping_status;
				$newPost->post_password = $oldPost->post_password;
				$newPost->post_name = $oldPost->post_name;
				$newPost->post_parent = $oldPost->post_parent;
				$newPost->guid = $oldPost->guid;
				$newPost->menu_order = $oldPost->menu_order;
				$newPost->post_type = $oldPost->post_type;
				
				$newPost->save();
			}
		}

		//@commented, not a good decision. @TODO
		/*$metas = TmpWpPostmeta::find()->all();
		foreach ($metas as $oldMeta) {
			
				$newMeta = new GlobalWpPostmeta();
				$newMeta->post_id = $oldMeta->post_id;
				$newMeta->source_id = $sourceId;
				$newMeta->meta_id = $oldMeta->meta_id;
				$newMeta->meta_key = $oldMeta->meta_key;
				$newMeta->meta_value = $oldMeta->meta_value;
				
				$newMeta->save();
			
		}*/
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
