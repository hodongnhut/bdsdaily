<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmailLog;

/**
 * EmailLogSearch represents the model behind the search form of `common\models\EmailLog`.
 */
class EmailLogSearch extends EmailLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id'], 'integer'],
            [['email', 'status', 'sent_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = EmailLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sent_at' => SORT_DESC
                ]
            ],
            
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'sent_at' => $this->sent_at,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'status', $this->status]);

        if (!empty($this->sent_at)) {
            $date = date('Y-m-d', strtotime($this->sent_at));
            $query->andFilterWhere(['between', 'sent_at', $date . " 00:00:00", $date . " 23:59:59"]);
        }

        return $dataProvider;
    }
}
