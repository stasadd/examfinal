<?php

namespace app\controllers;

use app\models\Categories;
use app\models\CustomerProduct;
use app\models\Description;
use app\models\Images;
use app\models\ProductCategory;
use app\models\Reviews;
use app\models\UploadForm;
use PHPUnit\Util\Json;
use Yii;
use app\models\Products;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->status != 10) {
            return $this->goHome();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Products::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->identity->status != 10) {
            return $this->goHome();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->identity->status != 10) {
            return $this->goHome();
        }

        $model = new Products();
        $categories = Categories::find()->all();
        $cat_array = ArrayHelper::map($categories, 'id', 'category');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach (Yii::$app->request->post()['Products']['categories'] as $cat) {
                $prod_cat = new ProductCategory();
                $prod_cat->category_id = $cat;
                $prod_cat->product_id = $model->id;
                $prod_cat->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $cat_array
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->identity->status != 10) {
            return $this->goHome();
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->status != 10) {
            return $this->goHome();
        }

        //todo: delete folder

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param Images[] $images
     */
    private function getDirectoryPath($images) {
        foreach ($images as $img) {
            //todo: pregmatch and return directory
        }
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionProd($id = '')
    {
        return $this->render('prod', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionMakereview()
    {
        $review = new Reviews();
        $review->name = Yii::$app->request->post()['username'];
        $review->text = Yii::$app->request->post()['userreview'];
        $review->product_id = Yii::$app->request->post()['id'];
        $review->save();

        $arr = [
            'name' => $review->name,
            'text' => $review->text
        ];

        return json_encode($arr);
    }

    public function actionPutintocart()
    {
        if (Yii::$app->user->isGuest) {
            return 'error';
        } else {
            $isExist = CustomerProduct::findAll(['customer_id' => Yii::$app->user->id, 'product_id' => Yii::$app->request->post()['id']]);
            if(empty($isExist)) {
                $customerProd = new CustomerProduct();
                $customerProd->customer_id = Yii::$app->user->id;
                $customerProd->product_id = Yii::$app->request->post()['id'];
                $customerProd->save();
                return 'success';
            }
            return 'exist';
        }
        return 'error';
    }

    public function actionDelfromcart()
    {
        if (Yii::$app->user->isGuest) {
            return 'error';
        } else {
            $toDel = CustomerProduct::findAll(['customer_id' => Yii::$app->user->id, 'product_id' => Yii::$app->request->post()['id']]);

            foreach ($toDel as $value) {
                $value->delete();
            }
            return 'success';
        }
        return 'error';

    }

    public function actionDeleteDescription($id)
    {
        if (Description::findOne($id)->delete()) {
            Yii::$app->session->setFlash('success', 'propertie has been delete');
        } else{
            Yii::$app->session->setFlash('error', 'propertie can not be delete');
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

    }


    public function actionUpload($prod_id='') {
        $model = new UploadForm();

        if(Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->upload($prod_id)){
                $image = new Images();
                $image->product_id = $prod_id;
                $image->url = '../'. $model->fullPath;
                $image->save();
                return $this->redirect('update?id='.$prod_id);
            }
        }

        return $this->render('upload', ['model' => $model]);

    }
}
