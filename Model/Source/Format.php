<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2015 Amasty (http://www.amasty.com)
 * @package W3D_ExportOrder
 */
namespace W3development\ExportOrder\Model\Source;

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
