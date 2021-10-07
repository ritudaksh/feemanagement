/* first insert than update */
/* used on 190328 on live */

/* set the 12th and 10th class students to passed out */
update student_classes set ended_on='2020-03-31' where class_no='12' ;
--505 records updated; wrong should have the ended_on check
update student_classes set ended_on='2020-03-31' where class_no='10' and ended_on is null;
--124 records

update student_master s
INNER JOIN student_classes sc ON s.student_id = sc.student_id
AND sc.class_no =12
AND year( sc.started_on ) =2019
AND STATUS != 'passed out'
set status='passed out', passedout_date='2020-03-31';
--71 rows
update student_master s
INNER JOIN student_classes sc ON s.student_id = sc.student_id
AND sc.class_no =10
AND year( sc.started_on ) =2019
AND STATUS != 'passed out'
set status='passed out', passedout_date='2020-03-31';
--138 rows


/*for greater than 1st class till 9th class and then for 11th class*/
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, class_no+1, section , '2020-04-01', null  FROM student_classes where class_no>=1 and class_no<10 and ended_on is  null;
--1075 records inserted
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, class_no+1, section , '2020-04-01', null  FROM student_classes where class_no>=1 and class_no=11 and ended_on is  null;
--31 rows inserted

/*for UKG to 1st class*/
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, '1', section , '2020-04-01', null  FROM student_classes where class_no='UKG' and ended_on is  null;
--17 rows inserted

/*for LKG to UKG*/
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, 'UKG', section , '2020-04-01', null  FROM student_classes where class_no='LKG' and ended_on is null;
--16 rows inserted

/*for nursery to LKG*/
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, 'LKG', section , '2020-04-01', null  FROM student_classes where class_no='nursery' and ended_on is null;
--63 rows inserted

/*for play-way to nursery*/
INSERT INTO student_classes (student_id, class_no, section , started_on,ended_on)
SELECT  student_id, 'nursery', section , '2020-04-01', null  FROM student_classes where class_no='play-way' and ended_on is null;
--25 rows inserted

/*update ended_on in student clases*/
update student_classes set ended_on='2020-03-31' where year(started_on) != 2020 and started_on>='2019-04-01' and started_on!='2020-04-01' and ended_on is null;
--1358 rows updated

---odd
delete FROM `student_classes` WHERE class_no=13
--56 records deleted
delete FROM `student_classes` WHERE class_no=14
--56 records deleted


