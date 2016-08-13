<?php

namespace app\models\wordpress;

use Yii;

/**
 * This is the model class for table "wp_postmeta".
 *
 * @property string $meta_id
 * @property string $post_id
 * @property string $meta_key
 * @property string $meta_value
 */
class TmpWpPostmeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wp_postmeta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id'], 'integer'],
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
            'meta_id' => 'Meta ID',
            'post_id' => 'Post ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ];
    }
}
