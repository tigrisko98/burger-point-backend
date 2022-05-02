<?php

namespace admin\models\forms;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * UploadImagesForm model
 *
 * @property UploadedFile $images
 */
class UploadImagesForm extends Model
{
    use \admin\components\s3\S3MediaTrait;

    public $image;
    public $oldImage;
    public $images;
    public $oldImages;
    public $s3;
    public $bucketFolder;

    public function __construct($bucketFolder, $config = [])
    {
        parent::__construct($config);
        $this->s3 = Yii::$app->get('s3');
        $this->bucketFolder = $bucketFolder . '/';
    }

    public function rules()
    {
        return [
            ['image', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            ['images', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10],
        ];
    }

    public function upload(): array|string|bool
    {
        if ($this->validate()) {
            if (!is_null($this->images)) {
                $images = [];

                foreach ($this->images as $image) {
                    $this->saveUploadedFile($image, '', $this->bucketFolder . $image->baseName);
                    $images['images'][] = $image->name;
                    $images['images_urls'][] = $this->getFileUrl($image->name, $this->bucketFolder);
                }
                return $images;
            } else {
                $this->saveUploadedFile($this->image, '', $this->bucketFolder . $this->image->baseName);
                return [
                    'image' => $this->image->baseName,
                    'image_url' => $this->getFileUrl($this->image->name, $this->bucketFolder)
                ];
            }
        }
        return false;
    }

    public function delete()
    {
        if (!is_null($this->images)) {
            foreach ($this->oldImages as $image){
                $this->removeFile('', $this->bucketFolder . $image);
            }
            return true;
        }
        return $this->removeFile('', $this->bucketFolder . $this->oldImage);
    }
}