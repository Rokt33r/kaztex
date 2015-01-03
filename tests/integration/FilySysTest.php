<?php


class FilySysTest extends \Codeception\TestCase\Test
{
    /**
     * @var \IntegrationTester
     */
    protected $tester, $fileSys;

    protected function _before()
    {
        $this->fileSys = App::make('Kaztex\Files\FileSys');
        if(!\GrahamCampbell\Flysystem\Facades\Flysystem::has('some/where/some.file')){
            \GrahamCampbell\Flysystem\Facades\Flysystem::write('some/where/some.file', 'hello');
        }
    }

    protected function _after()
    {
        if(\GrahamCampbell\Flysystem\Facades\Flysystem::has('some/where/some.file')) {
            \GrahamCampbell\Flysystem\Facades\Flysystem::delete('some/where/some.file');
        }
    }

    /** @test */
    public function it_should_return_information_of_a_file()
    {
        $fileInfo = $this->fileSys->ls('some/where/some.file');

        $this->assertArrayHasKey('basename',$fileInfo, 'the file info should have a basename key');
        $this->assertEquals('some.file',$fileInfo['basename'], 'the basename of the file should be like "filename.extension"');
        $this->assertArrayHasKey('path', $fileInfo, 'the file info should have a path key');
        $this->assertEquals('some/where/some.file',$fileInfo['path'], 'the path of the file should be its a its full path');

        $this->assertArrayHasKey('type', $fileInfo, 'the file info should have a type key');
        $this->assertEquals('file',$fileInfo['type'], 'the type of the file should be "file"');

        $this->assertArrayHasKey('size', $fileInfo, 'the file info should have a size key');
        $this->assertEquals(5,$fileInfo['size'], 'the size of the file should be 5, length of the string, "hello"');

        $this->assertArrayHasKey('timestamp', $fileInfo, 'the file info should have a timestamp');
        $this->assertFalse($fileInfo['timestamp'] < strtotime('-30 years') || $fileInfo['timestamp'] > strtotime('+30 years'), 'the timestamp should be a valid timestamp');

    }


    /** @test */
    public function it_should_return_information_of_a_directory()
    {

        $dirInfo = $this->fileSys->ls('some');

        $this->assertArrayHasKey('basename',$dirInfo, 'the dir info should have a basename key');
        $this->assertEquals('some',$dirInfo['basename'], 'the basename of the dir should be like "dirname"');
        $this->assertArrayHasKey('path', $dirInfo, 'the dir info should have a path key');
        $this->assertEquals('some',$dirInfo['path'], 'the path of the dir should be its a its full path');

        $this->assertArrayHasKey('type', $dirInfo, 'the dir info should have a type key');
        $this->assertEquals('dir',$dirInfo['type'], 'the type of the dir should be "dir"');


        $this->assertTrue(is_array($dirInfo['sub_files'][0]['sub_files']), 'the file info should have a array for its sub files');

        $this->assertArrayHasKey('basename',$dirInfo['sub_files'][0]['sub_files'][0], 'the file info should have a basename key');
        $this->assertEquals('some.file',$dirInfo['sub_files'][0]['sub_files'][0]['basename'], 'the basename of the file should be like "filename.extension"');
        $this->assertArrayHasKey('path', $dirInfo['sub_files'][0]['sub_files'][0], 'the file info should have a path key');
        $this->assertEquals('some/where/some.file',$dirInfo['sub_files'][0]['sub_files'][0]['path'], 'the path of the file should be its a its full path');

        $this->assertArrayHasKey('type', $dirInfo['sub_files'][0]['sub_files'][0], 'the file info should have a type key');
        $this->assertEquals('file',$dirInfo['sub_files'][0]['sub_files'][0]['type'], 'the type of the file should be "file"');

        $this->assertArrayHasKey('size', $dirInfo['sub_files'][0]['sub_files'][0], 'the file info should have a size key');
        $this->assertEquals(5,$dirInfo['sub_files'][0]['sub_files'][0]['size'], 'the size of the file should be 5, length of the string, "hello"');

        $this->assertArrayHasKey('timestamp', $dirInfo['sub_files'][0]['sub_files'][0], 'the file info should have a timestamp');
        $this->assertFalse($dirInfo['sub_files'][0]['sub_files'][0]['timestamp'] < strtotime('-30 years') || $dirInfo['sub_files'][0]['sub_files'][0]['timestamp'] > strtotime('+30 years'), 'the timestamp should be a valid timestamp');
    }

}