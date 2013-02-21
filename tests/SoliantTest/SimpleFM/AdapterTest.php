<?php
/**
 * This source file is subject to the MIT license that is bundled with this package in the file LICENSE.txt.
 *
 * @package   Soliant\SimpleFM
 * @copyright Copyright (c) 2007-2013 Soliant Consulting, Inc. (http://www.soliantconsulting.com)
 * @author    jsmall@soliantconsulting.com
 */

namespace SoliantTest\SimpleFM;

use Soliant\SimpleFM\Adapter;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-16 at 22:32:15.
 */
class AdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Adapter
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    	$params=array('hostname'=>'127.0.0.1','dbname'=>'testdb','username'=>'root','password'=>'soliant');
        
        $this->object = new Adapter($params);
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setHostParams
     * @todo   Implement testSetHostParams().
     */
    public function testSetHostParams()
    {
        $params=array('hostname'=>'127.0.0.1','dbname'=>'testdb','username'=>'root','password'=>'soliant');
        
        $value = $this->object->setHostParams($params);
        $this->assertTrue($value instanceof $this->object);
        //echo "<pre>";
        //var_dump($this->object);
        //die;
        $this->assertEquals($this->object->getHostname(),'127.0.0.1');
       
        //$this->assertEquals($this->object->gethHostParams(),$params);
              
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setCredentials
     * @todo   Implement testSetCredentials().
     */
    public function testSetCredentials()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setCallParams
     * @todo   Implement testSetCallParams().
     */
    public function testSetCallParams()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getHostname
     * @todo   Implement testGetHostname().
     */
    public function testGetHostname()
    {      	
        $test = $this->object->setHostname('127.0.0.1');
        $this->assertTrue($test instanceof $this->object);
        $this->assertEquals($this->object->getHostname(),'127.0.0.1');
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setHostname
     * @todo   Implement testSetHostname().
     */
    public function testSetHostname()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getUsername
     * @todo   Implement testGetUsername().
     */
    public function testGetUsername()
    {   
    	
    	$test=$this->object->setUsername('root');
    	$this->assertTrue($test instanceof $this->object);
        $this->assertEquals($this->object->getUsername(),'root');   
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setUsername
     * @todo   Implement testSetUsername().
     */
    public function testSetUsername()
    {
    	//$test = $this->object->setUsername('unittest');
    	//$this->assertTrue($test instanceof $this->object);    	
    	//assert $this->object->setUserName('unittest') is type Adapter;
    	//assert $this->object->getUserName() == 'unittest';          
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setPassword
     * @todo   Implement testSetPassword().
     */
    public function testSetPassword()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getDbname
     * @todo   Implement testGetDbname().
     */
    public function testGetDbname()
    {
        $test = $this->object->setDbname('test');
        $this->assertTrue($test instanceof $this->object);
        $this->assertEquals($this->object->getDbname(),'test'); 
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setDbname
     * @todo   Implement testSetDbname().
     */
    public function testSetDbname()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getLayoutname
     * @todo   Implement testGetLayoutname().
     */
    public function testGetLayoutname()
    {
        $test = $this->object->setLayoutname('tab');
        $this->assertTrue($test instanceof $this->object);
        $this->assertEquals($this->object->getLayoutname(),'tab'); 
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setLayoutname
     * @todo   Implement testSetLayoutname().
     */
    public function testSetLayoutname()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getCommandstring
     * @todo   Implement testGetCommandstring().
     */
    public function testGetCommandstring()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getCommandarray
     * @todo   Implement testGetCommandarray().
     */
    public function testGetCommandarray()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setCommandstring
     * @todo   Implement testSetCommandstring().
     */
    public function testSetCommandstring()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setCommandarray
     * @todo   Implement testSetCommandarray().
     */
    public function testSetCommandarray()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getProtocol
     * @todo   Implement testGetProtocol().
     */
    public function testGetProtocol()
    {
         $value = $this->object->setProtocol('https');
         $this->assertTrue($value instanceof $this->object);
         $this->assertEquals($this->object->getProtocol(),'https'); 
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setProtocol
     * @todo   Implement testSetProtocol().
     */
    public function testSetProtocol()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getPort
     * @todo   Implement testGetPort().
     */
    public function testGetPort()
    {
        $value=$this->object->setPort('8080');
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getPort(),'8080'); 
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setPort
     * @todo   Implement testSetPort().
     */
    public function testSetPort()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getFmresultsetUri
     * @todo   Implement testGetFmresultsetUri().
     */
    public function testGetFmresultsetUri()
    {
       
        $value = $this->object->setFmresultsetUri('./abc/fmresult.xml');
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getFmresultsetUri(),'./abc/fmresult.xml'); 
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setFmresultsetUri
     * @todo   Implement testSetFmresultsetUri().
     */
    public function testSetFmresultsetUri()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getFmpxmllayoutUri
     * @todo   Implement testGetFmpxmllayoutUri().
     */
    public function testGetFmpxmllayoutUri()
    {
        $value = $this->object->setFmpxmllayoutUri('./abc/fmlayout.xml');
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getFmpxmllayoutUri(),'./abc/fmlayout.xml'); 
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setFmpxmllayoutUri
     * @todo   Implement testSetFmpxmllayoutUri().
     */
    public function testSetFmpxmllayoutUri()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::getRowsbyrecid
     * @todo   Implement testGetRowsbyrecid().
     */
    public function testGetRowsbyrecid()
    {
        $value = $this->object->setRowsbyrecid('1876612984689092');
        $this->assertTrue($value instanceof $this->object);
        $this->assertEquals($this->object->getRowsbyrecid(),'1876612984689092'); 
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::setRowsbyrecid
     * @todo   Implement testSetRowsbyrecid().
     */
    public function testSetRowsbyrecid()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::execute
     * @todo   Implement testExecute().
     */
    public function testExecute()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::displayXmlError
     * @todo   Implement testDisplayXmlError().
     */
    public function testDisplayXmlError()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::extractErrorFromPhpMessage
     * @todo   Implement testExtractErrorFromPhpMessage().
     */
    public function testExtractErrorFromPhpMessage()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Soliant\SimpleFM\Adapter::errorToEnglish
     * @todo   Implement testErrorToEnglish().
     */
    public function testErrorToEnglish()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
        
    }
}
