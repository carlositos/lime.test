<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SourceController implements the CRUD actions for Sources model.
 */
class AjaxController extends Controller
{
	/**
     * Generate links to RSS based on Sources models.
     * @param array $keys
     * @return html - list of xml links
     */
	public function actionGenerateXmlFiles()
	{
		$this->layout = false;
		
		return $this->render('_xmlListing');
	}
	
}
