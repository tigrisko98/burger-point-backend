<?php

namespace admin\models\forms;

use common\models\Category;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * UploadAvatarForm model
 *
 * @property UploadedFile $avatar
 */
class UploadImageForm extends Model
{
    use \admin\components\s3\S3MediaTrait;

    public $image;
    public $s3;
    public $categoriesImagesFolder;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->s3 = Yii::$app->get('s3');
        $this->categoriesImagesFolder = Yii::getAlias('@categoriesImagesFolder') . '/';
    }

    public function rules()
    {
        return [
            ['image', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload(Category $category)
    {
        if ($this->validate()) {
            $this->saveUploadedFile($this->image, '', $this->categoriesImagesFolder . $this->image->baseName);

            $category->image = $this->image->baseName . '.' . $this->image->extension;
            $category->image_url = $this->getFileUrl($this->image->name, $this->categoriesImagesFolder);
            $category->update();

            return true;
        }

        return false;
    }
}