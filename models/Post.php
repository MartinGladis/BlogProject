<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_post".
 *
 * @property int $id
 * @property string $topic
 * @property string $description
 * @property int|null $user_id
 * @property string|null $attachment
 * @property string $create_at
 * @property string|null $update_at
 *
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
{

    public $attachmentFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic', 'description'], 'required'],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['topic'], 'string', 'max' => 255],
            ['attachmentFiles', 'file', 'maxFiles' => 10],
            ['attachmentFiles', 'validateFilesize'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic' => 'Topic',
            'description' => 'Description',
            'user_id' => 'User ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'attachmentFiles' => 'Attachments',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getFiles()
    {
        return $this->hasMany(File::class, ['post_id' => 'id']);
    }

    public function validateFilesize($attribite)
    {
        foreach ($this->attachmentFiles as $attachmentFile) {
            $filesize = filesize($attachmentFile->tempName);
            if ($filesize > File::FILESIZE_LIMIT) {
                $this->addError($attribite, 'File "' . $attachmentFile->name . '" is greater than 1,5MB');
                return;
            }
        }
    }

    public function beforeSave($insert)
    {
        if (yii::$app->user->id) {
            $this->user_id = yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }
}
