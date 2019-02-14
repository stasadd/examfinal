<?php
/**
 * Created by PhpStorm.
 * User: td779
 * Date: 14.02.2019
 * Time: 10:19
 */

namespace app\models;

use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $fullPath;


    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload($prod_id='') {
        if($this->validate()) {
            $directory = 'images/products/'.$prod_id.'_'.date("j_m_y");
            FileHelper::createDirectory($directory);
            $this->fullPath = $directory.'/'. $this->imageFile->baseName.'.'.$this->imageFile->extension;
            $this->imageFile->saveAs($this->fullPath);
            return true;
        } else
            return false;
    }

}