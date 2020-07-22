<?php


/* @var $this yii\web\View */

/* @var $model \afashio\services\models\Service */

$this->title = Yii::t('app', 'Создать страниуцу услуги');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Услуги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render(
        '_form',
        [
            'model' => $model,
        ]
    ) ?>

</div>
