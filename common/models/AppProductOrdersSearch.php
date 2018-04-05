<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AppProductOrders;

/**
 * AppProductOrdersSearch represents the model behind the search form of `common\models\AppProductOrders`.
 */
class AppProductOrdersSearch extends AppProductOrders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['txn_id', 'shipping_time', 'product_info', 'status'], 'safe'],
            [['amount'], 'number'],
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
        $query = AppProductOrders::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'txn_id', $this->txn_id])
            ->andFilterWhere(['like', 'shipping_time', $this->shipping_time])
            ->andFilterWhere(['like', 'product_info', $this->product_info])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
