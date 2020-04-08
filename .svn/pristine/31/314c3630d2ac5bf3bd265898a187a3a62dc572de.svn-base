<?php

class Fmo_JpegcamTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Fmo_Jpegcam
     */
    protected $jpegCam;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->jpegCam = new Fmo_Jpegcam();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }
    
    public function testRender()
    {
        $this->assertContains('<object', $this->jpegCam->render());
    }

}

?>
