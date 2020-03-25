<?php

namespace Model;

class Option extends \Core\Model\Model {

    public static function csText(){
        $content = \Model\Content::findContent('option', 'cs_text', 'option_name');

        return json_decode($content['value'], true);
    }

}