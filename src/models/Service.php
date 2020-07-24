<?php


namespace afashio\services\models;


use afashio\language\models\Language;
use afashio\pushHelpers\traits\BasicStatusTrait;
use afashio\pushHelpers\traits\ModelTranslationTrait;
use creocoder\translateable\TranslateableBehavior;
use notgosu\yii2\modules\metaTag\components\MetaTagBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use rico\yii2images\behaviors\ImageBehave;

/**
 * Class Service
 *
 * @package afashio\services\models
 *
 * @property int                                    $id
 * @property int                                    $status
 * @property string                                 $slug
 * @property string                                 $title
 * @mixin TranslateableBehavior
 * @mixin MetaTagBehavior
 * @mixin \rico\yii2images\behaviors\ImageBehave
 * @mixin \afashio\services\models\ServiceLang
 * @property-read string                            $url
 * @property \afashio\services\models\ServiceLang[] $translations
 * @property int                                    $sort [int(11)]
 */
class Service extends ActiveRecord
{
    public $image;

    use BasicStatusTrait;
    use ModelTranslationTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'service';
    }

    /**
     * {@inheritDoc}
     */
    public function behaviors(): array
    {
        $behaviors = [

            'translateable' => [
                'class'                        => TranslateableBehavior::class,
                'translationAttributes'        => ['title', 'text'],
                'translationLanguageAttribute' => 'language',
            ],
            'seo'           => [
                'class'     => MetaTagBehavior::class,
                'languages' => Language::languageNameArray(),
            ],
            'image' => [
                'class' => ImageBehave::class,
            ],

        ];

        return array_merge(parent::behaviors(), $behaviors);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status', 'sort'], 'integer'],
            [['slug'], 'string', 'max' => 250],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id'      => Yii::t('app', 'ID'),
            'status'  => Yii::t('app', 'Статус'),
            'slug'    => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Название'),
            'sort' => Yii::t('app', 'Сортировка'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ServiceLang::class, ['service_id' => 'id']);
    }

    public function getUrl()
    {
        return Url::to(['service/view', 'slug' => $this->slug]);
    }

    /**
     * @param $slug
     *
     * @return self|null
     */
    public static function findBySlug($slug): ?self
    {
        return self::findOne(['slug' => $slug, 'status' => self::getActiveStatus()]);
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->translate()->title;
    }

    /**
     * @return self[]
     */
    public static function getAllActive():array
    {
        return self::find()->where(['status' => self::getActiveStatus()])->orderBy(['sort' => SORT_ASC])->all();
    }
}