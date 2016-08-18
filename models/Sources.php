<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "sources".
 *
 * @property integer $id
 * @property string $filename
 * @property string $created_at
 */
class Sources extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['filename'], 'required'],
            [['created_at'], 'integer'],
            [['filename','siteurl'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'created_at' => 'Created At',
            'siteurl' => 'Site Url'
        ];
    }
	
	public function behaviors()
    {
   		return [
    		[
    			'class' => TimestampBehavior::className(),
    			'attributes' => [
    				ActiveRecord::EVENT_BEFORE_INSERT => ['created_at',]
    			],
    		],
    	];
    }

	public function executeFile($filename)
	{
		$file = Yii::$app->params['sqlFilesStorage'].'/'.$filename.'.sql';
		
		// Temporary variable, used to store current query
		$templine = '';
		// Read in entire file
		$lines = file($file);
		
		// Loop through each line
		foreach ($lines as $line)
		{
			// Skip it if it's a comment
			if ($this->skipLine($line))
			    continue;
			
			// Add this line to the current segment
			$templine .= $line;
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';')
			{
			    // Perform the query
			    Yii::$app->db->createCommand($templine)->execute();
			    
			    // Reset temp variable to empty
			    $templine = '';
			}
		}
	}
	
	private function skipLine($line)
	{
	    return (substr($line, 0, 2) == '--' || $line == '' || strstr($line,'CREATE DATABASE') || strstr($line,'USE'));
	}
}
