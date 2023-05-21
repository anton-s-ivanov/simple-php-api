<?php

    require 'Tests\ItemTests\ItemTests.php';
    

    class Tests
    {

        public function __construct()
        {
            $this->itemTestsClass = new ItemTests();
        }

        public function runTests()
        {
            //Переделать на рекурсивный сбор по папке Tests
            $tests = $this->getClassTestsList($this->itemTestsClass); 

            $this->itemTestsClass->dbSeedItems();

            $testResults = [];
            foreach($tests as $class=>$classTests){
                foreach($classTests as $classTest){
                    $testResults[$class.': '.$classTest] = $this->itemTestsClass->$classTest();
                }
            }
            
            $this->printResults($testResults);
            // $this->itemTestsClass->removeAddedElems();
        }

        public function getClassTestsList($class)
        {
            $className = get_class($class);
            $tests = [];
            foreach(get_class_methods($class) as $methodName){
                if(str_contains($methodName, 'test_')){
                    $tests[$className][] = $methodName;
                }
            }

            return $tests;
        }

        public function printResults($testResults)
        {
            echo '<h1>Тесты</h1>';
            $ok = $failed = 0;
            foreach($testResults as $test=>$result){
                echo '<br>'. $test . ': ' . $result;
                if($result == 'ok')
                $ok++;
                if($result == 'failed')
                $failed++;
            }   

            echo '<br><br>';
            echo 'ok: ' . $ok .' failed: '. $failed;
        }

    }
    