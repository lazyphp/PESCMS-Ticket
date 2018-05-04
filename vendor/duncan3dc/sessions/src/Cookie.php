<?php

namespace duncan3dc\Sessions;

class Cookie
{
    /**
     * @var int $lifetime The lifetime of the session cookie in seconds.
     */
    private $lifetime = 0;

    /**
     * @var string $path Path on the domain where the cookie will work.
     */
    private $path = "/";

    /**
     * @var string $domain The domain the cookie should be sent to.
     */
    private $domain = "";

    /**
     * @var bool $secure Only send over secure connections.
     */
    private $secure = false;

    /**
     * @var bool $httponly Use the HTTP only flag.
     */
    private $httponly = false;


    /**
     * Create a new instance from the current environment settings.
     *
     * @param string $name The name of the session
     */
    public static function createFromIni()
    {
        $params = session_get_cookie_params();

        return (new static)
            ->withLifetime($params["lifetime"])
            ->withPath($params["path"])
            ->withDomain($params["domain"])
            ->withSecure($params["secure"])
            ->withHttpOnly($params["httponly"]);
    }


    /**
     * Create a new instance with the specified lifetime.
     *
     * @param int $lifetime The lifetime of the session cookie in seconds.
     *
     * @return static
     */
    public function withLifetime($lifetime)
    {
        $cookie = clone $this;
        $cookie->lifetime = (int) $lifetime;
        return $cookie;
    }


    /**
     * Get the current lifetime in seconds.
     *
     * @return int The lifetime of the session cookie in seconds.
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }


    /**
     * Create a new instance with the path.
     *
     * @param string $path Path on the domain where the cookie will work.
     *
     * @return static
     */
    public function withPath($path)
    {
        $cookie = clone $this;
        $cookie->path = (string) $path;
        return $cookie;
    }


    /**
     * Get the current path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * Create a new instance with the domain.
     *
     * @param string $domain The domain the cookie should be sent to.
     *
     * @return static
     */
    public function withDomain($domain)
    {
        $cookie = clone $this;
        $cookie->domain = (string) $domain;
        return $cookie;
    }


    /**
     * Get the current domain.
     *
     * @param string
     */
    public function getDomain()
    {
        return $this->domain;
    }


    /**
     * Create a new instance with the secure flag.
     *
     * @param bool $secure Only send over secure connections.
     *
     * @return static
     */
    public function withSecure($secure)
    {
        $cookie = clone $this;
        $cookie->secure = (bool) $secure;
        return $cookie;
    }


    /**
     * Check if this cookie is secure or not.
     *
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure;
    }


    /**
     * Create a new instance with the HTTP only flag.
     *
     * @param bool $httponly Use the HTTP only flag.
     *
     * @return static
     */
    public function withHttpOnly($httponly)
    {
        $cookie = clone $this;
        $cookie->httponly = (bool) $httponly;
        return $cookie;
    }


    /**
     * Check if this cookie is HTTP only or not.
     *
     * @return bool
     */
    public function isHttpOnly()
    {
        return $this->httponly;
    }
}
