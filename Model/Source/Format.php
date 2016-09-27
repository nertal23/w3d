<?php
/**
 * @author W3D Team
 * @copyright Copyright (c) 2015 W3D (http://w3development.net)
 * @package W3D_Exportorders
 */
namespace W3D\Exportorders\Model\Source;

class Format implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'xml',
                'label' => __('XML')
            ),
            array(
                'value' => 'csv',
                'label' => __('CSV')
            ),
            array(
                'value' => 'db',
                'label' => __('Write to DB')
            )
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return ['xml' => __('XML'),
                'csv' => __('CSV'),
                'db' => __('Write to DB')
        ];
    }
}
