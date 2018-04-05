<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AppCarEnquiry;

/**
 * AppCarEnquirySearch represents the model behind the search form of `common\models\AppCarEnquiry`.
 */
class AppCarEnquirySearch extends AppCarEnquiry
{   
     public $garage_owner_name;
     public $created_time;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['car_chassis_number','garage_owner_name','created_time','brand', 'model', 'variant', 'engine', 'year'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AppCarEnquiry::find()
                            ->joinWith(['userName']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['garage_owner_name'] = [
            'asc' => ['tbl_user.garage_owner_name' => SORT_ASC],
            'desc' => ['tbl_user.garage_owner_name' => SORT_DESC],
            'label' => 'Owner Name',
            'default' => SORT_ASC
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'car_chassis_number', $this->car_chassis_number])
            ->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'variant', $this->variant])
            ->andFilterWhere(['like', 'engine', $this->engine])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'tbl_user.garage_owner_name', $this->garage_owner_name])
            ->andFilterWhere(['>=', 'app_car_enquiry.created_at', $this->created_time ? strtotime($this->created_time . ' 00:00:00') : null]);

        return $dataProvider;
    }
}
