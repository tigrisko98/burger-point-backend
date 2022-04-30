<?php

namespace admin\models\forms;

use common\models\Category;
use common\models\Product;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * UploadImageForm model
 *
 * @property UploadedFile $image
 */
class UploadImageForm extends Model
{
    use \admin\components\s3\S3MediaTrait;

    public $image;
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
            ['image', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload(Product|Category $model)
    {
        if ($this->validate()) {
            $this->saveUploadedFile($this->image, '', $this->bucketFolder . $this->image->baseName);

            $model->image = $this->image->baseName . '.' . $this->image->extension;
            $model->image_url = $this->getFileUrl($this->image->name, $this->bucketFolder);

            return true;
        }

        return false;
    }
}