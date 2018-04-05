<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use modules\users\models\User;
/**
 * This is the model class for table "app_logs".
 *
 * @property int $log_id
 * @property int $enq_id
 * @property int $part_id
 * @property string $agent_remarks
 * @property int $suggestion_id
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class AppLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_logs';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enq_id', 'part_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['enq_id', 'part_id', 'suggestion_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['agent_remarks'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'enq_id' => 'Enq ID',
            'part_id' => 'Part ID',
            'agent_remarks' => 'Agent Remarks',
            'suggestion_id' => 'Suggestion ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     * @return AppLogsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppLogsQuery(get_called_class());
    }

    public function getUserName()
    {   
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
