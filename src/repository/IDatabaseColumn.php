<?php namespace c2dl\sys\db;

/*
 * Database column interface
 */
interface IDatabaseColumn {
    /*
     * Create Column
     * @param string|null $name Column Name
     * @param int|null $type PDO type
     * @param DatabaseColumnConstraints[]|null $constraints Constraints
     */
    static public function create($name = null, $type = null, $constraints = null);

    /*
     * Constructor
     * @param string|null $name Column Name
     * @param int|null $type PDO type
     * @param DatabaseColumnConstraints[]|null $constraints Constraints
     */
    public function __construct($name = null, $type = null, $constraints = null);

    /*
     * Get Name
     * @return string|null Column Name
     */
    public function name(): ?string;

    /*
     * Get PDO type
     * @return int|null PDO type
     */
    public function type(): ?int;

    /*
     * Get Constraints
     * @return DatabaseColumnConstraints[]|null Constraints
     */
    public function constraints(): ?iterable;

    /*
     * Set Name
     * @param string $name Column Name
     */
    public function setName($name);

    /*
     * Set PDO type
     * @param int $type PDO type
     */
    public function setType($type);

    /*
     * Set Constraints
     * @param DatabaseColumnConstraints[] $constraints Constraints
     */
    public function setConstraints($constraints);
}
