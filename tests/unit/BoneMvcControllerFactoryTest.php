<?php

use Bone\Mvc\ControllerFactory;
use Codeception\Util\Stub;
use AspectMock\Test;


class BoneMvcControllerFactoryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $request;

    protected function _before()
    {
        $this->request = Stub::make('\Zend\Diactoros\ServerRequest');
    }

    protected function _after()
    {
        Test::clean();
    }

    // test object can be created 
    public function testCreateController()
    {
        Test::double('\Twig_Loader_Filesystem');
        Test::double('\Twig_Environment');
        Test::double('\Twig_Extension_Debug');
        Test::double('\Bone\Mvc\Controller',array('setTwig' => null));

        $factory = new ControllerFactory();
        $controller = $factory->create('\Bone\Mvc\Controller',$this->request);
        $this->assertInstanceOf('\Bone\Mvc\Controller',$controller);
    }

    // test throws a feckin' wobbly
    public function testThrowsException()
    {

        $factory = new ControllerFactory();
        $this->expectException('Exception');
        $factory->create('\Some\Inferior\Controller',$this->request);
    }
}