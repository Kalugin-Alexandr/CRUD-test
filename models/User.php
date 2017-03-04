<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $mail
 * @property string $password
 * @property integer $status
 * @property integer $group_id
 * @property string $auth_key
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Tasks[] $tasks
 * @property GroupUser $group
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 10;
    const ROLE_MANAGER = 1;
    const ROLE_EXECUTOR = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mail', 'password','name'],'filter','filter'=> 'trim'],
            [['mail','name','status'], 'required'],
            ['mail', 'email'],
            [['name', 'mail'], 'string', 'min'=>1,'max' => 30],
            ['password','required','on'=>'create'],
            [['mail'], 'unique','message'=>'Этот мэил уже используется'],
            [['name'], 'unique','message'=>'Этот имя уже используется'],
            ['role', 'in', 'range' => [self::ROLE_MANAGER, self::ROLE_EXECUTOR]],
        ];
    }

    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'mail' => 'Mail',
            'password' => 'Password',
            'status' => 'Status',
            'group_id' => 'Group ID',
            'auth_key' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param $username
     * @return bool
     */     
    public static function isUserManager($username)
    {
        if (static::findOne(['name' => $username, 'group_id' => self::ROLE_MANAGER]))
        {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(GroupUser::className(), ['id' => 'group_id']);
    }

    public function getName()
    {
        return $this->name;
    }


    /* Поведения */
//    public  function behaviors()
//    {
//        return [
//            TimestampBehavior::className()
//        ];
//    }

    /* Find */
    public  static  function findByUserName($userName){
        return static::findOne(['name'=>$userName]);
    }

    /* helpers */
    public  function setPassword($password){
        return $this->password = Yii::$app->security->generatePasswordHash($password);
    }
    public function generateAuthKey(){
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public  function validatePassword($password){
        return Yii::$app->security->validatePassword($password,$this->password);
    }

    /* authorization */
    public static function findIdentity($id)
    {
        return static::findOne(['id'=>$id,'status'=>self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}
