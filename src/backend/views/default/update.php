<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \afashio\services\models\Service */

$this->title = Yii::t('app', 'Обновить {modelClass}: ', [
    'modelClass' => 'страницу услуги',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Услуги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновить');
?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
