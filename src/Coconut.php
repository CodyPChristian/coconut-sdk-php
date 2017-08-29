<?php namespace CodyPChristian\Coconut;

use CodyPChristian\Coconut\Exceptions\InvalidAPIKeyException;

/**
 * Class Coconut
 * @package CodyPChristian\Coconut
 */
class Coconut
{

    /**
     * Coconut api url
     *
     * @var string
     */
    private $apiUrl = 'https://api.coconut.co';

    /**
     * Email address to check
     *
     * @var string
     */
    private $apiKey;

    /**
     * @var array
     */
    private $config;

    public function __construct()
    {
        $this->config = config('coconut');
        if (isset($this->config['api_key'])) {
            $this->apiKey = $this->config['api_key'];
        } else {
            throw new InvalidAPIKeyException;
        }
    }

    /**
     * Create the encoding job
     *
     * @param $options
     * @return array
     */
    public function create($options = array())
    {
        $config   = $this->generateConfig($options);
        $response = $this->submit($config);
        return $response;
    }

    /**
     * Submit the encoding job
     *
     * @param $config_content
     * @return array
     */
    private function submit($config_content)
    {
        if (!$this->apiKey) {
            throw new InvalidAPIKeyException;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . "/v1/job");
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $config_content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Coconut/2.2.2 (PHP)");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Length: ' . strlen($config_content),
            'Content-Type: text/plain',
            'Accept: application/json')
        );
        $result = curl_exec($ch);
        return json_decode($result);
    }

    /**
     * Function to process config options.
     *
     * @param $options
     * @return string
     */
    private function generateConfig($options = array())
    {
        $conf = array();
        if (isset($options['conf'])) {
            $conf_file = $options['conf'];
            if ($conf_file != null) {
                $conf = explode("\n", trim(file_get_contents($conf_file)));
            }
        }

        if (isset($options['vars'])) {
            $vars = $options['vars'];
            if ($vars != null) {
                foreach ($vars as $name => $value) {
                    $conf[] = 'var ' . $name . ' = ' . $value;
                }
            }
        }

        if (isset($options['source'])) {
            $source = $options['source'];
            if ($source != null) {
                $conf[] = 'set source = ' . $source;
            }
        }

        if (isset($this->config['webhook'])) {
            $webhook = $this->config['webhook'];
            if ($webhook != null) {
                $conf[] = 'set webhook = ' . $webhook;
            }
        } elseif (isset($options['webhook'])) {
            $webhook = $options['webhook'];
            if ($webhook != null) {
                $conf[] = 'set webhook = ' . $webhook;
            }
        }

        if (isset($options['outputs'])) {
            $outputs = $options['outputs'];
            if ($outputs != null) {
                foreach ($outputs as $format => $cdn) {
                    $conf[] = '-> ' . $format . ' = ' . $cdn;
                }
            }
        }

        // Reformatting the generated config
        $new_conf = array();

        $vars_arr = array_filter($conf, function ($l) {
            return (0 === strpos($l, 'var'));
        });

        sort($vars_arr);
        $new_conf   = array_merge($new_conf, $vars_arr);
        $new_conf[] = '';

        $set_arr = array_filter($conf, function ($l) {
            return (0 === strpos($l, 'set'));
        });

        sort($set_arr);
        $new_conf   = array_merge($new_conf, $set_arr);
        $new_conf[] = '';

        $out_arr = array_filter($conf, function ($l) {
            return (0 === strpos($l, '->'));
        });

        sort($out_arr);
        $new_conf = array_merge($new_conf, $out_arr);

        return join("\n", $new_conf);
    }
}
