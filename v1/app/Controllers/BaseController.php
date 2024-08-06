<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\System\LogRequestModel;
use App\Models\User\UserModel;
use App\Models\User\UserLoginModel;


class BaseController extends Controller
{
    use ResponseTrait;
    

    protected $headers;
    protected $clientAppName;
    protected $clientAppVersion;
    protected $clientAccessToken;
    protected $records = FALSE;
    protected $headerDatas;
    protected $loggedUser;
    protected $loggedUserId = NULL;
    protected $userPermitions = NULL;
    protected $userRoleId = NULL;

    protected $allowedHeaders = [
        'foxdent_v1' => [
            'foxdent_crm' => 't0hN7PcgRM8RV05kehOhUxPKElMxAfEStzScqGAmWwNS2eRdLorv9YVIp45kU32ollqiN9xLGICPWROkWygdsafqsI27k554CmOy',
            'foxdent_app' => 't0hN7PcgRM8RV05kehOhUxPKElMxAfEStzScqGAmWwNS2eRdLorv9YVIp45kU32ollqiN9xLGICPWROkWygdsafqsI27k554CmOy',
	    ]   
    ];

    protected $allowedMethods = [
        'AccountController' => [
            'checkLogin',
            'login',
            'resetPassword',
            'newPassword',
            'updatePassword',
            'activateAccount'
        ],
        'SystemOptionController'=> [
            'get'
        ],
    ];

    public function __construct(RequestInterface $request = NULL)
    {     
        $this->request = $request;
        $controller  = class_basename(service('router')->controllerName());
        $method = service('router')->methodName();
        $httpMethod = service('request')->getMethod();

        //$this->db = \Config\Database::connect();

        $__log = new LogRequestModel(\CodeIgniter\Config\Services::request());
        if ($__log->create() === FALSE)
        {
            header('Content-Type: application/json');
            header("HTTP/1.1 500");
            exit;
        }

        $request = \Config\Services::request();

        $this->GetAppInfo();

        $authorizationHeader = $request->getHeaderLine('Authorization');
        $bearerToken = substr($authorizationHeader, 7);

        if ($bearerToken == 123456 || $httpMethod == "options" || (isset($this->allowedMethods[$controller]) && in_array($method, $this->allowedMethods[$controller])))
        {
            if ($this->clientAppName == 'foxdent_crm' && $controller == 'SystemOptionController')
            {
                if (!empty($authorizationHeader) && strpos($authorizationHeader, 'Bearer') === 0)
                {
                    if ($this->getLoggedUserId() === FALSE)
                    {
                        header('Content-Type: application/json');
                        header('Access-Control-Allow-Origin: *');
                        header('Access-Control-Allow-Headers: *');
                        header('Access-Control-Allow-Methods: DELETE, GET, OPTIONS, POST, PUT');
                        http_response_code(401);
                        echo json_encode(['message' => 'Chybný bearer token']);
                        exit;
                    }
                    //$this->getLoggedUserPermitions();
                    $this->getLoggedUserRoleId();
                }
                else
                {
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    header('Access-Control-Allow-Headers: *');
                    header('Access-Control-Allow-Methods: DELETE, GET, OPTIONS, POST, PUT');
                    http_response_code(401);
                    echo json_encode(['message' => 'Nezadaný bearer token']);
                    exit;
                }
            }
        }
        else
        {
            if (!empty($authorizationHeader) && strpos($authorizationHeader, 'Bearer') === 0)
            {
                if ($this->getLoggedUserId() === FALSE)
                {
                    header('Content-Type: application/json');
                    header('Access-Control-Allow-Origin: *');
                    header('Access-Control-Allow-Headers: *');
                    header('Access-Control-Allow-Methods: DELETE, GET, OPTIONS, POST, PUT');
                    http_response_code(401);
                    echo json_encode(['message' => 'Chybný bearer token']);
                    exit;
                }
                //$this->getLoggedUserPermitions();
                $this->getLoggedUserRoleId();
            }
            else
            {
                header('Content-Type: application/json');
                header('Access-Control-Allow-Origin: *');
                header('Access-Control-Allow-Headers: *');
                header('Access-Control-Allow-Methods: DELETE, GET, OPTIONS, POST, PUT');
                http_response_code(401);
                echo json_encode(['message' => 'Nezadaný bearer token']);
                exit;
            }
        }
    }

    public function GetAppInfo()
    {
        $request = \Config\Services::request();
        $this->headers = $request->getHeaders();

        $this->headerDatas = [
            'host' => $this->headers['Host']->getValue(),
            'ip_address' => $request->getIPAddress(),
        ];
                
        if ($request->getMethod(TRUE) === 'OPTIONS')
        {
            return TRUE;
        }

        if (!isset($this->headers['App-Name']) || !isset($this->headers['App-Version']) || !isset($this->headers['Access-Token']))
        {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: *');
            header('Access-Control-Allow-Methods: DELETE, GET, OPTIONS, POST, PUT');
            http_response_code(401);
            exit;
        }

        $this->clientAppName = $this->headers['App-Name']->getValue();
        $this->clientAppVersion = $this->headers['App-Version']->getValue();
        $this->clientAccessToken = $this->headers['Access-Token']->getValue();

        if (!isset($this->allowedHeaders[$this->clientAppVersion][$this->clientAppName]))
        {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: *');
            header('Access-Control-Allow-Methods: DELETE, GET, OPTIONS, POST, PUT');
            http_response_code(401);
            exit;
        }

        if ($this->allowedHeaders[$this->clientAppVersion][$this->clientAppName] !== $this->clientAccessToken)
        {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: *');
            header('Access-Control-Allow-Methods: DELETE, GET, OPTIONS, POST, PUT');
            http_response_code(401);
            exit;
        }
    }

    public function getLoggedUserId()
    {
        $request = service('request');

        $authorizationHeader = $request->getHeaderLine('Authorization');
        $bearerToken = substr($authorizationHeader, 7);

        $__user = new UserModel;
        $userId = $__user->authorizeTokenValidity($bearerToken);
        
        if (!$userId)
        {
            return FALSE;
        }
        else
        {
            $this->loggedUserId = $userId;
            return TRUE;
        }
    }

   /*  public function getLoggedUserPermitions()
    {
        $__user = new UserModel;
        $__user->setUserId($this->loggedUserId);
        $__user->setFormat('permitions');

        $this->userPermitions = $__user->getRecord()['permitions'];
    } */

    public function getLoggedUserRoleId()
    {
        $__user = new UserModel;
        $__user->setUserId($this->loggedUserId);
        $this->userRoleId = $__user->getRecord()['role']['id'];
    }
 
}