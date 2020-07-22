<?php

namespace afashio\services\frontend\controllers;

use afashio\services\models\Service;
use afashio\services\search\ServiceSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class ServiceController
 *
 * @package afashio\services\frontend\controllers
 */
class ServiceController extends \yii\web\Controller
{

    /**
     * @return mixed|string
     */
    public function getViewPath()
    {
        return \Yii::getAlias('@frontend/views/service');
    }

    /**
     * @return string|void
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        $articleSearch = new ServiceSearch();
        $dataProvider = $articleSearch->search(Yii::$app->request->queryParams);
        if ($dataProvider) {
            return $this->render(
                'index',
                [
                    'dataProvider' => $dataProvider,
                ]

            );
        }
        $this->notFoundPage();
    }

    /**
     * @throws \yii\web\NotFoundHttpException
     */
    private function notFoundPage(): void
    {
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @param $slug
     *
     * @return string
     */
    public function actionView($slug)
    {
        $article = $this->findModel($slug);

        return $this->render('view', compact('article'));
    }

    /**
     * @param $slug
     *
     * @return \afashio\services\models\Service|void
     * @throws \yii\web\NotFoundHttpException
     */
    private function findModel($slug)
    {
        $model = Service::findBySlug($slug);
        if ($model) {
            return $model;
        }

        $this->notFoundPage();
    }


}
