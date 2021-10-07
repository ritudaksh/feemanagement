--210719
--students alreadypromoted for all classes except 5,6,7,9,10,11,12
--su updating only for 6,7,11

/* set the 12th and 10th class students to passed out */
update student_classes set ended_on='2021-03-31' where class_no='12' and ended_on is null;
--32 records updated
update student_classes set ended_on='2021-03-31' where class_no='10' and ended_on is null;
--62 records

update student_master s
INNER JOIN student_classes sc ON s.student_id = sc.student_id
AND sc.class_no =12
AND year( sc.started_on ) =2020
AND STATUS != 'passed out'
set status='passed out', passedout_date='2021-03-31';
--104 rows
update student_master s
INNER JOIN student_classes sc ON s.student_id = sc.student_id
AND sc.class_no =10
AND year( sc.started_on ) =2020
AND STATUS != 'passed out'
set status='passed out', passedout_date='2021-03-31';
--167 rows


INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, class_no+1, section , '2021-04-01', null  FROM student_classes where class_no in (6,7,11)  and ended_on is  null;
--427 rows inserted

/*update ended_on in student clases*/
update student_classes set ended_on='2021-03-31' where year(started_on) != 2021 and started_on>='2020-04-01' and started_on< '2021-04-01' and ended_on is null;
--753 rows updated
NOTE: in 2021, manual updates for class promotion were done, so date start on could be >= 2021-04-01



