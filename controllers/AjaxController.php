<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\wordpress\WpSource;

/**
 * SourceController implements the CRUD actions for Sources model.
 */
class AjaxController extends Controller
{
	/**
     * Generate links to RSS based on Sources models.
     * @param array $keys
     * @return html - list of links to XML files
     */
	public function actionGenerateXmlLinks()
	{
		$this->layout = false;
		$keys = Yii::$app->request->post('keys');
		$siteUrls = [];
		
		foreach($keys as $sourceId)
		{
			$db = WpSource::findOne($sourceId);
			$db->executeFile($db->filename);
			$db->copyDataToGlobalTables($sourceId);
			$db->dropTmpTables();
			
			$siteUrls[$sourceId] = $db->siteurl;
		}
		
		return $this->render('_xmlListing', ['siteUrls' => $siteUrls]);
	}
	
}
