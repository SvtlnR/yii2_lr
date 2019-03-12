<?php
use yii\Helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="article=form">
    <?php $form=ActiveForm::begin()?>
    <?=Html::dropDownList('users',$selectedGroup,[user,admin],['class'=>'form-control'])?>
    <div class="form-group">
        <?=Html::submitButton('Submit',['class'=>'btn btn-success'])?>
    </div>
    <?php ActiveForm::end();?>
</div>
