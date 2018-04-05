<?php

namespace modules\users\models\backend;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class EmployeeSearch extends User
{
    public $userRoleName;
    public $date_from;
    public $date_to;
    public $pageSize;
	public $fullName;

    public function init()
    {
        parent::init();
        $this->pageSize = Yii::$app->params['user.pageSize'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'pageSize'], 'integer'],
            [['avatar', 'first_name', 'last_name', 'username', 'email', 'mobile', 'role', 'userRoleName', 'date_from', 'date_to', 'fullName'], 'safe'],
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
        $query = User::find();

        // add conditions that should always apply here
        $query->leftJoin('{{%auth_assignment}}', '{{%auth_assignment}}.user_id = {{%user}}.id')->where(['not like', '{{%auth_assignment}}.item_name', 'user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
				'first_name',
				'last_name',
                'username',
                'email',
				'mobile',
				'avatar',
                'status',
                'userRoleName' => [
                    'asc' => ['item_name' => SORT_ASC],
                    'desc' => ['item_name' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Role Name',
                ],
				'fullName' => [
					'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
					'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
					'label' => 'fullName',
					'default' => SORT_ASC
				],
                'last_visit'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
			->andFilterWhere(['like', 'first_name', $this->first_name])
			->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
			->andFilterWhere(['like', 'mobile', $this->mobile])
			->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'item_name', $this->userRoleName])
            ->andFilterWhere(['>=', 'last_visit', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'last_visit', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null])
			->andFilterWhere([
                'or',
                ['like', 'first_name', $this->fullName],
                ['like', 'last_name', $this->fullName],
                ['like', 'CONCAT_WS(" ", `first_name`, `last_name`)', $this->fullName]]);

        if($this->pageSize) {
            $dataProvider->pagination->pageSize = $this->pageSize;
        }

        $dataProvider->pagination->totalCount = $query->count();
        return $dataProvider;
    }
}
