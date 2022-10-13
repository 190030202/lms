DROP TABLE IF EXISTS cvsu_college;
DROP TABLE IF EXISTS cvsu_course;
DROP TABLE IF EXISTS cvsu_department;
CREATE TABLE `cvsu_college` (
  `college_ID` int(11)  NOT NULL,
  `college_Name` varchar(150) DEFAULT NULL,
  `college_Acronym` varchar(25) DEFAULT NULL
) ;

INSERT INTO `cvsu_college` (`college_ID`, `college_Name`, `college_Acronym`) VALUES
(1, 'College of Engineering and Information Technology', 'CEIT'),
(2, 'College of Art and Sciences', 'CAS');



CREATE TABLE `cvsu_course` (
  `course_ID` int(11)  NOT NULL,
  `department_ID` int(11)  DEFAULT NULL,
  `course_Name` varchar(100) DEFAULT NULL,
  `course_Acronym` varchar(10) DEFAULT NULL
) ;


INSERT INTO `cvsu_course` (`course_ID`, `department_ID`, `course_Name`, `course_Acronym`) VALUES
(1, 2, 'Bachelor of Science in Information Technology', 'BSIT'),
(2, 2, 'Bachelor of Science in Computer Science', 'BSCS'),
(3, 2, 'Bachelor of Science in Office Administration', 'BSOA');



CREATE TABLE `cvsu_department` (
  `department_ID` int(11)  NOT NULL,
  `college_ID` int(11)  DEFAULT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `department_acronym` varchar(25) DEFAULT NULL
);



INSERT INTO `cvsu_department` (`department_ID`, `college_ID`, `department_name`, `department_acronym`) VALUES
(1, 1, 'Computer Science', 'COMSCI'),
(2, 1, 'Information Technology', 'IT'),
(3, 1, 'Office Administration', 'OA');

SELECT cc.course_ID, cd.department_name,ccc.college_Acronym,ccc.college_Name FROM cvsu_course cc
LEFT JOIN cvsu_department cd ON cd.department_ID = cc.department_ID
LEFT JOIN cvsu_college ccc ON ccc.college_ID = cd.college_ID
;