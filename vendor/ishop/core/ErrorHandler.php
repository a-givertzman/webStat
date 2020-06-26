<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ishop;

/**
 * Description of ErrorHandler
 *
 * @author antonlobanov
 */
class ErrorHandler {

    public function __construct() {
        
        $this->logErrors('Start new session', '', '');
        
        // настраиваем вывод ошибок в зависимости от константы DEBUG
        if(DEBUG) {     // если 1 - режим разработки, включаем вывод ошибок
            error_reporting(E_ALL); // Error engine - always E_ALL!
            ini_set('ignore_repeated_errors', true); // always TRUE
            ini_set('display_errors', true); // Error display
            ini_set('log_errors', true); // Error logging engine
//            ini_set('error_log', self::$logPath .self::$errorLogFile); // Logging file path
//            ini_set('log_errors_max_len', 16384); // Logging file size
        } else {        // если не 1 - режим deploy, отключаем вывод ошибок и перенаправляем их в лог-файл
            error_reporting( E_ALL & ~E_NOTICE); // Error engine - always E_ALL!
            ini_set('ignore_repeated_errors', true); // always TRUE
            ini_set('display_errors', false); // Error display
            ini_set('log_errors', true); // Error logging engine
//            ini_set('error_log', self::$logPath .self::$errorLogFile); // Logging file path
//            ini_set('log_errors_max_len', 16384); // Logging file size            
        }
        
        // назначаем обработчик ошибок
        set_exception_handler([$this, 'exceptionHandler']);
    }
    
    
    
    // обработчик ошибок
    public function exceptionHandler($e) {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }
    
    
    
    // вывод ошибок в файл
    protected function logErrors($mess = '', $file = '', $line = '') {
        error_log(
            "[" .date('Y-m-d H:i:s') . "] : $mess | в $file [$line]\n",   // сообщение об ошибке
            3,                                                                  // запись в файл
            LOGS .'/error.log'                                                  // имя файла ошибок
        );
    }
    
    
    
    //
    protected function displayError($errNo, $errStr, $errFile, $errLine, $responce = 404) {
        
        // отправляем заголовок с кодом ошибки
        http_response_code($responce);
        
        // если страница не найдена а режим отладки отключен
        if($responce == 404 && !DEBUG) {
            require WWW .'/errors/404.php';     // то отправляем страничку 404
            die;
        }
        if(DEBUG) {
            require WWW .'/errors/dev.php';
        } else {
            require WWW .'/errors/prod.php';
        }
        die;
    }
}
