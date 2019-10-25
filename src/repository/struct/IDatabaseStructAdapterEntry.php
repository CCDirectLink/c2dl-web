<?php namespace c2dl\sys\db\struct;

/*
 * Database Struct Adapter (entry) interface
 */
interface IDatabaseStructAdapterEntry {

    public function classString(): string;

    public function functionName(): string;

    public function setClassString($classString);

    public function setFunctionName($functionName);

    public function call(...$parameter);

}
