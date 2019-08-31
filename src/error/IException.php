<?php namespace c2dl\sys\err;

/*
 * Exception Interface
 */
interface IException
{
    // Exception Functions
    public function getMessage();
    public function getCode();
    public function getFile();
    public function getLine();
    public function getTrace();
    public function getTraceAsString();

    /*
     * Error String
     * @return Error String
     */
    public function __toString();
}
