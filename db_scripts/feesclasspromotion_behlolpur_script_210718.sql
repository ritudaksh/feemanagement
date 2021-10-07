--210719 behlolpur

/*for greater than 1st class till 9th class */
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, class_no+1, section , '2021-04-01', null  FROM student_classes where class_no>=1 and class_no<10 and ended_on is  null;
--123 rows inserted

/*for UKG to 1st class*/
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, '1', section , '2021-04-01', null  FROM student_classes where class_no='UKG' and ended_on is  null;
--38 rows inserted

/*for LKG to UKG*/
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, 'UKG', section , '2021-04-01', null  FROM student_classes where class_no='LKG' and ended_on is null;
--38 rows inserted

/*for nursery to LKG*/
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, 'LKG', section , '2021-04-01', null  FROM student_classes where class_no='nursery' and ended_on is null;
--48 rows inserted

/*for play-way to nursery*/
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, 'nursery', section , '2021-04-01', null  FROM student_classes where class_no='play-way' and ended_on is null;
--5 rows inserted

/*update ended_on in student clases*/
update student_classes set ended_on='2021-03-31' where year(started_on) != 2021 and started_on>='2020-04-01' and started_on<'2021-04-01' and ended_on is null;
--116 rows updated

