<?php


namespace Huytt\Core;


use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Core
{
    public function getSql($sql, $bindings)
    {
        $needle = '?';
        foreach ($bindings as $replace){
            if(is_string($replace)){
                $replace = '"'.$replace.'"';
            }
            $pos = strpos($sql, $needle);
            if ($pos !== false) {
                $sql = substr_replace($sql, $replace, $pos, strlen($needle));
            }
        }
        return $sql;
    }

    public function createLogStack($logfile) {
        $logger = new Logger('Logger');
        $logger->pushHandler(new StreamHandler(storage_path() . '/logs/'.$logfile), Logger::DEBUG);

        $stack = HandlerStack::create();
        $stack->push(
            Middleware::log(
                $logger,
                new MessageFormatter('{request} - {res_body}')
            )
        );

        return $stack;
    }

    /**
     * @param $search
     *
     * @return null
     */
    public function parserSearchValue($search)
    {
        $res = [];
        if (stripos($search, ';') || stripos($search, ':')) {
            $values = explode(';', $search);
            foreach ($values as $value) {
                list($key, $value) = explode(':', $value);
                $res[$key] = $value;
            }
        }

        return $res;
    }

    public function correctZeroDate($input) {
        return in_array($input, ['0000-00-00', '0000-00-00 00:00:00']) ? null : $input;
    }

    /**
     * Build success response
     * @param string|array $data
     * @param int $code
     * @return JsonResponse
     */
    public function success(int $code = Response::HTTP_OK, $data = [], string $messageCode = ''): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => (object)$data,
            'status' => $code,
            'message' => (object)[
//                'key' => $messageCode,
                'message' => ($messageCode) ? __($messageCode) : ''
            ],
        ], $code);
    }

    /**
     * * Build error response
     * @param mixed | int $code
     * @param ?string $messageCode
     * @return JsonResponse
     */
    public function error($code, ?string $messageCode, ?string $message): JsonResponse
    {
        return response()->json([
            'data' => (object)[],
            'message' => (object)[
//                'key' => $messageCode,
                'message' => ($message) ? __($message) : ''
            ],
            'status' => $code
        ], is_numeric($code) && $code ? $code : 400);
    }
}
