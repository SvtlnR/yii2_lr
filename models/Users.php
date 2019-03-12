<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $isAdmin
 * @property string $photo
 *
 * @property Comment[] $comments
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'isAdmin', 'photo'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    public function saveGroup($group){
        $this->isAdmin=$group;
        return $this->save(false);
    }

    public function getImage(){
        if($this->photo){
            return '/uploads/'.$this->photo;
        }
        return '/no-photo.png';
    }

    public function codePass(){
        $this->password=md5($this->password);
    }

    public function create(){
        if($this->validate()){
            $this->codePass();
            return $this->save();
        }
    }

    public function change(){
        $this->codePass();
        return $this->save(false);
    }

    public function saveImage($filename){
        $this->photo=$filename;
        return $this->save(false);
    }
}
