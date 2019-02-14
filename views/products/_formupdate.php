<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'productname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oldprice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <hr>
    <h3>Редагування опису</h3>
    <?php
    foreach ($model->descriptions as $item) {
        echo '<div class="col-sm-12">';
        echo HTML::a($item->key.' - '.$item->value, ['description/update?id=' . $item->id]);
        echo '</div>';
    }
    ?>
    <hr>
    <br>
    <?= HTML::a('<h3>Добавити елемент опису</h3>', ['description/create?prod_id=' . $model->id]) ?>

    <br>
    <?= HTML::a('<h3>Переглянути відгуки про товар ('.count($model->reviews).')</h3>', ['reviews/index?prod_id=' . $model->id]) ?>

    <br>
    <?= HTML::a('<h3>Завантажити фото ('.count($model->images).')</h3>', ['products/upload?prod_id=' . $model->id]) ?>

</div>
