<?php
namespace Sidecar\Client\tool;

class Response
{
    //目录分割符
    const DS = DIRECTORY_SEPARATOR;

    /**
     * 原始数据
     * @var mixed
     */
    protected $data = 0;

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

    /**
     * 架构函数
     * @access public
     * @param  mixed $data    输出数据
     * @param  int   $code
     * @param  array $header
     * @param  array $options 输出参数
     */
    public function __construct($data = 0, $code = 200){
    
        $this->setData($data);
        $this->code   = $code;
    } 

    public function setData($data){
        if ($data) {
            $this->setContent("success");
        }else{
            $this->setContent("error");
        }
        $this->data = $data;

        return $this;
    }

    public function getData(){
        return $this->data;
    }

    public function setCode($code){
        $this->code = $code;

        return $this;
    }

    public function getCode(){
        return $this->code;
    }

    public function __debugInfo(){
        $data = get_object_vars($this);
        unset($data['app']);

        return $data;
    }

    public function setContent($content){
        $this->content = $content;
     
    }

    public function getContent(){
        if (null == $this->content) {

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

    /**
     * [forward FallBack]
     * @param  string $furl [description]
     * @return [type]       [description]
     */
    public function forward($furl=''){
        if (!empty($url)) {
            header("location:".$url);
        }else{
            $this->setContent("Access error, please contact administrator");
            $this->output();
        }
    }

    /**
     * [output 输出结果]
     * @return [type] [description]
     */
    public function output(){
        print_r(json_encode(["rcode"=>$this->getData(),"rdata"=>$this->getContent()]));
    }

    /**
     * rizhi 
     * @param type $text
     * @param type $file
     */
    public function writeLog($text = '', $file = "debug--xmpush") {
        $folder = "." . self::DS . "Logs";
        if (!is_dir($folder)) {
            mkdir($folder);
        }
        $filename = $folder . self::DS . $file . date("Y-m-d H") . '.txt';
        $text = "[" . date("Y-m-d H:i:s") . "]" . $text;
        $text .= "\r\n";
        $handle = fopen($filename, "a");
        fwrite($handle, $text);
        fclose($handle);
    }

    /**
     * 处理接口header 信息 保证能跨域
     */
    public function crossDomain() {
        header('Access-Control-Allow-Origin:* ');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
        header('Content-Type:application/json; charset=utf-8');
        header('X-Powered-By:FANGFEI-PLATFORM');
    }
    
}
