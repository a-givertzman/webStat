<?php

/*
 * v.001
 *
 * @author antonlobanov
 */

namespace ishop\libs;

/**
 * Класс Debuger | Выводит сообщения в лог-файл или на страничку
 */
class Debuger {
//    use \ishop\TSingleton;

    static $logFile = 'php.log';
    
    static $debug_backtrace_depth = 2;

    // контейнер для хранения параметров
//    protected static $properties = [];

    public static function log($data) {
        echo '<pre>';
        echo print_r($data, true);
        echo '</pre>';
    }


    // -------------------------------------------------------
    // Функция | Дописывает в конец файла лога данные из $data
    //
    public static function flog( $data = null ){
        // ob_start();                    // start buffer capture
        // var_dump( $object );           // dump the values
        // $contents = ob_get_contents(); // put the buffer into a variable
        // ob_end_clean();                // end capture
        // error_log( $contents );        // log contents of the result of var_dump( $object )

        // if (!is_writable($logFilePath)) {

            try {

                for($index = self::$debug_backtrace_depth - 1; $index >= 0; $index--) {
                    
                    $function = debug_backtrace()[$index]['function'];
                    
                    if ($index == self::$debug_backtrace_depth - 1) {

                        $caller = basename(debug_backtrace()[$index]['file']);

                        $caller .= isset($function) ? " -> " .$function : '';
                    } elseif ($index == 0) {
                        
                        // $caller .= " -> " .basename(debug_backtrace()[$index]['file']);
                    } else {
                        
                        $caller .= " -> " .basename(debug_backtrace()[$index]['file']);
                        
                        $caller .= isset($function) ? " -> " .$function : '';
                    }
                }

                if (!file_exists(LOGS .'/' .self::$logFile)) {
                    file_put_contents(LOGS .'/' .self::$logFile, "\n");
                }
                file_put_contents(LOGS .'/' .self::$logFile, "\n", FILE_APPEND);
                file_put_contents(LOGS .'/' .self::$logFile, date("[Y-m-d H:i:s]") ."\t[" .$caller ."]\t" .print_r($data, true), FILE_APPEND);

            } catch(Exception $e) {
                
                error_log(date("[Y-m-d H:i:s]") ."\t[" .basename(__FILE__) ."]\t" .$e->getMessage(), 0);
            }
        // }
    }



    // -------------------------------------------------------
    // Функция | очищает файл лога
    //
    public static function clear(){
        // ob_start();                    // start buffer capture
        // var_dump( $object );           // dump the values
        // $contents = ob_get_contents(); // put the buffer into a variable
        // ob_end_clean();                // end capture
        // error_log( $contents );        // log contents of the result of var_dump( $object )

        // if (!is_writable($logFilePath)) {

            try {

                file_put_contents(LOGS .'/' .self::$logFile, "");

                // установка временной зоны по умолчанию. Доступно с PHP 5.1
                // date_default_timezone_set('UTC');

                // выведет примерно следующее: Monday 8th of August 2005 03:12:46 PM
                self::flog( ' Файл очищен' );
                self::flog( date('l jS \of F Y h:i:s A') );
                self::flog( '' );

            } catch(Exception $e) {
                    
                error_log(date("[Y-m-d H:i:s]") ."\t" .$e->getMessage(), 0);
            }
        // }
    }
}