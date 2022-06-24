<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "tbl_user".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property string $birthdate
 * @property string $auth_key
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
class User extends ActiveRecord implements IdentityInterface
{

    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'username', 'password', 'password_repeat', 'birthdate', 'email'], 'required'],
            [['birthdate', 'registered_at', 'last_login'], 'safe'],
            [['username', 'name', 'surname', 'street_name', 'email'], 'string', 'max' => 255],
            [['number'], 'string', 'max' => 10],
            [['postcode'], 'string', 'max' => 6],
            [['pesel'], 'string', 'max' => 11],
            [['username', 'email'], 'trim'],
            [['username', 'email'], 'unique'],
            ['username', 'validateUsername'],
            ['email', 'email'],
            ['birthdate', 'validateDate'],
            ['password', 'validatePassword'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords must be the same'],
            ['postcode', 'validatePostcode'],
            ['pesel', 'validatePesel'],
            ['pesel', 'validatePeselDate']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'username' => 'Username',
            'password' => 'Password',
            'password_repeat' => 'Password Repeat',
            'birthdate' => 'Birthdate',
            'street_name' => 'Street Name',
            'number' => 'Number',
            'postcode' => 'Postcode',
            'email' => 'Email',
            'pesel' => 'PESEL',
            'registered_at' => 'Registered At',
            'last_login' => 'Last Login',
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
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

    public function validateUsername($attribute)
    {
        $username = $this->username;

        $regex = '/\s+/';
        if (preg_match($regex, $username)) {
            $this->addError($attribute, "Username shouldn't have white spaces");
            return;
        }

        $regex = '/[a-zA-z\d]{6,}/';
        if (!preg_match($regex, $username)) {
            $this->addError($attribute, "Username should contain only uppercase and lowercase letters and be at least 6 characters long");
        }
    }

    public function validateDate($attribute)
    {
        $date = $this->birthdate;
        $regex = '/[\d]{2}.[\d]{2}.[\d]{4}/';

        if (!preg_match($regex, $date)) {
            $this->addError($attribute, 'Date should have format "DD.MM.YYYY"');
            return;
        }

        $day = intval(substr($date, 0, 2));
        $month = intval(substr($date, 3, 2));
        $year = intval(substr($date, 6));
        if (!checkdate($month, $day, $year)) {
            $this->addError($attribute, "This date don't exist");
        }
    }

    public function validatePassword($attribute)
    {
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[!+-_@%$#?])(?=.*\d)[a-zA-Z\d!+-_@%$#?]{8,}$/';

        if (!preg_match($regex, $this->password)) {
            $this->addError($attribute, <<<EOD
            The password should be a minimum of 8 characters 
            and must contain at least one upper case letter, one lower case letter, 
            a number and a special character (!+-_@%$#?)
            EOD);
        }
    }

    public function isPasswordCorrect($password)
    {
        return $this->password === md5($password);
    }

    public function validatePostcode($attribute)
    {
        $regex = '/[\d]{2}-[\d]{3}/';
        
        if (!preg_match($regex, $this->postcode)) {
            $this->addError($attribute, 'Postcode shoud have format "dd-ddd"');
        }
    }

    public function validatePesel($attribute)
    {
        $pesel = $this->pesel;
        $regex = '/[\d]{11}/';

        if (!preg_match($regex, $pesel)) {
            $this->addError($attribute, "PESEL must have only digit and have 11 characters");
            return;
        }

        $peselWeight = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $peselDigits = array_map('intval', str_split($pesel));
        $digitsWeight = [];

        for ($i=0; $i < 10; $i++) { 
            $digitsWeight[] = $peselDigits[$i] * $peselWeight[$i];
            $digitsWeight[$i] %= 10;
        }

        $controlNumber = array_sum($digitsWeight);
        $controlNumberLastDigit = $controlNumber % 10;

        $controlDigit = 10 - $controlNumberLastDigit;

        if ($peselDigits[10] != $controlDigit) {
            $this->addError($attribute, 'PESEL is incorrect');
        }
    }

    public function validatePeselDate($attribute)
    {
        $pesel = $this->pesel;
        $date = $this->birthdate;

        $day = intval(substr($date, 0, 2));
        $month = intval(substr($date, 3, 2));
        $year = intval(substr($date, 6));

        $centenary = floor($year / 100);
        $shortYear = $year % 100;

        switch ($centenary) {
            case 18:
                $month += 80;
                break;

            case 20:
                $month += 20;
                break;
            
            case 21:
                $month += 40;
                break;
                
            case 22:
                $month += 60;
                break;
        }


        $peselYear = intval(substr($pesel, 0, 2));
        $peselMonth = intval(substr($pesel, 2, 2));
        $peselDay = intval(substr($pesel, 4, 2));

        $dateCompare = 
            $day === $peselDay && 
            $month === $peselMonth && 
            $shortYear === $peselYear;

        if (!$dateCompare) {
            $this->addError($attribute, "PESEL doesn't match the birthdate.");
        }

    }

    public function beforeSave($insert)
    {

        if ($this->birthdate) {
            $this->birthdate = Yii::$app->formatter
                ->asDatetime($this->birthdate, "php:Y-m-d");
        }

        if ($this->isNewRecord) {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        return parent::beforeSave($insert);
    }

    public function afterValidate()
    {
        if ($this->password) {
            $this->password = md5($this->password);
        }

        return parent::afterValidate();
    }

    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }
}
