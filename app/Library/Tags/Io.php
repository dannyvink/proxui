<?php

namespace App\Library\Tags;
use App\Library\Proxmark3;

class Io
{
    /**
     * The user-friendly tag key that is parsable from the scanner.
     * @var string
     */
    public static $key = 'IO Prox ID';

    /**
     * Determines if this type of tag is cloneable.
     * @var boolean
     */
    public $cloneable = true;

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
        $command = $scanner->executeCommand("lf io clone " . $this->identifier);

        if ($command["success"] && preg_match('/cloning ioprox tag with id/im', $command['result'])) {
            return true;
        }

        return false;
    }

    /**
     * Given the result of a search command, this returns a valid tag instance.
     * @param  string $result Result from search command.
     * @return self A tag instance.
     */
    public static function tagFromResult($result) {
        $matches = [];
        preg_match('/io prox (?:.+) \((\w+)\)/i', $result, $matches);
        if ($matches) {
            array_shift($matches);
            return new self($matches[0]);
        }

        return null;
    }

}