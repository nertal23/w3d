<?php
/**
 * Copyright © 2015 Amasty. All rights reserved.
 */

namespace W3development\ExportOrder\Model\ResourceModel\ExportOrder;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('W3development\ExportOrder\Model\ExportOrder', 'W3development\ExportOrder\Model\ResourceModel\ExportOrder');
    }
}
