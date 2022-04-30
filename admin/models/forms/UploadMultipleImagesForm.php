<?php

namespace admin\models\forms;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * UploadMultipleImagesForm model
 *
 * @property UploadedFile $images
 */
class UploadMultipleImagesForm extends Model
{
    use \admin\components\s3\S3MediaTrait;

    public $restaurantImages;
    public $aboutUsImages;
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
            ['restaurantImages', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10],
            ['aboutUsImages', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10],
        ];
    }

    public function upload($model, $modelImageAttribute, $imageAttribute)
    {
        if ($this->validate()) {
            $imagesUrls = [];
            foreach ($this->$imageAttribute as $image) {
                $this->saveUploadedFile($image, '', $this->bucketFolder . $image->baseName);
                $imagesUrls[] = $this->getFileUrl($image->name, $this->bucketFolder);
            }

            $model->$modelImageAttribute = serialize($imagesUrls);

            return true;
        }

        return false;
    }
}