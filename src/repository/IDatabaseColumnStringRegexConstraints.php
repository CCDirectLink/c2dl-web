<?php namespace c2dl\sys\db;

/*
 * Column Regex Constraints Interface
 */
interface IDatabaseColumnStringRegexConstraints {
    /*
     * Create Constraints
     * @param string|null $pattern Pattern
     */
    static public function create($pattern = null);

    /*
     * Constructor
     * @param string|null $pattern Pattern
     */
    public function __construct($pattern = null);

    /*
     * Get Pattern
     * @return string|null Pattern
     */
    public function pattern(): ?string;

    /*
     * set Pattern
     * @param string $pattern String pattern
     */
    public function setPattern($pattern);

    /*
     * Validate string
     * @param string $data String data#
     * @return bool True if valid
     */
    public function validate($data): bool;
}
