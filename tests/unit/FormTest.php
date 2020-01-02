<?php


use Bone\Mvc\Application;
use BoneMvc\Module\App\AppPackage;
use BoneMvc\Module\BoneMvcDoctrine\BoneMvcDoctrinePackage;
use BoneMvc\Module\BoneMvcUser\BoneMvcUserPackage;
use BoneTest\TestPackage\TestPackagePackage;
use Codeception\TestCase\Test;
use Zend\Diactoros\Response;

class FormTest extends Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testForm()
    {
        $translator = $this->getMockBuilder(\Zend\I18n\Translator\Translator::class)->getMock();
        $form = new \Bone\Form('testform', $translator);
        $form->init();
        $this->assertInstanceOf(\Zend\I18n\Translator\Translator::class, $form->getTranslator());
    }
}

