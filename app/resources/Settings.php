<?php

namespace app\resources;

class Settings extends \common\models\Settings
{
    public function afterFind()
    {
        if ($this->about_us_images_links !== null) {
            $this->about_us_images_links = unserialize($this->about_us_images_links);
        }
        if ($this->restaurant_images_links !== null) {
            $this->restaurant_images_links = unserialize($this->restaurant_images_links);
        }
    }
}