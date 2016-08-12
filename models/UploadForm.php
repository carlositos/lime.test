<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $sqlFiles;

    public function rules()
    {
        return [
            [['sqlFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => ['sql'], 'maxFiles' => 10, 'checkExtensionByMimeType' => false],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) { 
            foreach ($this->sqlFiles as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
				$source = new Sources();
				$source->filename = $file->baseName;
				$source->save();
            }
            return true;
        } else {
            return false;
        }
    }
}
