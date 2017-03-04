<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 028 28.02.17
 * Time: 23:02
 */
namespace app\models;

use yii\base\Model;
use Yii;

class LoginForm extends Model
{
    private $_user = false;
    public $name;
    public $mail;
    public $password;
    public $rememberMe = true;
    public  $status ;

    public function rules(){
        return[
                [['name','password'],'required','on'=>'default'],
                ['mail','email'],
                ['rememberMe','boolean'],
                ['password','validatePassword']
        ];
    }
    public  function  validatePassword($attribute){
        if(!$this->hasErrors()):
            $user = $this->getUser();
            if(!$user || !$user->validatePassword($this->password)):
                $this->addError($attribute,'Неправильный логин или пароль');
            endif;
        endif;
    }

    public function getUser(){
        if($this->_user === false):
            $this->_user = User::findByUserName($this->name);
        endif;
        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
          'name'=>'имя пользователя',
            'password'=>'пароль'
        ];
    }

    public  function  login(){
        if($this->validate()){
            $this->status = ($user = $this->getUser()) ? $user->status : User::STATUS_NOT_ACTIVE;
            if($this->status === User::STATUS_ACTIVE):
                return Yii::$app->user->login($user,$this->rememberMe ? 3600*24*30 : 0);
            else :
                return false;
            endif;
        }
        else return false;
    }
}