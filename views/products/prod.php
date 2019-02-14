<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->productname;
//$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="products-view">

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2><?= Html::encode($model->productname); ?></h2>
                <p><span class="label label-danger">Код товару: <?= Html::encode($model->id); ?></span></p>
                <div class="container-fluid marginv-10px padding-5px">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                    if (empty($model->images)) {
                                        echo '<div class="item active prod-img"><img class="prod-img-inner" src="../images/tabs/No-image-found.jpg" alt=""></div>';
                                    } else {
                                        $flag = true;
                                        foreach ($model->images as $image) {
                                            if ($flag) {
                                                echo '<div class="item active prod-img"><img class="prod-img-inner" src="' . $image->url . '" alt=""></div>';
                                                $flag = false;
                                            } else
                                                echo '<div class="item prod-img"><img class="prod-img-inner" src="' . $image->url . '" alt=""></div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <a class="left carousel-control" href="#carousel-example-generic" role="button"
                                   data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left red" aria-hidden="true"</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" role="button"
                                   data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right red" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <span class="prod-pr">ціна:</span><br>
                                            <span class="prod-mn"><?= Html::encode($model->price); ?></span>
                                        </div>
                                        <div class="col-xs-6">
                                            <button class="btn btn-default btn-lg img-center btn-100px prodCart"
                                                    prodId="<?= Html::encode($model->id); ?>"><span
                                                        class="glyphicon glyphicon-shopping-cart"></span></button>
                                            <a href="../site/congratulation?id=<?= Html::encode($model->id); ?>" class="btn btn-danger btn-lg img-center btn-100px">Купити</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-0">
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#characteristics" data-toggle="tab">Характеристики</a></li>
                    <li><a href="#reviews" data-toggle="tab">Відгуки</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active fade in" id="characteristics">
                        <h3>Технічні характеристики</h3>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                <?php
                                foreach ($model->descriptions as $description) {
                                    echo '<tr>';
                                    echo '<td>' . Html::encode($description->key) . '</td>';
                                    echo '<td>' . Html::encode($description->value) . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews">
                        <div class="row">
                            <div class="col-sm-12 review-container">
                                <?php
                                if (empty($model->reviews))
                                    echo '<h3>Залиште перший відгук</h3>';
                                else {
                                    foreach ($model->reviews as $review) {
                                        echo '<div class="panel panel-success">';
                                        echo '<div class="panel-heading">' . Html::encode($review->name) . '</div>';
                                        echo '<div class="panel-body"><p>' . Html::encode($review->text) . '</p></div>';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="post">
                                    <div class="form-group">
                                        <label for="username">Ваше ім'я</label>
                                        <input type="text" class="form-control" name="username" id="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="userreview">Ваш відгук</label>
                                        <textarea class="form-control" rows="3" id="userreview"
                                                  name="userreview"></textarea>
                                        <input type="hidden" name="id" value="<?= $model->id; ?>">
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-success send-review">Залишити відгук</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
