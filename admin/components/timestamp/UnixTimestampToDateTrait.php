<?php

namespace admin\components\timestamp;

trait UnixTimestampToDateTrait
{
    public function beforeSave($insert)
    {
        $this->created_at = strtotime($this->created_at);
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->created_at = date('d.m.Y H:i:s', $this->created_at);
        $this->updated_at = date('d.m.Y H:i:s', $this->updated_at);
    }
}