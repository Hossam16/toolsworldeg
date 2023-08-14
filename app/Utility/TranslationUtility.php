<?php


namespace App\Utility;

use App\Translation;

class TranslationUtility
{
    // Hold the class instance.
    private static $instance = null;
    private $translations;

    // The db connection is established in the private constructor.
    private function __construct()
    {
        $data = Translation::all();
        $this->translations = collect($data->toArray())->all();
        //$this->translations = collect($data->toArray());
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new TranslationUtility();
        }

        return self::$instance;
    }

    public static function reInstantiate()
    {
        self::$instance = new TranslationUtility();
    }

    public function cached_translation_row($lang_key, $lang)
    {
        $row = [];
        if (empty($this->translations)) {
            return $row;
        }


        // Use array_filter instead of foreach for better performance
        $filtered = array_filter($this->translations, function ($item) use ($lang_key, $lang) {
            return $item['lang_key'] == $lang_key && $item['lang'] == $lang;
        });
        
        $row = reset($filtered); // Get the first item of the filtered array

        return $row;
    }

    //The code below also works but it takes more time than the function written above
    //$this->translations = collect($data->toArray());
    /*public function cached_translation_row($lang_key, $lang)
    {
        $row = $this->translations->where('lang_key', $lang_key)->where('lang', $lang)->first();
        return $row != null ? $row : [];
    }*/

    public function getAllTranslations()
    {
        return $this->translations;
    }


}
