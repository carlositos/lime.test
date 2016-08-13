<?php

namespace app\models\wordpress;

use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use app\models\Sources;

class WpSource extends Sources
{
	private $_wpTables = [
		'wp_commentmeta',
		'wp_comments',
		'wp_links',
		'wp_options',
		'wp_postmeta',
		'wp_posts',
		'wp_seo_title_tag_category',
		'wp_seo_title_tag_tag',
		'wp_seo_title_tag_url',
		'wp_terms',
		'wp_term_relationships',
		'wp_term_taxonomy',
		'wp_usermeta',
		'wp_users',
		'wp_nxs_log',
		'wp_yarpp_related_cache',
		'wp_wp_rp_tags',
		'wp_formcraft_b_views',
		'wp_formcraft_b_submissions',
		'wp_formcraft_b_forms',
		'wp_ratings',
		'wp_top_ten_daily',
		'wp_termmeta'
	];
	
	public function copyDataToGlobalTables($sourceId)
	{
		//copy data to global posts table
		$posts = TmpWpPosts::find()->all();
		foreach ($posts as $oldPost) {
			//if such row does not exists in general table, lets save all data
			if(!GlobalWpPosts::find()->where(['source_id'=>$sourceId, 'post_id'=>$oldPost->ID])->exists())
			{
				$newPost = new GlobalWpPosts();
				$newPost->post_id = $oldPost->ID;
				$newPost->source_id = $sourceId;
				$newPost->post_title = $oldPost->post_title;
				
				$newPost->save();
			}
			
		}
	}
	
	public function truncateTmpTables()
	{
		foreach($this->_wpTables as $tableName){
			if(Yii::$app->db->schema->getTableSchema($tableName) !== null)
				Yii::$app->db->createCommand()->dropTable($tableName)->execute();
		}	
	}
	
}
