<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;

class UploadController extends Controller
{
		
	public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->sqlFiles = UploadedFile::getInstances($model, 'sqlFiles');

			
            if ($model->upload()) {
                return $this->redirect(['/parser/index']);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
}
	