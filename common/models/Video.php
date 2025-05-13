<?php

namespace common\models;

use Imagine\Gd\Image;
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
    //**
    // @var \yii\web\UploadedFile */
    public $thumbnail;


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
                'createdAtAttribute' => 'created_at',
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
            [['thumbnail'], 'image', 'minWidth' => 1280],
            [
                ['video'],
                'file',
                'extensions' => 'mp4',
                'skipOnEmpty' => false,
                'maxSize' => 2147483648, // 2GB
                'tooBig' => 'The file is too large. Maximum allowed size is 2GB.',
                'message' => 'Please upload a video file (mp4). If you selected a file and see this error, it may be too large for the server to handle.',
                'on' => 'insert'
            ],
            [
                ['video'],
                'file',
                'extensions' => 'mp4',
                'skipOnEmpty' => true,
                'maxSize' => 2147483648, // 2GB
                'tooBig' => 'The file is too large. Maximum allowed size is 2GB.',
                'message' => 'Please upload a video file (mp4). If you selected a file and see this error, it may be too large for the server to handle.',
                'on' => 'update'
            ],
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
            'thumbnail' => 'Thumbnail',
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
     * Gets query for [[Views]].
     *
     * @return \yii\db\ActiveQuery|VideoViewQuery
     */
    public function getViews()
    {
        return $this->hasMany(VideoView::class, ['video_id' => 'video_id']);
    }

    public function getLikes()
    {
        return $this->hasMany(\common\models\VideoLike::class, ['video_id' => 'video_id'])
            ->andWhere(['type' => 1]);
    }

    public function getDislikes()
    {
        return $this->hasMany(\common\models\VideoLike::class, ['video_id' => 'video_id'])
            ->andWhere(['type' => 0]);
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
            if ($this->thumbnail !== null) {
                $this->has_thumbnail = 1;
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
        if ($this->thumbnail !== null) {
            $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbs/') . $this->video_id . '.png';
            if (!is_dir(dirname($thumbnailPath))) {
                FileHelper::createDirectory(dirname($thumbnailPath));
            }
            $this->thumbnail->saveAs($thumbnailPath);
            $this->has_thumbnail = 1;
            parent::save(false, ['has_thumbnail']);
            $this->thumbnail->saveAs($thumbnailPath);
            // resize with yii2 imagine
            \yii\imagine\Image::getImagine()->open($thumbnailPath)->thumbnail(new \Imagine\Image\Box(1280, 1280))->save($thumbnailPath);
        } else {
            // Auto-generate thumbnail from video if not provided
            $videoPath = Yii::getAlias('@frontend/web/storage/videos/') . $this->video_id . '.mp4';
            $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbs/') . $this->video_id . '.png';
            if (file_exists($videoPath) && !file_exists($thumbnailPath)) {
                if ($this->generateThumbnailFromVideo($videoPath, $thumbnailPath)) {
                    $this->has_thumbnail = 1;
                    parent::save(false, ['has_thumbnail']);
                }
            }
        }
        return true;
    }

    /**
     * Generates a thumbnail from the video file using ffmpeg.
     * @param string $videoPath
     * @param string $thumbnailPath
     * @return bool
     */
    public function generateThumbnailFromVideo($videoPath, $thumbnailPath)
    {
        $ffmpeg = realpath(Yii::getAlias('@app/../bin/ffmpeg.exe'));
        if (!$ffmpeg || !file_exists($ffmpeg)) {
            return false;
        }
        if (!is_dir(dirname($thumbnailPath))) {
            FileHelper::createDirectory(dirname($thumbnailPath));
        }
        // Extract a frame at 2 seconds as the thumbnail, best quality, HD size
        $cmd = "\"{$ffmpeg}\" -ss 00:00:02 -i \"{$videoPath}\" -frames:v 1 -vf \"scale=1280:-1\" -q:v 1 \"{$thumbnailPath}\"";
        exec($cmd, $output, $returnVar);
        return file_exists($thumbnailPath) && $returnVar === 0;
    }
    public function getVideoLink(){
        return Yii::$app->params['frontendUrl'].'/storage/videos/'.$this->video_id .'.mp4';
    }
    public function getThumbnailLink(){
        return $this->has_thumbnail ? Yii::$app->params['frontendUrl'].'/storage/thumbs/'.$this->video_id .'.png' : '';
    }

    public function getStatusLabel()
    {
        $map = [
            self::STATUS_UNLISTED => 'Unlisted',
            self::STATUS_PUBLISHED => 'Published',
        ];
        return $map[$this->status] ?? 'Unknown';
    }

    public function beforeDelete()
    {
        $videoPath = Yii::getAlias('@frontend/web/storage/videos/') . $this->video_id . '.mp4';
        $thumbPath = Yii::getAlias('@frontend/web/storage/thumbs/') . $this->video_id . '.png';
        if (file_exists($videoPath)) {
            @unlink($videoPath);
        }
        if ($this->has_thumbnail && file_exists($thumbPath)) {
            @unlink($thumbPath);
        }
        return parent::beforeDelete();
    }
}
