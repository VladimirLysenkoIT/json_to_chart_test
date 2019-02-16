<?php
require 'library.php';
require PATH.'/classes/JsonHandler.php';

final class JsonHandlerTest extends PHPUnit\Framework\TestCase
{   
    // JSON decoded to array
    private $data = [];
    
    /**
    * @dataProvider providerGetJsonFromFile
    */
    public function testGetJsonFromFile($filePath, $result)
    {   
        if (file_exists($filePath)) {
            $json = file_get_contents($filePath);
            $this->assertJsonStringEqualsJsonFile($filePath, $json);
        }else{
            $this->assertFalse($result);
        }
        
    }

    public function providerGetJsonFromFile ()
    {
        return array (
            array (PATH . "/data/data.json", true),
            array (PATH . "/data/random_data.json", true),
            array (PATH . "/file_not_exists.json", false),
        );
    }

    /**
     * @dataProvider providerJsonToArray
     */
    public function testJsonToArray ($json)
    {   
        $reflection = new ReflectionClass('JsonHandler');
        $method = $reflection->getMethod('jsonToArray');
        $method->setAccessible(true);
       
        $dataProperty = $reflection->getProperty('data');
        $dataProperty->setAccessible(true);

        $obj = new JsonHandler();

        $this->assertEmpty($dataProperty->getValue($obj));
        $method->invoke($obj, $json);

        $this->assertIsArray($dataProperty->getValue($obj));
        $this->assertGreaterThan(0,count($dataProperty->getValue($obj)));
    }


    public function providerJsonToArray ()
    {
        return array (
            array ('{"Columns":["January","February","March","April","May","June","July","August","September","October","November","December"],"Rows":{"VN":[58,48,92,47,65,42,76,35,16,82,48,36],"PT":[97,26,48,75,19,36,17,45,28,65,74,84],"MA":[47,56,44,95,27,19,65,23,58,49,46,42],"MRI":[97,59,42,47,56,85,17,59,52,46,57,42],"PHL":[32,25,63,48,25,46,74,88,12,65,26,59]}}'),
            array ('{"Columns":["random ","random random ","random random ","random random ","random random ","random random ","random random ","random random ","random ","random ","random random random ","random "],"Rows":{"VN":[18,23,65,24,37,24,25,97,57,12,61,74],"HGAS":[3453,13412,1234,8764,5856,3974,1936,9375,9412,4712,1026,4751],"MA":[47,56,44,95,27,19,65,23,58,49,46,42],"MRI":[97,59,42,47,56,85,17,59,52,46,57,42],"PHL":[32,25,63,48,25,46,74,88,12,65,26,59]}}'),
        );
    }
}