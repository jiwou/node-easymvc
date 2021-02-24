<?php

namespace Controller;

class Controller
{
    protected $__exec_func;
    protected $__variables;

    /**
     * * REQUEST_URI 값에 따라서 실행 될 함수 지정
     * * '/' 요청이 오면 index 함수가 실행 될 수 있도록 별도 지정
     */
    public function __construct($__exec_func = '/', $__variables = [])
    {   
        $this->__exec_func = $__exec_func ?: 'index';
        $this->__variables = $__variables;
    }

    /**
     * * 첫번째 인자로 표시할 페이지를 입력 받아서 include 처리
     * * 페이지에서 사용할 데이터는 두번째 인자에서 배열로 받음
     * 
     * @param string $req
     * @param array $res
     */
    public function view(string $req, array $res = array())
    {
        if (is_file("view/{$req}.php"))
            include_once "view/{$req}.php";
        else
            echo "No such view file : {$req}";
    }

    /**
     * * 컨트롤러 로직 처리 중, 이벤트 발생 시 페이지 전환
     * 
     * @param string $location
     * @param string $message
     */
    public function relocation(string $location = '/', string $message = '')
    {
        $alert = !empty($message) ? "alert('{$message}');" : "";
        echo "<script>{$alert}location.href='{$location}';</script>";
    }

    /**
     * * $_POST 또는 $_GET 등 입력 값에 대한 기본적인 injection 방어 처리
     * 
     * @param array $request
     * @return array
     */
    function injection(array $request = array()):array
    {
        foreach ($request as $key => $req) {
            if (is_array($req)) {
                array_map('injection', $req);
            } else {
                $request[$key] = htmlspecialchars(strip_tags($req), ENT_QUOTES);
            }
        }

        return $request;
    }

}