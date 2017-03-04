<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegForm */
/* @var $form ActiveForm */
?>
<div class="main-reg">
    <div class="flash-error">
        <?php echo Yii::$app->session->getFlash('error'); ?>
    </div>
    <?php

        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";

    ?>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'mail') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- main-reg -->
