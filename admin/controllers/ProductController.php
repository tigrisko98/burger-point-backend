<?php

namespace admin\controllers;

use admin\models\forms\UploadImagesForm;
use common\models\Category;
use Yii;
use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    private $categoriesTitles;
    private $productsImagesFolder;

    public function __construct($id, $module, $config = [])
    {
        $this->productsImagesFolder = Yii::getAlias('@productsImagesFolder');
        $this->categoriesTitles = ArrayHelper::map(Category::find()->select(['id', 'title'])->asArray()->all(), 'id', 'title');
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
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        $modelUpload = new UploadImagesForm($this->productsImagesFolder);
        $formData = $this->request->post();

        if ($this->request->isPost) {
            if ($model->load($formData['Product'], '')) {
                if ($modelUpload->image = UploadedFile::getInstance($modelUpload, 'image')) {
                    $model->image = $modelUpload['image'];
                    $model->image_url = $modelUpload->upload()['image_url'];
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'modelUpload' => $modelUpload,
            'categoriesTitles' => $this->categoriesTitles
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUpload = new UploadImagesForm($this->productsImagesFolder);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($modelUpload->image = UploadedFile::getInstance($modelUpload, 'image')) {
                $modelUpload->oldImage = $model->image;
                $modelUpload->delete();
                $imageToUpload = $modelUpload->upload();
                $model->image = $imageToUpload['image'];
                $model->image_url = $imageToUpload['image_url'];
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelUpload' => $modelUpload,
            'categoriesTitles' => $this->categoriesTitles
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            if (!empty($model->image)) {
                $modelUpload = new UploadImagesForm($this->productsImagesFolder);
                $modelUpload->oldImage = $model->image;
                $modelUpload->delete();
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
