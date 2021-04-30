<?php

// https://loadfunc.github.io/php/load_func.php
// curl https://loadfunc.github.io/php/load_func.php --output load_func.php

/**
 * @param array $func_url_array
 * @param $callback
 * @return mixed
 *
 * @throws Exception
 */
function load_func(array $func_url_array, $callback)
{
    $local_path = '';
    foreach ($func_url_array as $func_url) {

        $file_name = basename($func_url);
        $path = $local_path . $file_name;

        // download if not exist
        if (!file_exists($path)) {

            $out = fopen($path, "wb");
            if ($out == FALSE) {
                throw new Exception("File not opened");
            }

//            echo "::url: ". $func_url;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_FILE, $out);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_URL, $func_url);

            curl_exec($ch);

            if (!empty(curl_error($ch))) {
                throw new Exception("Error for url: ". $func_url . " : " . curl_error($ch));
            }

            curl_close($ch);
            //fclose($handle);
        }

        //    if(!@include($path)) throw new Exception("Failed to include 'script.php'");

        if (!file_exists($path)) {
            throw new Exception("File: " . $path . " not exist");
        }

        // include
        include_once($path);
    }

    return $callback($func_url_array);
}

/**
 * https://loadfunc.github.io/php/load_func.php
 *
 * Class LetJson
 */
class LoadFunc
{
    // IN
    public $func_url_array = [];

    // OUT
    public $val;


    /**
     * LoadFunc constructor.
     * @param array $func_url_array
     */
    public function __construct(array $func_url_array)
    {
        $this->func_url_array = $func_url_array;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function exec()
    {
        $local_path = '';
        foreach ($this->func_url_array as $func_url) {
            $file_name = basename($func_url);
//        var_dump($func_name);
            $path = $local_path . $file_name;

            // download if not exist
            if (!file_exists($path)) {

                $out = fopen($path, "wb");
                if ($out == FALSE) {
                    throw new Exception("File not opened");
                }

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_FILE, $out);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_URL, $func_url);

                curl_exec($ch);

                if (!empty(curl_error($ch))) {
                    throw new Exception("Error is : " . curl_error($ch));
                }

                curl_close($ch);
                //fclose($handle);
            }

            //    if(!@include($path)) throw new Exception("Failed to include 'script.php'");

            if (!file_exists($path)) {
                throw new Exception("File: " . $path . " not exist");
            }

            // include
            include_once($path);
        }

//        return $callback($func_url_array);
        return $this->val = $this->func_url_array;
    }

    /*
        public function __toString()
        {
            try
            {
                return (string) $this->val;
            }
            catch (Exception $exception)
            {
                return '';
            }
        }
    */

    function each($callback)
    {
        foreach ($this->val as $item) {
            $callback($item);
        }
    }
}
