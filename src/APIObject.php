<?php
namespace Pipefy;

class APIObject {

    protected $url = 'https://api.pipefy.com/graphql';


    /**
     * @param $url string
     * @param $headers array
     * @param $postData mixed
     * @return mixed
     * @throws Exception
     */
    protected function send_post($postData) {
        $headers = Pipefy::get_auth_headers();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    /**
     * @param array $fields
     * @return string
     * @throws InvalidArrayException
     */
    public static function convert(array $fields): string
    {
        //Convert array to json
        $fields = json_encode($fields, JSON_PRETTY_PRINT);

        $fields = rtrim($fields, "}");
        $fields = ltrim($fields, "{");

        //Remove array indexes
        $fields = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $fields);

        $fields = str_replace('"', '\"', $fields);

        //Replace square brackets to curly brackets
        //$fields = str_replace(['[',']'], ['{','}'], $fields);

        $fields = preg_replace("/\r|\n/", "", $fields);

        $fields = trim($fields);

        return $fields;
    }

    public static function getFields(array $fields) : string
    {
        if (is_array($fields)) {
            $fields = self::convert($fields);
            $fields = str_replace(':{', '{', $fields);
            $fields = str_replace('\"', '', $fields);
        } else {
            $fields = implode(',', $fields);
        }

        return $fields;
    }

    /**
     * @param $resp mixed
     */
    final protected function assign_results ($resp)
    {
        if (is_string($resp)) {
            $resp = json_decode($resp);
        }

        if (is_array($resp)) {
            foreach ($resp as $key => $val)
            {
                if (property_exists(get_called_class(), $key))
                {
                    $this->$key = $val;
                }
                else {
                    $this->{$key} = $val;
                }
            }
        }
    }

    /**
     * @param $propName string
     * @param $className string
     */
    protected function parse_property($propName, $className) {
        if (property_exists(get_called_class(), $propName) && $this->$propName != null) {
            if (is_array($this->$propName)) {
                $tmp_val = array();
                foreach ($this->$propName as $key => $value) {
                    $tmp_val[] = new $className($value);
                }
                $this->$propName = $tmp_val;
            }
            else {
                $this->$propName = new $className($this->$propName);
            }
        }
    }
}
