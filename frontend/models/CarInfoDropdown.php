<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "car_info".
 *
 * @property int $ci_id
 * @property string $name
 * @property int $parent
 * @property int $type
 * @property string $descn
 * @property string $image
 * @property string $slug
 * @property string $detail
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class CarInfoDropdown extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_info';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'type', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['descn'], 'string'],
            [['name'], 'string', 'max' => 70],
            [['image'], 'string', 'max' => 150],
            [['slug'], 'string', 'max' => 255],
            [['detail'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ci_id' => 'Ci ID',
            'name' => 'Name',
            'parent' => 'Parent',
            'type' => 'Type',
            'descn' => 'Descn',
            'image' => 'Image',
            'slug' => 'Slug',
            'detail' => 'Detail',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
