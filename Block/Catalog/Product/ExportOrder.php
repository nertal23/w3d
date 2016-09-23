<?php
/**
 * @author W3D Team
 * @copyright Copyright (c) 2016 W3D
 * @package W3D_ExportOrder
 */
namespace W3development\ExportOrder\Block\Catalog\Product;

class ExportOrder extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \W3D\ExportOrder\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = [],
        \W3development\ExportOrder\Helper\Data $helper,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        parent::__construct($context, $data);

        $this->_helper
            = $helper;
        $this->_objectManager = $objectManager;
    }

    public function getCronLabel(){
        return $this->_helper->getCronLabel();
    }

    public function getFolderPath(){
        return $this->_helper->getFolderPath();
    }

    public function getFormat(){
        $this->_helper->getFormat();
    }

    protected function _toHtml()
    {
       if ($this->_helper->getFormat()){
            return parent::_toHtml();
       }
        else {
            return '';
        }
    }

    public function getCollection()
    {
        $model = $this->_objectManager->create('W3development\ExportOrder\Model\ExportOrder');
        $collection = $model->getCollection();

        return $collection;
    }

}
