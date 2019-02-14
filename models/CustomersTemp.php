<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers_temp".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $AccessToken
 */
class CustomersTemp extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{


    public static  function  findByUsername($username)
    {
        $user = self::find()->where(["username"=>$username])->one();
        if ($user === null)
            return null;
        return new static($user);
    }
    public  static function  findIdentity($id)
    {
        $user = self::find()->where(["id" => $id])->one();
        if ($user == null)
            return null;
        return new  static($user);
    }
    public  static  function  findIdentityByAccessToken($token, $type = null)
    {
        $user = self::find()->where(["AccessToken" => $token])->one();
        if ($user == null)
            return null;
        return new  static($user);

    }

    public function delete()
    {
        return parent::delete();
    }

    public function  getId()
    {
        return $this->id;
    }
    public  function getAuthKey()
    {
        return $this->auth_key;
    }
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers_temp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'AccessToken'], 'string', 'max' => 255],
            [['password_reset_token'], 'unique'],
            [['email'], 'unique'],
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
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'AccessToken' => 'Access Token',
        ];
    }
    public   function validatePassword($password)
    {
        return $this->password_hash==$password;
    }

}
