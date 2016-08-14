<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use app\models\wordpress\GlobalWpPosts;
use app\models\Sources;
use app\models\wordpress\RssFeed;

/**
 * SourceController implements the CRUD actions for Sources model.
 */
class SiteController extends Controller
{
	
	public function actionRss($id)
	{
		$source = Sources::find()->where(['id'=>$id])->one();
				 
		// configure appropriately
		$aChannel = [
		  "title" => $source->filename,
		  "link" => $source->siteurl,
		  "description" => "Blog",
		  "language" => Yii::$app->language
		];
		$rss = new RssFeed([$source->id], $aChannel);
		
		header('Content-type: text/xml');
		header('Content-Disposition: attachment; filename="'.str_replace('http://', '', $source->siteurl).'.xml"');
		
		echo $rss->createFeed();
	}
	
	public function actionRssOne($ids)
	{				 
		// configure appropriately
		$aChannel = [
		  "title" => Yii::$app->name,
		  "link" => Url::toRoute('/', true),
		  "description" => "Blogs",
		  "language" => Yii::$app->language
		];
		$rss = new RssFeed(explode(",", urldecode($ids)), $aChannel);
		
		header('Content-type: text/xml');
		header('Content-Disposition: attachment; filename="general.xml"');
		
		echo $rss->createFeed();
	}
	
}
