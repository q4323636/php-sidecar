<?php
namespace Sidecar\Client\tool;

class Response
{
    /**
     * 原始数据
     * @var mixed
     */
    protected $data;

    /**
     * 状态码
     * @var integer
     */
    protected $code = 200;

    /**
     * 输出内容
     * @var string
     */
    protected $content = null;

    protected $starttime = 0;
    protected $endtime = 0;

    /**
     * 架构函数
     * @access public
     * @param  mixed $data    输出数据
     * @param  int   $code
     * @param  array $header
     * @param  array $options 输出参数
     */
    public function __construct($data = '', $code = 200){
    
        $this->data($data);
        $this->code   = $code;
    }    

    /**
     * 输出数据设置
     * @access public
     * @param  mixed $data 输出数据
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * 发送HTTP状态
     * @access public
     * @param  integer $code 状态码
     * @return $this
     */
    public function code($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * 获取原始数据
     * @access public
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 获取状态码
     * @access public
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    public function __debugInfo()
    {
        $data = get_object_vars($this);
        unset($data['app']);

        return $data;
    }

    /**
     * 获取输出数据
     * @access public
     * @return mixed
     */
    public function getContent()
    {
        if (null == $this->content) {
            $content = $this->output($this->data);

            if (null !== $content && !is_string($content) && !is_numeric($content) && !is_callable([
                $content,
                '__toString',
            ])
            ) {
                throw new \InvalidArgumentException(sprintf('variable type error： %s', gettype($content)));
            }

            $this->content = (string) $content;
        }

        return $this->content;
    }

    
}
