<?php
/**
 * Created by PhpStorm.
 * User: abmes
 * Date: 31.08.2019
 * Time: 23:16
 */

namespace App\Helpers;


/**
 * Class Json
 * @author  Mike van Riel <meskine.abderrazzak@gmail.com>
 * @package App\Helpers
 */
class Json
{
    /**
     * $array to Json
     * @param $data
     * @return string
     * @throws \Exception
     */
    public static function encode($data)
    {

        $result = json_encode($data);
        if (json_last_error() != 0) {
            throw new \Exception("Errot encode Json " . json_last_error());
        }
        return $result;
    }

    /**
     * Json to array
     * @param $data
     * @return Array|NULL
     * @throws \Exception
     */
    public static function decode($data): Array
    {

        $result = json_decode($data, true);
        if (json_last_error() != 0) {
            throw new \Exception("Errot decode Json " . json_last_error());
        }
        return $result;
    }

}

?>
