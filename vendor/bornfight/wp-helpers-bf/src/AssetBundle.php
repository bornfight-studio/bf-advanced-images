<?php

namespace bornfight\wpHelpers;

class AssetBundle
{
    protected static $include_base_path = '/static/';

    public $js = [];
    public $css = [];

    public $async_css = false;

    public function get_base_path()
    {
        return INCLUDE_URL . self::$include_base_path;
    }

    public static function register()
    {
        $bundle = new static();
        $bundle->enqueue_scripts();
        $bundle->enqueue_styles();
    }

    protected function enqueue_scripts()
    {
        foreach ($this->js as $handle => $data) {
            if (isset($data['path']) === false) {
                throw new \Exception('Missing path definition for ' . $handle);
            }

            $path = $data['path'];
            $version = isset($data['version']) ? $data['version'] : 1.0;
            $in_footer = isset($data['in_footer']) ? $data['in_footer'] : true;

            wp_enqueue_script($handle, $this->get_base_path() . $path, [], $version, $in_footer);
        }
    }

    protected function enqueue_styles()
    {
        if ($this->async_css) {
            add_action('wp_head', function () {
                ?>
                <script>
                    function loadCSS(e, n, o, t) {
                        "use strict";
                        var d = window.document.createElement("link"), i = n || window.document.getElementsByTagName("script")[0], r = window.document.styleSheets;
                        return d.rel = "stylesheet", d.href = e, d.media = "only x", t && (d.onload = t), i.parentNode.insertBefore(d, i), d.onloadcssdefined = function (e) {
                            for (var n, o = 0; o < r.length; o++)r[o].href && r[o].href === d.href && (n = !0);
                            n ? e() : setTimeout(function () {
                                d.onloadcssdefined(e)
                            })
                        }, d.onloadcssdefined(function () {
                            d.media = o || "all"
                        }), d
                    }
                    // CSS DEV
                    <?php foreach ($this->css as $handle => $data) { ?>
                        loadCSS("<?= $this->get_base_path() . $data['path']; ?>");
                    <?php } ?>
                </script>
                <noscript>
                    <!-- CSS DEV -->
                    <?php foreach ($this->css as $handle => $data) { ?>
                        <link rel="stylesheet" href="<?= $this->get_base_path() . $data['path']; ?>">
                    <?php } ?>
                </noscript>
                <?php
            });
        } else {
            foreach ($this->css as $handle => $data) {
                if (isset($data['path']) === false) {
                    throw new \Exception('Missing path definition for ' . $handle);
                }

                $path = $data['path'];
                $version = isset($data['version']) ? $data['version'] : 1.0;
                $in_footer = isset($data['in_footer']) ? $data['in_footer'] : true;

                wp_enqueue_style($handle, $this->get_base_path() . $path, [], $version, $in_footer);
            }
        }
    }
}