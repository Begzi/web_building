<?php

namespace app\models;
use yii\db\ActiveRecord;
use \yii\web\IdentityInterface;

class Comment extends ActiveRecord 
{

    public static function tableName()
    {
        return 'comment';
    }


}
