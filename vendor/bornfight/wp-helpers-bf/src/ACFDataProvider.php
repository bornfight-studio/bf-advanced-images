<?php

namespace bornfight\wpHelpers;

/**
 * Class ACFDataProvider
 * @package app\helpers
 */
class ACFDataProvider
{
    /**
     *
     */
    const OPTION = 'option';
    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @var string
     */
    private $prefix = '';

    /**
     * @var array
     */
    private $fields = [];

    /**
     * DataProvider constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return ACFDataProvider|null
     */
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new ACFDataProvider();
        }

        return self::$instance;
    }


    /**
     * @param $name
     * @param bool $prefixed
     * @return bool|mixed|null
     */
    public function get_option_field($name, $prefixed = true)
    {
        return $this->get_field($name, self::OPTION, $prefixed);
    }

    /**
     * @param $name
     * @param bool $post_id
     * @param bool $prefixed
     *
     * @return bool|mixed|null
     */
    public function get_field($name, $post_id = false, $prefixed = true)
    {
        $post_id = $post_id !== false ? $post_id : get_the_ID();
        $key = ($prefixed ? $this->prefix : '' ) . $name;

        $cache_key = 'field_' . $key . '_' . $post_id;
        $fields_cache_key = 'fields_' . $post_id;

        if (isset($this->fields[$cache_key])) {
            return $this->fields[$cache_key];
        } elseif (isset($this->fields[$fields_cache_key]) && isset($this->fields[$fields_cache_key][$key])) {
            return $this->fields[$fields_cache_key][$key];
        }

        $this->fields[$cache_key] = get_field($key, $post_id);
        return $this->fields[$cache_key];
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function set_prefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return $this
     */
    public function clear_prefix()
    {
        $this->prefix = '';
        return $this;
    }

    /**
     * @param bool $post_id
     *
     * @return array|bool
     */
    public function get_fields($post_id = false)
    {
        $post_id = $post_id !== false ? $post_id : get_the_ID();
        $key = 'fields_' . $post_id;
        if (isset($this->fields[$key])) {
            return $this->fields[$key];
        }
        $this->fields[$key] = get_fields($post_id);

        return $this->fields[$key];
    }

    public function get_user_field($name, $user_id = null, $prefixed = true)
    {
        if ($user_id === null && is_single()) {
            $user_id = get_the_author_meta('ID');
        }

        if ($user_id) {
            return $this->get_field($name, 'user_' . $user_id, $prefixed);
        }

        return '';
    }
}
