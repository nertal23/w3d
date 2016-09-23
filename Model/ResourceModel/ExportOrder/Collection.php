<?php
/**
 * Copyright © 2015 Amasty. All rights reserved.
 */

namespace W3D\ExportOrder\Model\ResourceModel\ExportOrder;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('W3D\ExportOrder\Model\ExportOrder', 'W3D\ExportOrder\Model\ResourceModel\ExportOrder');
    }
}
