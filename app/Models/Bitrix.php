<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Bitrix extends Model
{
    /**
     * Generate Bitrix URI with URL, User ID and Token
     *
     * @var $method string
     * @return string
     * @author Arthur Santos
     */
    public static function getUri(string $method): string
    {
        $url = $_ENV['BITRIX_URL'];
        if (str_ends_with($url, '/'))
            $url = substr($url, 0, -1);
        $user = $_ENV['BITRIX_USER'];
        $secret = $_ENV['BITRIX_SECRET'];

        return "$url/rest/$user/$secret/$method.json";
    }

    /**
     * Generate a request
     *
     * @return mixed array|string|boolean curl-return or error
     *
     * @var $method string
     * @var $params array
     * @author Arthur Santos
     */
    public static function call(string $method, array $params = []): mixed
    {

        $sPostFields = http_build_query($params);

        try{

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::getUri($method));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $_ENV['APP_NAME'] . $_ENV['APP_VERSION']);

            if($sPostFields){
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $sPostFields);
            }

            if($_ENV['CURL_IGNORE_SSL'] == true){
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            }
            $exec = true;
            while($exec){
                $response = curl_exec($ch);
                $result = json_decode($response, true);
                if(array_key_exists('error', $result) && $result['error'] == 'QUERY_LIMIT_EXCEEDED'){
                    sleep(0.1);
                }else{
                    $exec = false;
                }
            }
            $info = curl_getinfo($ch);

            if(curl_errno($ch)){
                $info[ 'curl_error' ] = curl_error($ch);
            }

            curl_close($ch);

            if(!empty($result['error'])){
                $arErrorInform = [
                    'invalid_grant' => 'Permissão inválida, verifique a definição de BITRIX_URL ou BITRIX_TOKEN',
                    'invalid_client' => 'Cliente inválido, verifique a definição de BITRIX_URL ou BITRIX_TOKEN',
                    'QUERY_LIMIT_EXCEEDED' => 'Muitas solicitações, máximo de 2 consultas por segundo',
                    'ERROR_METHOD_NOT_FOUND' => 'Método não encontrado! Você pode ver as permissões da aplicação: BitrixController::call(\'scope\')',
                    'NO_AUTH_FOUND' => 'Erro de autenticação no Bitrix24',
                    'INTERNAL_SERVER_ERROR' => 'Servidor fora do ar, tente novamente mais tarde'
                ];
                if(!empty($arErrorInform[ $result[ 'error' ] ])){
                    $result[ 'error_information' ] = $arErrorInform[ $result[ 'error' ] ];
                }else{
                    $result[ 'error_information' ] = 'Oops. Um erro inesperado ocorreu';
                }
            }
            if(!empty($info[ 'curl_error' ])){
                $result[ 'error' ] = 'curl_error';
                $result[ 'error_information' ] = $info[ 'curl_error' ];
            }

            return $result;

        } catch (Exception $e) {
            return [
                'error' => 'exception',
                'error_code' => $e->getCode(),
                'error_information' => $e->getMessage(),
            ];
        }
    }
}
