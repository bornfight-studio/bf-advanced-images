<?php

namespace bornfight\wpHelpers;

class FlexibleLayoutRenderer
{
    private $base_path = '';

    /**
     * FlexibleLayoutRenderer constructor.
     *
     * @param string $base_path
     */
    public function __construct($base_path)
    {
        $this->base_path = $base_path;
    }

    public function render($data)
    {
        $index = 0;
        foreach ($data as $layout) {
            get_partial(
                $this->get_partial_path($layout['acf_fc_layout']),
                array_merge(
                    $layout,
                    [
                        'index' => $index,
                        'section' => $layout
                    ]
                )
            );
        }
    }

    private function get_partial_path($partial_name)
    {
        return $this->base_path . DIRECTORY_SEPARATOR . $partial_name;
    }
}
