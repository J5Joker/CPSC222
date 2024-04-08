<?phps
require_once("phpch6-student.php");
require_once("phpch6-course.php");

	$studentArr = array(
    		new Student("James", "Nichols", "051602"),
    		new Student("Hunter", "Furgiuele", "032212"),
    		new Student("Charles", "Deitke", "020301")
	);

	$courseArr = array(
    		array(
        	new Course("History", "95"),
        	new Course("Spanish", "80"),
        	new Course("Math", "65"),
    		),
    		array(
        	new Course("Art", "90"),
        	new Course("Music", "85"),
        	new Course("Philosophy", "70"),
    		),
    		array(
        	new Course("Science", "100"),
        	new Course("Dum Dum Class", "90"),
        	new Course("Coding", "70"),
    		)
	);

echo "<table border='1'>";

// Loop through each student and their respective courses
for ($x = 0; $x < count($studentArr); $x++) {
    $student = $studentArr[$x];
    $courses = $courseArr[$x];

    echo "<table border='1'>";
    echo "<tr><td><b>Name</b></td><td>{$student->getStudent()}</td></tr>";
    echo "<tr><td><b>Student ID</b></td><td>{$student->getStudentID()}</td></tr>";
    echo "<tr><td><b>Grades</b></td><td>";

    // Display each course and score
    echo "<ul>";
    foreach ($courses as $course) {
        echo "<li>{$course->getName()}: {$course->getScore()}</li>";
    }
    echo "</ul>";

    echo "</td></tr>";
    echo "</table><br>";
}

echo "</table>";
?>
