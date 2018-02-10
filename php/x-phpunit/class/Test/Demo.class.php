<?php 

class Test_Demo extends TestCase {

	public function testAdd(){
		$addResult = Lib_Demo::Add(1, 3);
		$this->assertEquals($addResult, 4);
	}
	
} 

?>