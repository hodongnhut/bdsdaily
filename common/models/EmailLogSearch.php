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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sent_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // filter theo id, campaign_id
        $query->andFilterWhere([
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
        ]);

        // filter email
        $query->andFilterWhere(['like', 'email', $this->email]);

        // filter status (chính xác, không dùng LIKE)
        if (!empty($this->status)) {
            $query->andFilterWhere(['status' => $this->status]);
        }

        // filter sent_at theo ngày (yyyy-mm-dd)
        if (!empty($this->sent_at)) {
            $date = date('Y-m-d', strtotime($this->sent_at));
            $query->andFilterWhere([
                'between',
                'sent_at',
                $date . ' 00:00:00',
                $date . ' 23:59:59'
            ]);
        }

        return $dataProvider;
    }
}
