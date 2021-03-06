<?php

namespace app\models;

use Yii;
use app\models\Customers;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password_hash;
    public $password_hash_confirm;
//    public $verifyCode;
    protected $_user = false; //object of user from UserModel



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['username', 'email', 'password_hash', 'password_hash_confirm'], 'required'],

            // email has to be a valid email address
            ['email', 'validateEmail'],
            ['password_hash','validatePassword'],
            // verifyCode needs to be entered correctly
            // ['verifyCode', 'captcha'],
        ];
    }
    public function  validatePassword($attribute)
    {
        if ($this->password_hash != $this->password_hash_confirm)
        {
            $this->addError($attribute,'Password do not matches');
            return false;
        }
        return true;
    }
    public function  validateEmail($attribute,$params)
    {
        return filter_var($this->email,FILTER_VALIDATE_EMAIL);

    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
//            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function signUp()
    {
        if ($this->validate()) {
            $this->_user=$this->getUser();
            if ($this->_user === null)
                return false;
            $this->_user->setAttributes([
                'username'=>$this->username,
                'auth_key'=>'random generate',
                'password_hash'=>password_hash($this->password_hash.Yii::$app->params['SALT'],PASSWORD_ARGON2I),
                'password_reset_token' => microtime(),
                'email' => $this->email,
                'status' => 1,
                'AccessToken'=>'Random generete',
                'created_at'=>getdate(),
                'updated_at'=>getdate()
            ]);
            $this->_user->save();
            return true;
        }

    }
    public function  getUser()
    {
        if ($this->_user ===false)
        {
            $this->_user = Customers::findByUsername($this->username);
            if ($this->_user !== null ) {
                Yii::$app->session->setFlash('error', 'This customer already exist');
                return null;
            }
            $this->_user = CustomersTemp::findByUsername($this->username);
            if ($this->_user === null) {
                $this->_user = new CustomersTemp();


            }
        }
        return $this->_user;
    }

}
