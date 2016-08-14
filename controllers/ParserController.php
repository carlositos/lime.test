<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Sources;
use app\models\SourcesSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\wordpress\GlobalWpPosts;
use app\models\wordpress\GlobalWpPostmeta;

class ParserController extends Controller
{
	
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SourcesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	/**
     * Deletes an existing Sources model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		GlobalWpPosts::deleteAll(['source_id'=>$id]);
		GlobalWpPostmeta::deleteAll(['source_id'=>$id]);
		unlink(Yii::$app->params['sqlFilesStorage'].'/' . Sources::findOne($id)->filename . '.sql');
		$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	/**
     * Finds the Sources model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sources the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sources::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionTest()
	{
		
	}
}