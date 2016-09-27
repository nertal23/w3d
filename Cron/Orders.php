<?php
namespace W3D\Exportorders\Cron;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\ImportExport\Model\Export\Adapter\Csv;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class Orders {
 
    protected $_logger;
    protected $orderRepository;
    protected $searchCriteriaBuilder;
    protected $filterBuilder;
    protected $csv;
    protected $customerGroup;
    protected $customerRepository;
    protected $_resource;
    protected $_helper;
    protected $destination;
    protected $xml;
 
    public function __construct(\Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
         \W3D\Exportorders\Model\Export\Adapter\Csv $csv,
         \Magento\Customer\Api\GroupRepositoryInterface $customerGroup,
         \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
         \Magento\Framework\App\ResourceConnection $resource,
         \W3D\Exportorders\Helper\Data $helper,
         \Magento\Framework\Xml\Parser $xml
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->_logger = $logger;
        $this->csv = $csv;
        $this->customerGroup = $customerGroup;
        $this->customerRepository = $customerRepository;
        $this->_resource = $resource;
        $this->_helper = $helper;
        $this->destination = "/var/www/magento.w3development.net/public_html/var/".$this->_helper->getFolderPath();
        $this->xml = $xml;
    }
 
    public function execute() {

        
        $items = $this->getOrders();

        $format = $this->_helper->getFormat();
        $this->_logger->info("Format: ".$format);
        if($format == 'xml'){
            $this->writeToXML($items);
        }elseif ($format == 'db') {
            $this->writeToDB($items);
        }elseif ($format == 'csv'){
        	$this->writeToFile($items);
        }
        
        $this->_logger->info("Test Cron Message: ");
        
        return $this;     
    }

    public function getOrders()
    {
        $filters = [];
        $now = new \DateTime();
        $interval = new \DateInterval('P30D');
        $lastWeek = $now->sub($interval);
         
        $filters[] = $this->filterBuilder
            ->setField('created_at')
            ->setConditionType('gt')
            ->setValue($lastWeek->format('Y-m-d H:i:s'))
            ->create();
         
        $this->searchCriteriaBuilder->addFilter('created_at', $lastWeek->format('Y-m-d H:i:s'), 'gt');
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResults = $this->orderRepository->getList($searchCriteria);
        return $searchResults->getItems();
    }

    protected function convertToArray($items)
    {
    	$arrayItems = [];
    	if (count($items) > 0) {
    		foreach ($items as $item) {
    			$group = $this->customerGroup->getById($item->getCustomerGroupId());
                $code = $group->getCode();
    			$data = ['Created'=> time(), 'Modified'=> time(),'OrderID'=>$item->getIncrementId(), 'Date' => $item->getCreatedAt(), 'Firtsname' => $item->getCustomerFirstname(), 'Lastname' => $item->getCustomerLastname(), 'Customergroup' => $code, 'Street' => $item->getBillingAddress()->getStreetLine(1), 'City' => $item->getBillingAddress()->getCity(), 'Country' => $item->getBillingAddress()->getCountryId(), 'Zip' => $item->getBillingAddress()->getPostcode(), 'Payment Method' => $item->getPayment()->getMethodInstance()->getTitle(), 'Email'=> $item->getCustomerEmail(),  'Subtotal' => $item->getSubtotal(), 'Discount' => $item->getDiscountAmount(), 'Tax' => $item->getTaxAmount(), 'Grand Total' => $item->getGrandTotal()];
    			array_push($arrayItems, $data);
    		}
    	}
    	return $arrayItems;
    }

    protected function writeToFile($items)
    {
        if (count($items) > 0) {
            $this->csv->setHeaderCols(['OrderID', 'Date', 'Firtsname', 'Lastname',  'Customergroup', 'Street', 'City', 'Country', 'Zip', 'Payment Method', 'Email', 'Debitorennummer' , 'Subtotal', 'Discount',  'Tax', 'Grand Total']);
                foreach ($items as $item) {
                    
                    $group = $this->customerGroup->getById($item->getCustomerGroupId());
                    $code = $group->getCode();
                    
                    $this->csv->writeRow(['Created'=> time(), 'Modified'=> time(), 'OrderID'=>$item->getIncrementId(), 'Date' => $item->getCreatedAt(), 'Firtsname' => $item->getCustomerFirstname(), 'Lastname' => $item->getCustomerLastname(), 'Customergroup' => $code, 'Street' => $item->getBillingAddress()->getStreetLine(1), 'City' => $item->getBillingAddress()->getCity(), 'Country' => $item->getBillingAddress()->getCountryId(), 'Zip' => $item->getBillingAddress()->getPostcode(), 'Payment Method' => $item->getPayment()->getMethodInstance()->getTitle(), 'Email'=> $item->getCustomerEmail(),  'Subtotal' => $item->getSubtotal(), 'Discount' => $item->getDiscountAmount(), 'Tax' => $item->getTaxAmount(), 'Grand Total' => $item->getGrandTotal()]);
                }  
        }
        return count($items);
    }

    protected function writeToDB($items){
        $connection = $this->_resource->getConnection();
        $themeTable = $this->_resource->getTableName('order_export');
        foreach ($items as $item) {
            $group = $this->customerGroup->getById($item->getCustomerGroupId());
            $code = $group->getCode();
            
            $sql = "INSERT INTO " . $themeTable . "(created, modified, OrderID, Date, Firstname, Lastname, Customergroup, Street, City, Country, Zip, PaymentMethod, Email, Subtotal, Discount, Tax, GrandTotal) VALUES (CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, ".$item->getIncrementId().", '".$item->getCreatedAt()."', '".$item->getCustomerFirstname()."', '".$item->getCustomerLastname()."', '".$code."', '".$item->getBillingAddress()->getStreetLine(1)."', '".$item->getBillingAddress()->getCity()."', '".$item->getBillingAddress()->getCountryId()."', '".$item->getBillingAddress()->getPostcode()."', '".$item->getPayment()->getMethodInstance()->getTitle()."', '".$item->getCustomerEmail()."', ".$item->getSubtotal().", ".$item->getDiscountAmount().", ".$item->getTaxAmount().", ".$item->getGrandTotal().")";
            $connection->query($sql);
        }

        return count($items);
    }

    private function parse( $topNodeName, $data, $xml ){
        $node = $xml->createElement($topNodeName);
        
        if( is_array($data)){
            // Not escaped, loop through child nodes
            foreach( $data as $key=>$value ){        
            // Loop through numerically indexed nodes
                if( is_array($value) ){
                    foreach( $value as $key2=>$value2 ){
                        $node->appendChild( $this->parse( $key2, $value2, $xml ));
                    }
                }else{
                    // Only one node of its kind
                    $node->appendChild(parse("Table1", $value, $xml));
                }
            }
        }
        // If not an array, check for a text value to append
        else{
            $node->appendChild( $xml->createTextNode($data));
        }
    	return $node;
  	}

    protected function writeToXML($items)
    {
    	$destination = $this->destination;
        if (count($items) > 0) {
            $xml = new \DOMDocument('1.0', 'UTF-8');
            $xml->formatOutput = true;
            $root = $xml->createElement('dataroot');
            $root = $xml->appendChild($root);
            $root->setAttribute("xmlns:od", "urn:schemas-microsoft-com:officedata");
            $root->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
            $root->setAttribute("xsi:noNamespaceSchemaLocation", "Table1.xsd");

            $xml->save("/var/www/magento.w3development.net/public_html/var/tmp/test.xml");
    
            $i=0;
            foreach ($items as $item) {
                $group = $this->customerGroup->getById($item->getCustomerGroupId());
                $code = $group->getCode();
                $row[$i] = ['Created'=> time(), 'Modified'=> time(), 'OrderID'=>$item->getIncrementId(), 'Date' => $item->getCreatedAt(), 'Firtsname' => $item->getCustomerFirstname(), 'Lastname' => $item->getCustomerLastname(), 'Customergroup' => $code, 'Street' => $item->getBillingAddress()->getStreetLine(1), 'City' => $item->getBillingAddress()->getCity(), 'Country' => $item->getBillingAddress()->getCountryId(), 'Zip' => $item->getBillingAddress()->getPostcode(), 'PaymentMethod' => $item->getPayment()->getMethodInstance()->getTitle(), 'Email'=> $item->getCustomerEmail(),  'Subtotal' => $item->getSubtotal(), 'Discount' => $item->getDiscountAmount(), 'Tax' => $item->getTaxAmount(), 'GrandTotal' => $item->getGrandTotal()];
                $i++;
            } 
            
            $root->appendChild( $this->parse("Table1", $row, $xml));
        	$this->_logger->info($xml->saveXML());
        	$xml->save($destination);    
        }
        return $this->convertToArray($items);
    }
}
