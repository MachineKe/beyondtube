<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null $has_thumbnail
 * @property string|null $video_name
 * @property int|null $status
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 */
class Video extends \yii\db\ActiveRecord
{

const STATUS_UNLISTED = 0;
const STATUS_PUBLISHED = 1;


    //**
    // @var \yii\web\UploadedFile */
    public $video;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
                'updatedAtAttribute' => 'updated_at',
            ],
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'tags', 'has_thumbnail', 'video_name', 'status', 'updated_at', 'created_by'], 'default', 'value' => null],
            [['video_id', 'title'], 'required'],
            [['description'], 'string'],
            [['has_thumbnail', 'status', 'updated_at', 'created_by'], 'integer'],
            [['video_id'], 'string', 'max' => 16],
            [['title', 'tags', 'video_name'], 'string', 'max' => 512],
            [['video_id'], 'unique'],
            [['has_thumbnail'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => self::STATUS_UNLISTED],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'has_thumbnail' => 'Has Thumbnail',
            'video_name' => 'Video Name',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VideoQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert = $this->isNewRecord;
        if ($isInsert) {
            $this->video_id = Yii::$app->security->generateRandomString(8);
            if ($this->video !== null) {
                $this->title = $this->video->name;
                $this->video_name = $this->video->name;
            }
        }
        $saved = parent::save($runValidation, $attributeNames);
        if (!$saved) {
            return false;
        }
        if ($isInsert && $this->video !== null) {
            $videoPath = Yii::getAlias('@frontend/web/storage/videos/') . $this->video_id . '.mp4';
            if (!is_dir(dirname($videoPath))) {
                FileHelper::createDirectory(dirname($videoPath));
            }
            $this->video->saveAs($videoPath);
        }
        return true;
    }
    public function getVideoLink(){
        return Yii::$app->params['frontendUrl'].'/storage/videos/'.$this->video_id .'.mp4';
    }

}
