<?php
/**
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

namespace Magento\Core\Utility;

class LayoutTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Core\Utility\Layout
     */
    protected $_utility;

    protected function setUp()
    {
        $this->_utility = new \Magento\Core\Utility\Layout($this);
    }

    /**
     * Assert that the actual layout update instance represents the expected layout update file
     *
     * @param \Magento\Core\Model\Layout\Merge $actualUpdate
     * @param string $expectedUpdateFile
     * @param \Magento\Core\Model\Layout\Merge $actualUpdate
     */
    protected function _assertLayoutUpdate($expectedUpdateFile, $actualUpdate)
    {
        $this->assertInstanceOf('Magento\Core\Model\Layout\Merge', $actualUpdate);

        $layoutUpdateXml = $actualUpdate->getFileLayoutUpdatesXml();
        $this->assertInstanceOf('Magento\Core\Model\Layout\Element', $layoutUpdateXml);
        $this->assertXmlStringEqualsXmlFile($expectedUpdateFile, $layoutUpdateXml->asNiceXml());
    }

    /**
     * @dataProvider getLayoutFromFixtureDataProvider
     * @param string|array $inputFiles
     * @param string $expectedFile
     */
    public function testGetLayoutUpdateFromFixture($inputFiles, $expectedFile)
    {
        $layoutUpdate = $this->_utility->getLayoutUpdateFromFixture($inputFiles);
        $this->_assertLayoutUpdate($expectedFile, $layoutUpdate);
    }

    /**
     * @dataProvider getLayoutFromFixtureDataProvider
     * @param string|array $inputFiles
     * @param string $expectedFile
     */
    public function testGetLayoutFromFixture($inputFiles, $expectedFile)
    {
        $layout = $this->_utility->getLayoutFromFixture($inputFiles, $this->_utility->getLayoutDependencies());
        $this->assertInstanceOf('Magento\Core\Model\Layout', $layout);
        $this->_assertLayoutUpdate($expectedFile, $layout->getUpdate());
    }

    public function getLayoutFromFixtureDataProvider()
    {
        return array(
            'single fixture file' => array(
                __DIR__ . '/_files/layout/handle_two.xml', __DIR__ . '/_files/layout_merged/single_handle.xml'
            ),
            'multiple fixture files' => array(
                glob(__DIR__ . '/_files/layout/*.xml'), __DIR__ . '/_files/layout_merged/multiple_handles.xml'
            ),
        );
    }
}
