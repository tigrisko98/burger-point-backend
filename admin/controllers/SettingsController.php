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
        $model = Settings::find()->one();

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
        $model = Settings::find()->one();
        $modelUpload = new UploadImagesForm($this->restaurantImagesFolder);

        if ($this->request->isPost) {
            $modelUpload->images = UploadedFile::getInstances($modelUpload, 'images');
            $model->restaurant_images_links = serialize($modelUpload->upload());
            $model->save();
            return $this->refresh();
        }

        return $this->render('restaurantImages', [
            'model' => $model,
            'modelUpload' => $modelUpload,
            'restaurantImagesLinksArray' => unserialize($model->restaurant_images_links),
        ]);
    }

    public function actionAboutUsImages()
    {
        $model = Settings::find()->one();
        $modelUpload = new UploadImagesForm($this->aboutUsImagesFolder);

        if ($this->request->isPost) {
            $modelUpload->images = UploadedFile::getInstances($modelUpload, 'images');
            $model->about_us_images_links = serialize($modelUpload->upload());
            $model->save();
            return $this->refresh();
        }

        return $this->render('aboutUsImages', [
            'model' => $model,
            'modelUpload' => $modelUpload,
            'aboutUsImagesLinksArray' => unserialize($model->about_us_images_links),
        ]);
    }

    /**
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
