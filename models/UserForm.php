<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class UserForm extends Model
{
    public $username;
    public $password;
    public $check_password;
    public $name;
    public $phone;
    public $city;
    public $date;
    public $avatar;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'name', 'phone', 'city', 'date', 'check_password'], 'required'],
            [['password', 'check_password'], 'validateNewPassword'],
            [['username'], 'string', 'max' => 20],
            [['password', 'check_password' ], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 40],
            [['phone'], 'string', 'max' => 10],
            [['city'], 'string', 'max' => 40],
            [['avatar'], 'string', 'max' => 250],
        ];
    }




    public function validateNewPassword()
    {

        if (!$this->hasErrors()) {
            if ($this->password == $this->check_password) {
                return true;
            }
            Yii::$app->session->setFlash('Wrongchecknewpassword');
            return false;
        }
        return false;
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername((Yii::$app->user->identity->username));
        }

        return $this->_user;
    }

    public function getUserform()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
