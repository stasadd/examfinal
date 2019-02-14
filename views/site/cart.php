<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Examshop';
?>
<div class="site-index">
    <div class="body-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Корзина</h2>
            </div>
            <div class="panel-body">
                <?php
                if(!Yii::$app->user->isGuest) {
                    foreach ($products as $product) {
                        echo '<div class="row curt-item"><div class="col-lg-1 col-sm-4">';
                        echo '<img src="' . $product->images[0]->url . '" alt="Яблико" title="Яблико" class="curt_img"></div>';
                        echo '<div class="col-lg-6 col-sm-8">';
                        echo '<div class="curt_product_name">' . Html::encode($product->productname) . '</div></div>';
                        echo '<div class="col-lg-2 col-sm-4">';
                        echo '<div class="curt_product_price">' . Html::encode($product->price) . '</div></div>';
                        echo '<div class="col-lg-1 col-sm-4 curt-btns"><a href="congratulation?id='.$product->id.'" class="btn btn-default">Купити</a></div>';
                        echo '<div class="col-lg-2 col-sm-4 curt-btns"><button class="btn btn-danger deleteProdFromCart" prodId="'.Html::encode($product->id).'">Видалити</button></div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
