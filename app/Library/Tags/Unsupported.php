<?php

namespace App\Library\Tags;
use App\Library\Proxmark3;

class Unsupported
{
    /**
     * The user-friendly tag key that is parsable from the scanner.
     * @var string
     */
    public static $key = 'Unsupported ID';

    /**
     * Determines if this type of tag is cloneable.
     * @var boolean
     */
    public $cloneable = false;

    /**
     * Initializes a new tag instance.
     * @param string $identifier The identifier of the tag.
     */
    public function __construct($identifier) {
        $this->identifier = $identifier;
        $this->type = self::$key;
    }

    /**
     * Issues a clone command for the current tag.
     * @return boolean True if the clone command was received successfully, false otherwise.
     */
    public function clone(Proxmark3 $scanner) {
        return false;
    }

    /**
     * Given the result of a search command, this returns a valid tag instance.
     * @param  string $result Result from search command.
     * @return self A tag instance.
     */
    public static function tagFromResult($result) {
        return new self($result);
    }

}