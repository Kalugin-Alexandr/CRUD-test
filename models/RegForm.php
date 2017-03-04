<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 028 28.02.17
 * Time: 23:02
 */
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

class RegForm extends Model
{
    public $name;
    public $mail;
    public $password;
    public $status;
    
    public function rules(){
        return [
              [['name','mail','password'],'required'],
              [['name','mail','password'],'filter','filter'=>'trim'],
              [['name', 'mail'], 'string', 'min'=>1,'max' => 30],
              [['password'], 'string', 'min'=>6,'max' => 30],
              ['name','unique','targetClass'=>User::className(),'message'=>'имя занято'],
              ['mail','email'],
              ['mail','unique','targetClass'=>User::className(),'message'=>'mail занят'],
              ['status','default','value'=>User::STATUS_ACTIVE,'on'=>'default'],
              ['status','in','range'=>[
                  User::STATUS_ACTIVE,
                  User::STATUS_NOT_ACTIVE
              ]]
        ];
    }
    public  function reg(){
        $user = new User();
        $user->name = $this->name;
        $user->mail = $this->mail;
        $user->status = $this->status;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
}