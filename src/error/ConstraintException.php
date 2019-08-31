<?php namespace c2dl\sys\err;

require_once( getenv('C2DL_SYS', true) . '/error/IException.php');

use \Exception;

/*
 * Update Exception
 */
class ConstraintException extends Exception implements IException
{

    protected $message = 'Unknown exception';
    private $string;
    protected $code = 0;
    protected $file;
    protected $line;
    private $trace;
    private $errorBy;

    /*
     * Create UpdateResultException
     * @param string $message Error Message
     * @param int|null $code Error code
     * @param string|null $errorWithData Data element that is invalid
     */
    static public function create($message = null, $code = 0, $errorBy = null)
    {
        return new self($message, $code, $errorBy);
    }

    /*
     * Constructor
     * @param string $message Error Message
     * @param int|null $code Error code
     * @param string|null $errorBy Data element that is invalid
     */
    public function __construct($message = null, $code = 0, $errorBy = null)
    {
        $this->errorBy = null;

        if ((isset($errorBy)) && (is_string($errorBy))) {
            $this->errorBy = $errorBy;
        }

        parent::__construct($message, $code);
    }

    /*
     * Get element that is invalid
     * @return string|null Data element that is invalid
     */
    public function getErrorBy(): ?string
    {
        return $this->errorBy;
    }

    /*
     * Error String
     * @return Error String
     */
    public function __toString(): string
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
            . "{$this->getTraceAsString()}";
    }
}
