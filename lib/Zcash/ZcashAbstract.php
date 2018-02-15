<?php
/**
 * Created by HeximCZ
 * Date: 5/28/17 5:37 PM
 */

namespace Hexim\HeximZcashBundle\Zcash;

class ZcashAbstract
{
    /**
     * @var ZcashWrapper $wrapper
     */
    protected $wrapper;

    /**
     * Default command tail
     * @var array $defaultCommand
     */
    protected $defaultCommand = [
        "jsonrpc" => "1.0",
        "id" => "curl"
    ];

    /**
     * @var array|bool $result
     */
    protected $result;

    /**
     * @var array $params
     */
    protected $params;

    /**
     * @var string $error
     */
    protected $error = false;

    /**
     * ZcashWallet constructor.
     * @param array $params
     */
    public function __construct($params)
    {
        $this->params = $params;
        $this->wrapper = new ZcashWrapper($params);
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $command
     * @param array $params
     * @return array|bool
     */
    protected function getRpcResult($command, $params)
    {
        $this->result = $this->wrapper->rpcZcashCommand(
            $this->mergeCommand([
                'method' => $command,
                'params' => $params
            ])
        );
        return $this->checkResponse();
    }

    /**
     * @return array|bool
     */
    protected function checkResponse()
    {
        $this->error = false;
        if (isset($this->result['result'])) {
            if (!is_null($this->result['error']))
                $this->error = $this->result['error'];
            return $this->result;
        }
        if (is_string($this->result))
            $this->error = $this->result;
        return $this->result = false;
    }

    /**
     * @param array $array
     * @return array
     */
    protected function mergeCommand($array)
    {
        return array_merge($this->defaultCommand, $array);
    }

    /**
     * Convert scientific float: -6.7E-6 to -0.0000670
     */
    protected function fixScientificNumbers()
    {
        foreach ($this->result['result'] as $key => $value) {
            if (isset($value['balance']))
                $this->result['result'][$key]['balance'] = $this->convertScientificFloat($value['balance']);
            if (isset($value['amount']))
                $this->result['result'][$key]['amount'] = $this->convertScientificFloat($value['amount']);
            if (isset($value['fee']))
                $this->result['result'][$key]['fee'] = $this->convertScientificFloat($value['fee']);
        }
    }

    /**
     * @param string $value
     * @return string
     */
    protected function convertScientificFloat($value)
    {
        return number_format($value, 8);
    }

}