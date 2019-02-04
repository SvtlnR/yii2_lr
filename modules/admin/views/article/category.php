<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="article-form">

    <?php $form=ActiveForm::begin();?>

    <?=Html::dropDownList('category',$selectedCategory,$categories,['class'=>'form-control']);?>

    <div class="form-group">
        <?=Html::submitButton('Submit',['class'=>'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end();?>

</div>
