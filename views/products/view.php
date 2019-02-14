<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'productname',
            'price',
            'oldprice',
            'created_at',
            'updated_at',

        ],
    ]) ?>

    <?php
    echo '<div class="row">';
    foreach ($model->descriptions as $item) {
        echo '<div class="col-sm-12">';
        echo HTML::a('<span class="glyphicon glyphicon-remove"></span>', ['products/delete-description?id=' . $item->id]);
        echo '<span> - ' . $item->key . ' ' . $item->value . '</span>';
        echo '</div>';
    }
    echo '</div>';
    ?>
</div>
