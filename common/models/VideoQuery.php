<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Video]].
 *
 * @see Video
 */
class VideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Video[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Video|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function creator($userId)
    {
        return $this->andWhere(['created_by' => $userId]);
    }

    public function latest()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }
    public function published(){
        return $this->andWhere(['status'=> Video::STATUS_PUBLISHED]);
    }
}
