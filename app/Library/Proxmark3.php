<?php

namespace App\Library;
use App\Library\Tags\Hid;
use App\Library\Tags\Io;
use App\Library\Tags\Em410x;
use App\Library\Tags\Unsupported;

class Proxmark3
{

    /**
     * Initializes a new Proxmark3 scanner instance.
     * @param string $port The port we will attempt to connect to.
     */
    public function __construct($port = '') {
        $this->port = $port;
        $this->connected = false;

        $this->connect($this->port);
    }

    /**
     * Converts the scanner instance into a JSON-formatted array.
     * @return array
     */
    public function toJson() {
        return get_object_vars($this);
    }

    /**
     * Attempt to connect to a Proxmark on the provided port.
     * @param  string $port Optionally provide the port to connect to.
     * @return boolean True if connected, otherwise false.
     */
    public function connect($port = '') {
        if (!empty($port)) {
            // Set the device port to connect to.
            $this->port = $port;
        }

        // Execute a command to test the connection.
        $command = $this->executeCommand('help');
        $this->connected = $command['success'];

        // If we don't see the response from the firmware, assume we aren't connnected.
        if (!stristr($command['result'], 'bootrom')) $this->connected = false;

        return $this->connected;
    }

    /**
     * Sends a command to the scanner.
     * @param string $command The command to run on the scanner.
     * @return array
     */
    public function executeCommand($command) {
        $response = ['success' => true, 'result' => ''];

        $response['result'] = shell_exec('proxmark3 ' . $this->port . ' -c "' . $command . '"');
        if (preg_match('/error: invalid serial port/im', $response['result'])) {
            $this->connected = false;
            $response['success'] = false;
        }

        return $response;
    }

    /**
     * Runs a low frequency scan for valid tags.
     * @return array An array of matches.
     */
    public function searchLowFrequency() {
        $results = [];

        $search = $this->executeCommand('lf search');
        abort_unless($this->connected, 500, 'Could not connect to the scanner. Is it plugged in?');

        $matches = [];
        preg_match('/valid (.*) found/im', $search["result"], $matches);
        if ($matches) {
            array_shift($matches);
            foreach ($matches as $match) {
                if ($match === 'T55xx Chip') continue;
                $results[] = $this->tagForMatch($match, $search["result"]);
            }
        }

        return $results;
    }

    public function searchHighFrequency() {

    }

    /**
     * Given a result from a search, return an instance of the appropriate tag.
     * @param  string $match The matched tag key.
     * @param  string $result The full-text from the search result.
     * @return Tag An instance of a tag.
     */
    public function clone($type, $identifier) {
        $response = ['success' => false, 'result' => 'There was an issue with the cloning process.'];
        $tag = null;

        switch($type) {
            case Hid::$key:
                $tag = new Hid($identifier);
                break;
            case Io::$key:
                $tag = new Io($identifier);
                break;
            case Em410x::$key:
                $tag = new Em410x($identifier);
                break;
            default:
                $tag = new Unsupported($identifier);
                break;
        }

        $clone = $tag->clone($this);
        if ($clone) {
            $response['success'] = true;
            $response['result'] = 'The clone command was issued successfully!';
        }

        return $response;
    }

    /**
     * Given a result from a search, return an instance of the appropriate tag.
     * @param  string $match The matched tag key.
     * @param  string $result The full-text from the search result.
     * @return Tag An instance of a tag.
     */
    public function tagForMatch($match, $result) {
        $tag = null;

        switch($match) {
            case Hid::$key:
                $tag = Hid::tagFromResult($result);
                break;
            case Io::$key:
                $tag = Io::tagFromResult($result);
                break;
            case Em410x::$key:
                $tag = Em410x::tagFromResult($result);
                break;
            default:
                $tag = Unsupported::tagFromResult($result);
                break;
        }

        return $tag;
    }

}
