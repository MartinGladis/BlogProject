<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property string $birthdate
 * @property string|null $street_name
 * @property string|null $number
 * @property string|null $postcode
 * @property string $email
 * @property string|null $pesel
 * @property string $registered_at
 * @property string|null $last_login
 *
 * @property Post[] $posts
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'name', 'surname', 'birthdate', 'email'], 'required'],
            [['birthdate', 'registered_at', 'last_login'], 'safe'],
            [['username', 'name', 'surname', 'street_name', 'email'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 10],
            [['postcode'], 'string', 'max' => 6],
            [['pesel'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'surname' => 'Surname',
            'birthdate' => 'Birthdate',
            'street_name' => 'Street Name',
            'number' => 'Number',
            'postcode' => 'Postcode',
            'email' => 'Email',
            'pesel' => 'Pesel',
            'registered_at' => 'Registered At',
            'last_login' => 'Last Login',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['user_id' => 'id']);
    }
}
