<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_file".
 *
 * @property int $id
 * @property int|null $post_id
 * @property string $filename
 * @property string|null $mime_type
 *
 * @property Post $post
 */
class File extends \yii\db\ActiveRecord
{

    const FILESIZE_LIMIT = 1.5 * 1024 ** 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_file';
    }

    public function __toString()
    {
        return $this->filename;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id'], 'integer'],
            [['filename'], 'required'],
            [['filename', 'mime_type'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'filename' => 'Filename',
            'mime_type' => 'Mime Type',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }
}
