<?php

namespace duncan3dc\Sessions;

use function array_map;

/**
 * Common session functionality.
 */
trait SessionTrait
{

    /**
     * This is a convenience method to prevent having to do several checks/set for all persistant variables.
     *
     * If the key name has been passed via POST then that value is stored in the session and returned.
     * If the key name has been passed via GET then that value is stored in the session and returned.
     * If there is already a value in the session data then that is returned.
     * If all else fails then the default value is returned.
     * All checks are truthy/falsy (so a POST value of "0" is ignored), unless the 3rd parameter is set to true.
     *
     * @param string $key The name of the key to retrieve from session data
     * @param mixed $default The value to use if the current session value is falsy
     * @param bool $strict Whether to do strict comparisons or not
     *
     * @return mixed
     */
    public function getSet($key, $default = null, $strict = false)
    {
        # If this key was just submitted via post then store it in the session data
        if (isset($_POST[$key])) {
            $value = $_POST[$key];
            if ($strict || $value) {
                $this->set($key, $value);
                return $value;
            }
        }

        # If this key is part of the get data then store it in session data
        if (isset($_GET[$key])) {
            $value = $_GET[$key];
            if ($strict || $value) {
                $this->set($key, $value);
                return $value;
            }
        }

        # Get the current value for this key from session data
        $value = $this->get($key);

        # If there is no current value for this key then set it to the supplied default
        if ($default !== null) {
            if (($strict && $value === null) || (!$strict && !$value)) {
                $value = $default;
                $this->set($key, $value);
            }
        }

        return $value;
    }


    /**
     * Unset a value within session data.
     *
     * @param string|array $data Either the name of the session key to update, or an array of keys to update
     *
     * @return static
     */
    public function delete(...$keys)
    {
        # Convert the array of keys to key/value pairs
        $keyValues = [];
        foreach ($keys as $key) {
            $keyValues[$key] = null;
        }

        return $this->set($keyValues);
    }


    /**
     * Clear all previously set values.
     *
     * @return static
     */
    public function clear()
    {
        # Get all the current session data
        $values = $this->getAll();

        # Replace all the values with nulls
        $values = array_map(function ($value) {
            return null;
        }, $values);

        # Store all the null values (effectively unsetting the keys)
        $this->set($values);

        return $this;
    }


    /**
     * Converts the passed session key into a flashed key.
     *
     * @param string $key The key to convert
     *
     * @return string
     */
    protected function flashKey($key)
    {
        return "_fs_{$key}";
    }


    /**
     * Retrieve a one-time value from the session data.
     *
     * @param string $key The name of the flash value to retrieve
     *
     * @return mixed
     */
    public function getFlash($key)
    {
        $key = $this->flashKey($key);

        $value = $this->get($key);

        $this->delete($key);

        return $value;
    }


    /**
     * Set a one-time value within session data.
     *
     * @param string $key The name of the flash value to update
     * @param mixed $value The value to store against the key
     *
     * @return static
     */
    public function setFlash($key, $value)
    {
        $key = $this->flashKey($key);

        return $this->set($key, $value);
    }
}
