<?php
class Course
{
    private $name, $score; //, $electric;

    function __construct($n, $s) //, $e)
    {
        $this->setName($n);
        $this->setScore($s);
        //$this->setElectric($e);
    }

    function getName()
    {
        return $this->name;
    }

    function setName($n)
    {
        $this->name = $n;
    }
    
    function getScore()
    {
        return $this->score;
    }

    function setScore($s)
    {
        $this->score = $s;
    }

    /* function getElectric()
    {
        return $this->electric;
    }

    function setElectric($e)
    {
        $this->electric = $e;
    }
    */

    function getCourse()
    {
        $grade = "";
        $score = $this->getScore();

        if ($score > 89) {
            $grade = "A";
        } elseif ($score >= 80) {
            $grade = "B";
        } elseif ($score >= 70) {
            $grade = "C";
        } elseif ($score >= 60) {
            $grade = "D";
        } else {
            $grade = "F";
        }

        return $this->getName() . " - " . $this->getScore() . " " . $grade;
    }

}
?>
