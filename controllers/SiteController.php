<?php

namespace app\controllers;

use app\models\Categories;
use app\models\CustomerProduct;
use app\models\Products;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Customers;
use app\models\CustomersTemp;
use app\models\SignupForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Categories::find(),
        ]);

        $popularIds = Yii::$app->db->createCommand(
            'SELECT `products`.`id`, COUNT(`reviews`.`id`) as `countrev`
                FROM `products` INNER JOIN `reviews`
                on `products`.`id` = `reviews`.`product_id`
                GROUP by `products`.`id`
                ORDER BY `countrev` DESC
                LIMIT 0, 8')->queryAll();

        $productsAll = null;
        foreach ($popularIds as $item) {
            $productsAll[] = Products::findOne($item['id']);
        }

        $query = Products::find();
        $newProducts = $query->orderBy('updated_at DESC')->offset(0)->limit(8)->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'products' => $productsAll,
            'newproducts' => $newProducts
        ]);

    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionCart()
    {
        $products = null;

        $user = Customers::find()->where(["id"=>Yii::$app->user->id])->one();
        $products = $user->products;

        return $this->render('cart', [
            'products' => $products
        ]);
    }

    public function actionCongratulation($id='')
    {
        if(!empty($id)) {
            $product = Products::findAll(['id' => $id]);

            $toDel = CustomerProduct::findAll(['customer_id' => Yii::$app->user->id, 'product_id' => $id]);

            foreach ($toDel as $value) {
                $value->delete();
            }

            return $this->render('congratulation', [
                'product' => $product
            ]);
        }

        return $this->goHome();
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin($name="")
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (!empty($name)) {
            $name = trim($name,"'");
            $userTmp = CustomersTemp::findByUsername($name);
            $drop = null;
            if(!is_null($userTmp))
                $drop = CustomersTemp::findOne($userTmp->getId());
            $user = Customers::findByUsername($name);
            if ($userTmp === null) {
                $this->goHome();
                Yii::$app->session->setFlash('error', 'This customer not exist');

            }else if ($user === null) {
                $user = new Customers();
                $user->setAttributes([
                    'username' => $userTmp->username,
                    'auth_key' => $userTmp->auth_key,
                    'password_hash' => $userTmp->password_hash,
                    'password_reset_token' => $userTmp->password_reset_token,
                    'email' => $userTmp->email,
                    'status' => $userTmp->status,
                    'AccessToken' => $userTmp->AccessToken,
                    'created_at' => $userTmp->created_at,
                    'updated_at' => $userTmp->updated_at
                ]);
                $user->save();
                try {
                    $drop->delete();
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('error', 'it\'s not work !!!');
                }
            }
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'name' =>$name
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout($id='')
    {
        return $this->render('about');
    }

    public function actionSignUp()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signUp()) {


            Yii::$app->session->setFlash('success', 'Ty for registration check you\'r email for instruction.' . $model->email);

            Yii::$app->mailer->compose('mail',['user'=>$model->username])
                ->setFrom('stas.add@gmail.com')
                ->setTo($model->email)
                ->setSubject('Examshop . Confirm you\'r registration')
                ->setTextBody('Hello !! Welcome to  Examshop .\t Confirm you\'r registration')
//                ->setHtmlBody($this->render())
                ->send();
            return $this->goBack();
        } elseif ($model->load(Yii::$app->request->post()))
            Yii::$app->session->setFlash('Error', 'Smth go wrong , try again later.');


        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionAjax()
    {
        return "answer ".Yii::$app->request->post()['id'];
    }
}
