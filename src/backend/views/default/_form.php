<?php

use afashio\language\models\Language;
use afashio\pushHelpers\helpers\FormHelper;
use afashio\services\models\Service;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \afashio\services\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active">
                <a data-toggle="tab" href="#common" href="#">
                    <?= Yii::t('app', 'common'); ?>
                </a>
            </li>
            <li role="presentation">
                <a data-toggle="tab" href="#image" href="#">
                    <?= Yii::t('app', 'Изображения'); ?>
                </a>
            </li>
            <? foreach (Language::languageList() as $language): ?>
                <li role="presentation"><a data-toggle="tab" href="#<?= $language->slug; ?>"><?= $language->name; ?></a>
                </li>
            <? endforeach; ?>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="common">
                <div class="box-body">
                    <?= $form->field($model, 'slug')->textInput(
                        ['maxlength' => true, 'readonly' => isset($model->id)]
                    ) ?>
                    <?= $form->field($model, 'sort')->textInput(['value' => $model->sort ?? 500]) ?>

                    <?= $form->field($model, 'status')->dropDownList(Service::status_list()) ?>

                </div>
            </div>

            <? foreach (Language::languageList() as $language): ?>
                <div role="tabpanel" class="tab-pane" id="<?= $language->slug; ?>">
                    <div class="box-body">
                        <?= $form->field($model->translate($language->slug), "[$language->slug]title")->textInput(); ?>

                        <?= $form->field($model->translate($language->slug), "[$language->slug]text")->widget(
                            FormHelper::textEditorWidgetClass(),
                            FormHelper::textEditorConfig()
                        ) ?>

                        <?= \notgosu\yii2\modules\metaTag\widgets\metaTagForm\Widget::widget(
                            ['model' => $model, 'language' => $language->slug]
                        ); ?>
                    </div>
                </div>
            <? endforeach; ?>
            <div role="tabpanel" class="tab-pane" id="image">
                <div class="box-body">
                    <?= $form->field($model, 'image')->widget(
                        \kartik\file\FileInput::class,
                        [
                            'options' => [
                                'accept' => 'image/*',
                                'multiple' => true,
                            ],
                            'pluginOptions' => [
                                'initialPreview' =>
                                    \afashio\pushHelpers\utils\ImageUtil::getImageUrls($model)
                                ,
                                'initialPreviewConfig' =>
                                    \afashio\pushHelpers\utils\PreviewUtil::getPreviewOptions(
                                        \yii\helpers\Url::to(['site/delete-image']),
                                        $model->getImages()
                                    ),
                                'initialPreviewAsData' => true,
                                'overwriteInitial' => false,
                            ],
                        ]
                    ); ?>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
