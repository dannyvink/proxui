<?php

namespace App\Library;

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
        abort_unless($this->connected, 500, 'Failed to establish a connection to the scanner!');

        $matches = [];
        preg_match('/valid (.*) found/im', $search["result"], $matches);
        if ($matches) {
            array_shift($matches);
            foreach ($matches as $match) {
                if ($match === 'T55xx Chip') continue;
                $results[] = $match;
            }
        }

        return $results;
    }

    public function searchHighFrequency() {

    }

}
