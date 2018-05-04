<?php

namespace duncan3dc\Sessions;

/**
 * A namespaced portion of the session data.
 */
class SessionNamespace implements SessionInterface
{
    use SessionTrait;

    /**
     * @var string $name The namespace of the session.
     */
    protected $name;

    /**
     * @var SessionInstance $session The underlying session instance.
     */
    protected $session;


    /**
     * Create a new namespaced portion of a session.
     *
     * @param string $name The namespace of the session
     * @param SessionInstance $session The session instance to use
     */
    public function __construct($name, SessionInstance $session)
    {
        $this->name = $name;
        $this->session = $session;
    }


    /**
     * Get the namespace prefix for keys.
     *
     * @return string
     */
    protected function getNamespace()
    {
        return "_ns_{$this->name}_";
    }


    /**
     * Converts the passed session key into a namespaced key.
     *
     * @param string $key The key to convert
     *
     * @return string
     */
    protected function getNamespacedKey($key)
    {
        return $this->getNamespace() . $key;
    }


    /**
     * Create a new namespaced section of this session to avoid clashes.
     *
     * @param string $name The namespace of the session
     *
     * @return SessionNamespace
     */
    public function createNamespace($name)
    {
        $name = $this->getNamespacedKey($name);
        return new SessionNamespace($name, $this->session);
    }


    /**
     * Get a value from the session data cache.
     *
     * @param string $key The name of the name to retrieve
     *
     * @return mixed
     */
    public function get($key)
    {
        $key = $this->getNamespacedKey($key);

        return $this->session->get($key);
    }


    /**
     * Get all the current session data.
     *
     * @return array
     */
    public function getAll()
    {
        $namespace = $this->getNamespace();
        $length = mb_strlen($namespace);

        $values = [];

        $data = $this->session->getAll();
        foreach ($data as $key => $val) {
            if (mb_substr($key, 0, $length) === $namespace) {
                $key = mb_substr($key, $length);
                $values[$key] = $val;
            }
        }

        return $values;
    }


    /**
     * Set a value within session data.
     *
     * @param string|array $data Either the name of the session key to update, or an array of keys to update
     * @param mixed $value If $data is a string then store this value in the session data
     *
     * @return static
     */
    public function set($data, $value = null)
    {
        if (is_array($data)) {
            $newData = [];
            foreach ($data as $key => $val) {
                $key = $this->getNamespacedKey($key);
                $newData[$key] = $val;
            }
            $data = $newData;
        } else {
            $data = $this->getNamespacedKey($data);
        }

        $this->session->set($data, $value);

        return $this;
    }


    /**
     * Tear down the session and wipe all it's data.
     *
     * @return static
     */
    public function clear()
    {
        $values = $this->getAll();

        if (count($values) > 0) {
            $this->delete(...array_keys($values));
        }

        return $this;
    }
}
