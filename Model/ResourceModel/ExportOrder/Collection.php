<?php
/**
 * Copyright © 2015 W3D. All rights reserved.
 */

namespace W3D\Exportorders\Model\ResourceModel\ExportOrder;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('W3D\Exportorders\Model\ExportOrder', 'W3D\Exportorders\Model\ResourceModel\ExportOrder');
    }
}
