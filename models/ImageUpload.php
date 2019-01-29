<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
class ImageUpload extends Model
{
    public $image;

    public function uploadFile(UploadedFile $file, $currentImage)
    {
        $this->image = $file;
        if ($this->validate()) {
            $this->deleteCurrentImage($currentImage);
            return $this->saveImage();
        }

    }

    public function getFolder()
    {
        return Yii::getAlias('@web') . 'uploads/';
    }

    public function generationFilename()
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    public function deleteCurrentImage($currentImage)
    {
        if ($this->fileExists($currentImage)) {
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function fileExists($currentImage)
    {
        if (!empty($currentImage) && $currentImage !== NULL) {
            return file_exists($this->getFolder().$currentImage);
        }
    }

    public function saveImage(){
        $filename=$this->generationFilename();
        $this->image->saveAs($this->getFolder().$filename);
        return $filename;
    }

    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,png']
        ];
    }




}

