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
		
		// set more namespaces if you need them
		$xmlns = 'xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
				xmlns:content="http://purl.org/rss/1.0/modules/content/"
				xmlns:wfw="http://wellformedweb.org/CommentAPI/"
				xmlns:dc="http://purl.org/dc/elements/1.1/"
				xmlns:wp="http://wordpress.org/export/1.2/"';
		 
		// configure appropriately
		$aChannel = [
		  "title" => $source->filename,
		  "link" => $source->siteurl,
		  "description" => "Blog",
		  "language" => Yii::$app->language
		];
		$rss = new RssFeed($source->id, $xmlns, $aChannel);
		
		header('Content-type: text/xml');
		header('Content-Disposition: attachment; filename="'.str_replace('http://', '', $source->siteurl).'.xml"');
		
		echo $rss->createFeed();
	}
	
}
