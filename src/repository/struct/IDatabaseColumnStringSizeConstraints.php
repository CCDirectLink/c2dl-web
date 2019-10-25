<?php namespace c2dl\sys\db\struct;

/*
 * Column Size Constraints Interface
 */
interface IDatabaseColumnStringSizeConstraints {
    /*
     * Create Constraints
     * @param int|null $min Minimum Constraints
     * @param int|null $max Maximum Constraints
     */
    static public function create($min = null, $max = null);

    /*
     * Constructor
     * @param int|null $min Minimum Constraints
     * @param int|null $max Maximum Constraints
     */
    public function __construct($min = null, $max = null);

    /*
     * get min Constraints
     * @return int|null Minimum Constraints
     */
    public function min(): ?int;

    /*
     * get max Constraints
     * @return int|null Maximum Constraints
     */
    public function max(): ?int;

    /*
     * set min Constraints
     * @param int $min Minimum Constraints
     */
    public function setMin($min);

    /*
     * set max Constraints
     * @param int $max Maximum Constraints
     */
    public function setMax($max);

    /*
     * Validate string
     * @param string $data String data
     * @return bool True if valid
     */
    public function validate($data): bool;
}
