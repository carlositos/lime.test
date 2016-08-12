<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'sqlFiles[]')->widget(FileInput::classname(), [
	    'options' => [
	    	'multiple' => true
	    ],
	]); ?>
	
	<?= Html::submitButton('Save', ['class' => 'btn btn-lg btn-success']) ?>

<?php ActiveForm::end() ?>