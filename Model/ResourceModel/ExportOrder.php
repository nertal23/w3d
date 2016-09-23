<?php
/**
 * Copyright © 2015 Amasty. All rights reserved.
 */

namespace W3D\ExportOrder\Model\ResourceModel;

class ExportOrder extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('order_export', 'id');
    }
}
