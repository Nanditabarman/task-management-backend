<?php
class TaskService {

    private $a;
    private $b;

    public function setA($a) {
        $this->a =  $a;
    }


    public function setB($b) {
        $this->b =  $b;
    }

    public function getResult() {
        return $this->a + $this->b;
    }

}


class ExampleController {

    public function __construct()
    {
        $objectA = new TaskService();
        $objectB = new TaskService();

        $objectA->setA(1);
        $objectA->setB(2);

        $objectB->setA(3);
        $objectB->setB(4);

        return $objectA->getResult() + $objectB->getResult();

    }
}


