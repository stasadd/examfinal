<?php

/* @var $this yii\web\View */

$this->title = 'Examshop';
?>
<div class="site-index">
    <div class="body-content">
<!--        <a href="#" class="forAjax">AJAX</a>-->
        <div class="container-fluid container-with-menu">
            <div class="row">
                <div class="col-sm-2 clear-padding">
                    <ul class="menu_list">
                        <?php
                        foreach ($dataProvider->models as $category) {
                            echo '<li class="menu_item"><a href="'.'/categories/category?id='.$category->id.'"><span class="glyphicon glyphicon-chevron-right"></span> '.$category->category.'</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-sm-10 clear-padding">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="5"></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="images/slider/1.JPG" alt="" class="img-center">
                            </div>
                            <div class="item">
                                <img src="images/slider/2.JPG" alt="" class="img-center">
                            </div>
                            <div class="item">
                                <img src="images/slider/3.JPG" alt="" class="img-center">
                            </div>
                            <div class="item">
                                <img src="images/slider/4.JPG" alt="" class="img-center">
                            </div>
                            <div class="item">
                                <img src="images/slider/5.JPG" alt="" class="img-center">
                            </div>
                            <div class="item">
                                <img src="images/slider/6.JPG" alt="" class="img-center">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-1 col-sm-0"></div>
                <div class="col-md-11 col-sm-12">
                    <h2 class="center">Лідери обговорення</h2>
                    <div class="row">
                        <?php
                        if(isset($products)) {
                            foreach ($products as $product) {
                                echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 center marginv-10px">';
                                if (empty($product->images))
                                    echo '<a href="/products/prod?id=' . $product->id . '"><img class="img-responsive cat-img" src="../images/tabs/No-image-found.jpg" alt=""></a>';
                                else
                                    echo '<a href="/products/prod?id=' . $product->id . '"><img class="img-responsive cat-img" src="' . $product->images[0]->url . '" alt=""></a>';
                                echo '<div class="rating">';
                                echo '<a href="/products/prod?id=' . $product->id . '"><span class="tab-name">' . ($product->productname) . '</span></a>';
                                echo '<span class="badge">відгуків: ' . count($product->reviews) . '</span>';
                                echo '<br>';
                                echo '<button class="btn btn-default btn-xs cat-cart prodCart" prodId="' . ($product->id) . '"><span class="glyphicon glyphicon-shopping-cart"></span></button>';
                                echo '</div>';
                                echo '<div>';
                                echo '<span>' . ($product->price) . '</span><br>';
                                echo '<a href="site/congratulation?id='.$product->id.'" class="btn btn-danger">Купити</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <h2 class="center">Нові товари</h2>
                    <div class="row">
                        <?php
                        if(isset($newproducts)) {
                            foreach ($newproducts as $product) {
                                echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 center marginv-10px">';
                                if (empty($product->images))
                                    echo '<a href="/products/prod?id=' . $product->id . '"><img class="img-responsive cat-img" src="../images/tabs/No-image-found.jpg" alt=""></a>';
                                else
                                    echo '<a href="/products/prod?id=' . $product->id . '"><img class="img-responsive cat-img" src="' . $product->images[0]->url . '" alt=""></a>';
                                echo '<div class="rating">';
                                echo '<a href="/products/prod?id=' . $product->id . '"><span class="tab-name">' . ($product->productname) . '</span></a>';
                                echo '<span class="badge">відгуків: ' . count($product->reviews) . '</span>';
                                echo '<br>';
                                echo '<button class="btn btn-default btn-xs cat-cart prodCart" prodId="' . ($product->id) . '"><span class="glyphicon glyphicon-shopping-cart"></span></button>';
                                echo '</div>';
                                echo '<div>';
                                echo '<span>' . ($product->price) . '</span><br>';
                                echo '<a href="site/congratulation?id='.$product->id.'" class="btn btn-danger">Купити</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
