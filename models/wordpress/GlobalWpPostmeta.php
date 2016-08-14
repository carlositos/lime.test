<?php

namespace app\models\wordpress;

use Yii;

/**
 * This is the model class for table "global_wp_postmeta".
 *
 * @property integer $id
 * @property integer $source_id
 * @property string $meta_id
 * @property string $post_id
 * @property string $meta_key
 * @property string $meta_value
 */
class GlobalWpPostmeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'global_wp_postmeta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id'], 'required'],
            [['source_id', 'meta_id', 'post_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_id' => 'Source ID',
            'meta_id' => 'Meta ID',
            'post_id' => 'Post ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ];
    }
}
