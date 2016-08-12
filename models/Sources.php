<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
            [['filename'], 'string', 'max' => 255],
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
}
