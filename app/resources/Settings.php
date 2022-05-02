<?php

namespace app\resources;

class Settings extends \common\models\Settings
{
    public function afterFind()
    {
        $this->about_us_images_links = unserialize($this->about_us_images_links);
        $this->restaurant_images_links = unserialize($this->restaurant_images_links);

        if ($this->about_us_images_links === false && $this->restaurant_images_links === false) {
            unset($this->about_us_images_links, $this->restaurant_images_links);
        } elseif ($this->about_us_images_links) {
            unset($this->restaurant_images_links);
        } else {
            unset($this->about_us_images_links);
        }
    }
}