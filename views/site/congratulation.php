<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Examshop';
?>
<div class="site-index">
    <div class="body-content">
        <h1 class="text-center">Прийміть наші вітання, ви придбали хороший товар</h1>
        <h3 class="text-center"> <?php
            if(isset($product))
                echo $product[0]->productname;
            ?></h3>
    </div>
</div>
