<?php
/**Nouran Ahmed */
namespace App\Helpers;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Http\ResponseFactory;
class ApiResponse
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ResponseFactory
     */
    protected $response;

    /**
     * @var array
     */
    protected $body;


    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
       
    }



    /**
     * Set response data.
     *
     * @param $data
     * @return $this
     */
    public function setData($data=null)
    {
        $this->body['data'] = $data;
        return $this;
    }


    public function setError($error)
    {
        $this->body['status'] = false;
        $this->body['message'] = $error;
        return $this;
    }
    public function setSuccess($message)
    {
        $this->body['status'] = true;
        $this->body['message'] = $message;
        return $this;
    }
    public function setVerify($status=null)
    {
        $this->body['verify'] = $status;
        return $this;
    }
    
    public function setCode($code)
    {
        $this->body['code'] = $code;
        return $this;
    }
  

    public function send()
    {
        return $this->response->json($this->body,200,[],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }

    





}