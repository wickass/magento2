<?php
/**
 * Resources configuration filesystem loader
 *
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Magento\Core\Model\Resource\Config;

class Reader extends \Magento\Config\Reader\Filesystem
{
    /**
     * List of id attributes for merge
     *
     * @var array
     */
    protected $_idAttributes = array(
        '/config/resource' => 'name'
    );

    /**
     * @var \Magento\Core\Model\Config\Local
     */
    protected $_configLocal;

    /**
     * @param \Magento\Config\FileResolverInterface $fileResolver
     * @param \Magento\Core\Model\Resource\Config\Converter $converter
     * @param \Magento\Core\Model\Resource\Config\SchemaLocator $schemaLocator
     * @param \Magento\Config\ValidationStateInterface $validationState
     * @param \Magento\Core\Model\Config\Local $configLocal
     * @param string $fileName
     */
    public function __construct(
        \Magento\Config\FileResolverInterface $fileResolver,
        \Magento\Core\Model\Resource\Config\Converter $converter,
        \Magento\Core\Model\Resource\Config\SchemaLocator $schemaLocator,
        \Magento\Config\ValidationStateInterface $validationState,
        \Magento\Core\Model\Config\Local $configLocal,
        $fileName = 'resources.xml'
    ) {
        $this->_configLocal = $configLocal;
        parent::__construct($fileResolver, $converter, $schemaLocator, $validationState, $fileName);
    }

    /**
     * Load configuration scope
     *
     * @param string|null $scope
     * @return array
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function read($scope = null)
    {
        $data = parent::read();
        $data = array_replace($data, $this->_configLocal->getResources());

        return $data;
    }
}
