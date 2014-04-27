<?php
/**
 * Exception Interface and extendable class
 *
 * @credit to ask at nilpo dot com - http://www.php.net/manual/en/language.exceptions.php
 */

namespace \Jwx\Exception;

abstract class CustomException extends Exception implements ExceptionInterface
{
    protected $message = 'Unknown exception';     // Exception message
    private   $string;                            // Unknown
    protected $code = 0;                       	 // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown

    public function __construct($message=false, $code=0){
        if(!$message){
            throw new $this('Unknown '. get_class($this));
        }

        parent::__construct($message, $code);
    }

    public function __toString(){
        return get_class($this) . " :[{$this->code}]: '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }
}