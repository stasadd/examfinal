<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\data\ActiveDataProvider;
use app\models\Categories;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => "Examshop", //Yii::$app->name
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    //отримання категорій та їх id для вивода в меню
    $dataProvider = new ActiveDataProvider([
        'query' => Categories::find(),
    ]);
    $categories = [];
    $index = 0;
    foreach ($dataProvider->models as $category) {
        $categories[$index]['label'] = $category->category;
        $categories[$index]['url'] = ['/categories/category?id='.$category->id];
        $index++;
    }

    $items = [
        [
            'label' => 'Категорії',
            'items' => $categories
        ],
        Yii::$app->user->isGuest ? (
        ['label' => 'Зареєструватися', 'url' => ['/site/sign-up']]
        ) : "",
        Yii::$app->user->isGuest ? (
        ['label' => 'Увійти', 'url' => ['/site/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Вийти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        ),
        ['label' => '', 'url' => ['/site/cart'],'options'=>['class'=>'cart']]
    ];

    $adminItems = [
        ['label' => 'Products', 'url' => ['/products']],
        ['label' => 'Categories', 'url' => ['/categories']],
        ['label' => 'Customers', 'url' => ['/customers']],
    ];

    if(Yii::$app->user->identity->status == 10) {
        array_push($items, ['label' => 'Admin', 'items' => $adminItems]);
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
