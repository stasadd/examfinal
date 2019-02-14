<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */

$this->title = $model->category;
//$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="categories-view">
    <div class="container">
        <h2 class="center"><?= Html::encode($this->title) ?></h2>
        <div class="row">
            <?php
            foreach ($model->products as $product) {
                echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 center marginv-10px">';
                if(empty($product->images))
                    echo '<a href="/products/prod?id='.$product->id.'"><img class="img-responsive cat-img" src="../images/tabs/No-image-found.jpg" alt=""></a>';
                else
                    echo '<a href="/products/prod?id='.$product->id.'"><img class="img-responsive cat-img" src="'.$product->images[0]->url.'" alt=""></a>';
                echo '<div class="rating">';
                echo '<a href="/products/prod?id='.$product->id.'"><span class="tab-name">'.Html::encode($product->productname).'</span></a>';
                echo '<span class="badge">відгуків: '.count($product->reviews).'</span>';
                echo '<br>';
                echo '<button class="btn btn-default btn-xs cat-cart prodCart" prodId="'.Html::encode($product->id).'"><span class="glyphicon glyphicon-shopping-cart"></span></button>';
                echo '</div>';
                echo '<div>';
                echo '<span>'.Html::encode($product->price).'</span><br>';
                echo '<a href="../site/congratulation?id='.$product->id.'" class="btn btn-danger">Купити</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>

<!--        <nav aria-label="Page navigation" class="center">-->
<!--            <ul class="pagination">-->
<!--                <li>-->
<!--                    <a href="#" aria-label="Previous">-->
<!--                        <span aria-hidden="true">&laquo;</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li><a href="#">1</a></li>-->
<!--                <li><a href="#">2</a></li>-->
<!--                <li><a href="#">3</a></li>-->
<!--                <li><a href="#">4</a></li>-->
<!--                <li><a href="#">5</a></li>-->
<!--                <li>-->
<!--                    <a href="#" aria-label="Next">-->
<!--                        <span aria-hidden="true">&raquo;</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </nav>-->

    </div>
</div>
