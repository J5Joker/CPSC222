<?php
class student
	{
		private $fname, $lname, $id; //, $electric;

		function __construct($f, $l, $id) //, $e)
		{
    		$this->setFirst($f);
   		$this->setLast($l);
    		$this->setID($id);
   		//$this->setElectric($e);
		}

		function getFirst()
		{
			return $this->fname;
		}

		function setFirst($f)
		{
			$this->fname = $f;
		}
		function getLast()
		{
			return $this->lname;
		}

		function setLast($l)
		{
			$this->lname = $l;
		}
		function getID()
		{
			return $this->id;
		}

		function setID($id)
		{
			$this->id = $id;
		}
	/*	function getElectric()
		{
			return $this->electric;
		}

		function setElectric($e)
		{
			$this->electric = $e;
		}
	*/
		function getStudent()
		{
			return $this->getLast() . ", " . $this->getFirst();
		}
		function getStudentID()
		{
			return $this->getID();
		}

	}
?>
