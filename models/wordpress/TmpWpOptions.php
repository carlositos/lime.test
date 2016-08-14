<?php

namespace app\models\wordpress;

use Yii;

/**
 * This is the model class for table "wp_options".
 *
 * @property string $option_id
 * @property string $option_name
 * @property string $option_value
 * @property string $autoload
 */
class TmpWpOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wp_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_value'], 'required'],
            [['option_value'], 'string'],
            [['option_name'], 'string', 'max' => 64],
            [['autoload'], 'string', 'max' => 20],
            [['option_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => 'Option ID',
            'option_name' => 'Option Name',
            'option_value' => 'Option Value',
            'autoload' => 'Autoload',
        ];
    }
}
