<?php
namespace Pipefy;

class Pipefy extends APIObject
{

    private static $user_token;

    /**
     * @param $token string User's API Key
     */
    function __construct($token) {
        Pipefy::$user_token = $token;
    }

    /**
     * @return $this
     */
    public function query(string $fn, $data, $fields = []) {

        $fields = self::getFields($fields);

        $dataObject = self::convert($data);

        $resp = $this->send_post('{"query":"query{' . $fn . ' (' . $dataObject . '), {' . $fields . '}}"}');
        $this->assign_results($resp);

        return $this;
    }

    /**
     * @param array $data
     * @param array $return
     * @return string
     */
    public function mutation(string $fn, array $data, $return = [])
    {
        $dataObject = self::convert($data);

        if (is_array($return)) {
            $returnEntity = array_key_first($return);

            if (is_array($return[$returnEntity])) {
                $returnData = $returnEntity .' {' . self::getFields($return[$returnEntity]) . '}';
            } else {
                $returnData = self::getFields($return);
            }
        } else {
            $returnData = $return;
        }

        $request = '{"query":"mutation {' . $fn . '(input: {' . $dataObject . '}) { ' . $returnData . ' } }"}';

        $resp = $this->send_post($request);

        // $this->assign_results($resp);

        return json_decode($resp);
    }

    public static function get_auth_headers() {
        if (Pipefy::$user_token != null)
            return [
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36',
                'Connection: keep-alive',
                'Accept: */*',
                //'Accept-Encoding: gzip, deflate, sdch, br',
                'Content-Type: application/json',
                'Authorization: Bearer ' . Pipefy::$user_token
            ];
        else
            throw new Exception("Pipefy API is not inited. You should create an instance of Pipefy first");
    }
}
