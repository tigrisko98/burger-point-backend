<?php

namespace admin\controllers;

use admin\models\forms\UploadImagesForm;
use Yii;
use common\models\Settings;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
{
    private $aboutUsImagesFolder;
    private $restaurantImagesFolder;

    public function __construct($id, $module, $config = [])
    {
        $this->aboutUsImagesFolder = Yii::getAlias('@aboutUsImagesFolder');
        $this->restaurantImagesFolder = Yii::getAlias('@restaurantImagesFolder');
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['*'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Settings.
     *
     * @return \yii\web\Response|string
     */
    public function actionIndex()
    {
        $model = Settings::findOne(1);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->save();
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionRestaurantImages()
    {
        $model = Settings::findOne(1);
        $modelUpload = new UploadImagesForm($this->restaurantImagesFolder);

        if ($this->request->isPost) {
            if ($modelUpload->images = UploadedFile::getInstances($modelUpload, 'images')) {
                $modelUpload->oldImages = (array) unserialize($model->restaurant_images);
                $modelUpload->delete();
                $imagesToUpload = $modelUpload->upload();
                $model->restaurant_images = serialize($imagesToUpload['images']);
                $model->restaurant_images_links = serialize($imagesToUpload['images_urls']);
                $model->save();
                return $this->refresh();
            }
        }

        return $this->render('restaurantImages', [
            'model' => $model,
            'modelUpload' => $modelUpload,
            'restaurantImagesLinksArray' => unserialize($model->restaurant_images_links),
        ]);
    }

    public function actionAboutUsImages()
    {
        $model = Settings::findOne(1);
        $modelUpload = new UploadImagesForm($this->aboutUsImagesFolder);

        if ($this->request->isPost) {
            if ($modelUpload->images = UploadedFile::getInstances($modelUpload, 'images')) {
                $modelUpload->oldImages = (array) unserialize($model->about_us_images);
                $modelUpload->delete();
                $imagesToUpload = $modelUpload->upload();
                $model->about_us_images = serialize($imagesToUpload['images']);
                $model->about_us_images_links = serialize($imagesToUpload['images_urls']);
                $model->save();
                return $this->refresh();
            }
        }

        return $this->render('aboutUsImages', [
            'model' => $model,
            'modelUpload' => $modelUpload,
            'aboutUsImagesLinksArray' => unserialize($model->about_us_images_links),
        ]);
    }
}
