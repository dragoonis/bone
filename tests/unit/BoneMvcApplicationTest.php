<?php


use Bone\Mvc\Application;
use BoneMvc\Module\App\AppPackage;
use BoneMvc\Module\BoneMvcDoctrine\BoneMvcDoctrinePackage;
use BoneMvc\Module\BoneMvcUser\BoneMvcUserPackage;
use BoneTest\TestPackage\TestPackagePackage;
use Codeception\TestCase\Test;
use Zend\Diactoros\Response;

class BoneMvcApplicationTest extends Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var Response */
    protected $response;

    protected function _before()
    {
        $this->response = new Response();
        $this->response->getBody()->write('All hands on deck!');
    }

    /**
     *
     */
    public function testCanGetInstance()
    {
        $app = Application::ahoy();
        $this->assertInstanceOf(Application::class, $app);
    }

    /**
     * @throws Exception
     */
    public function testCanSetSail()
    {
        global $_SERVER;
        $application = Application::ahoy();
        $application->setConfigFolder('tests/_data/config');
        $_SERVER = [
            'REQUEST_URI' => '/testpackage'
        ];
        ob_start();
        $this->assertTrue($application->setSail());
        $contents = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('<!DOCTYPE html><html lang="en"><head></head><body><h1>Template</h1><h3>Content Below</h3><h1>TestPackage</h1><p class="lead">Lorem ipsum dolor sit amet</p></body></html>', $contents);
    }
}


