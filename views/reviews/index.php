<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reviews';
?>
<div class="reviews-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'name',
            'text',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?= HTML::a('Повернутися до редагування товару', ['products/update?id=' . $product_id]) ?>
</div>
