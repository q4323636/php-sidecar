<?php
namespace Sidecar\Client\tool;

class Http {

	private $ch = null;

	public function __construct() {
        $this->ch = curl_init();
    }

    public function closech(){
    	curl_close($this->ch);
    }
    
    /**
	 * @param string   $url 访问链接
	 * @param int $retry 重试次数, 默认3次
	 * @param int $sleep 重试间隔时间, 默认1s
	 * @return output curl返回结果
	 */
	public function curlRetry($url, $param=[], $method = 'GET', $retry=3, $sleep=1){
		$isoutput = 0;
		$method = strtolower($method);
		if (!in_array($method, ['get','post'])) {
			return;
		}

        do{
        	list($output, $status) = call_user_func_array([$this, $method], [$url, $param]);
        	//var_dump($output);
        	//var_dump($status);
		    if (isset($status['http_code']) && intval($status['http_code'])==200) {
                $isoutput = 1;
		        break;
		    }
		    //阻塞1s
			sleep($sleep);
        } while(--$retry);

	    $this->closech();

	    return $isoutput;
	}

	


	/**
	 * @param $url
	 * @return aStatus
	 */
    protected function get($url, $param=[], $time=5){
        
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($this->ch, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $time);
	    curl_setopt($this->ch, CURLOPT_TIMEOUT, $time);
        $sContent = curl_exec($this->ch);
        $aStatus = curl_getinfo($this->ch);
        return [$sContent, $aStatus];
    }

    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @param boolean $post_file 是否文件上传
     * @return aStatus
     */
    protected function post($url, $param, $post_file=false, $time=5){
        $this->ch = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($this->ch, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else{
            $aPOST = array();
            foreach($param as $key=>$val){
                $aPOST[] = $key."=".urlencode($val);
            }
            $strPOST =  join("&", $aPOST);
        }
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_POST,true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS,$strPOST);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $time);
	    curl_setopt($this->ch, CURLOPT_TIMEOUT, $time);
        $sContent = curl_exec($this->ch);
        $aStatus = curl_getinfo($this->ch);
        return [$sContent, $aStatus];
    }



}

