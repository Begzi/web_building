<?php

namespace app\models;
use yii\db\ActiveRecord;
use \yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['token' => $token]);
        
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['login' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->login;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
    public function getHash()
    {
        return $this->hash;
    }
    public function getLogTicket()
    {
        return $this->hasMany(LogTicket::class, ['res_person' => 'id']);
    }
}
