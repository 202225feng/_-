<!DOCTYPE html>
<html>
<head>
	<title>Setting up</title>
</head>
<body>
	<h3>Setting up...</h3>
<?php
	require_once "function.php";
	Createtable('user_infor',
		'user_num varchar(40) ,
		name varchar(20),
		pass varchar(64),
		gender varchar(6),
		phonenum varchar(12),
		school varchar(20),
		major varchar(20),
		degree varchar(20),
		PRIMARY KEY (`user_num`)');
	Createtable('group_info',
		'group_num int unsigned AUTO_INCREMENT primary key,
		cour_name varchar(10),
		collage varchar(100),
		term varchar(20),
		codes varchar(30),
		index(term(20)),
		index(cour_name(10)
		)');
	Createtable('admin_info',
		'tea_user varchar(20),
		tea_name varchar(10),
		pass varchar(64),
		gender varchar(6),
		collage varchar(20),
		class smallint,
		primary key(`tea_user`),
		index(tea_name(6))');
	Createtable('user_group',
		'id int unsigned AUTO_INCREMENT primary key,
		user_num varchar(40),
		group_num int unsigned,
		status varchar(1),
		index(user_num(40)),
		index(group_num),
		foreign key(user_num) references user_infor(user_num),
		foreign key(group_num) references group_info(group_num)
		');
	Createtable('admin_group',
		'id int unsigned AUTO_INCREMENT primary key,
		tea_user varchar(20),
		tea_name varchar(10),
		group_num int unsigned,
		class smallint,
		status varchar(1),
		cour_name varchar(20),
		index(tea_user(20)),
		index(tea_name(10)),
		index(group_num),
		index(cour_name(20)),
		foreign key(tea_user) references admin_info(tea_user),
		foreign key(group_num) references group_info(group_num)
		');
	
	
	Createtable('qbase_book','
		id int unsigned AUTO_INCREMENT primary key,
		name varchar(50),
		adminuser varchar(20),
		number int unsigned,
		exits varchar(500),
		index(name(20)),
		index(adminuser(20))
		');
	Createtable('qbase_chapter','
		id int unsigned AUTO_INCREMENT primary key,
		book_id int unsigned,
		name varchar(50),
		number int unsigned,
		exits varchar(500),
		index(book_id),
		foreign key(book_id) references qbase_book(id)
		');
	Createtable('question','
		id int unsigned AUTO_INCREMENT primary key,
		book_id int unsigned,
		cha_id int unsigned,
		types int unsigned,
		exits varchar(600),
		peacherid varchar(30),
		answer varchar(50),
		ans1 varchar(50),
		ans2 varchar(50),
		ans3 varchar(50),
		ans4 varchar(50),
		ans5 varchar(50),
		ans6 varchar(50),
		ans7 varchar(50),
		nandu varchar(10),
		index(nandu(10)),
		foreign key(book_id) references qbase_book(id),
		foreign key(cha_id) references qbase_chapter(id)
		');
	Createtable('paper','
		id int unsigned AUTO_INCREMENT primary key,
		group_num int unsigned,
		admin_tea varchar(20),
		paper_name varchar(20),
		time datetime,
		index(paper_name(20)),
		foreign key(group_num) references group_info(group_num)
		');
	Createtable('paper_ques','
		id int unsigned AUTO_INCREMENT primary key,
		paper_id int unsigned,
		q_id int unsigned,
		q_type int unsigned,
		book_name varchar(20),
		cha_name varchar(20),
		foreign key(paper_id) references paper(id),
		foreign key(q_id) references question(id),
		index(q_type)
		');
	Createtable('exam','
		id int unsigned AUTO_INCREMENT primary key,
		group_num int unsigned,
		begin_date datetime,
		end_date datetime,
		exits varchar(500),
		name varchar(100),
		foreign key(group_num) references group_info(group_num),
		index(group_num),
		index(name(20))
		');
	Createtable('exam_paper','
		id int unsigned AUTO_INCREMENT primary key,
		ex_id int unsigned,
		pa_id int unsigned,
		paper_name varchar(30),
		foreign key(pa_id) references paper(id),
		foreign key(ex_id) references exam(id)
		');
	Createtable('exam_user','
		id int unsigned AUTO_INCREMENT primary key,
		user_num  varchar(40),
		exam_id int unsigned,
		foreign key(user_num) references user_infor(user_num),
		foreign key(exam_id) references exam(id)
		');
	Createtable('exam_ans','
		id int unsigned AUTO_INCREMENT primary key,
		e_id int unsigned,
		p_id int unsigned,
		q_id int unsigned,
		q_type int unsigned,
		user varchar(50),
		ans varchar(100),
		timeuse int,
		foreign key(e_id) references exam(id),
		foreign key(p_id) references paper(id),
		foreign key(q_id) references question(id)
		');
	Createtable('e_p_fen','
		id int unsigned AUTO_INCREMENT primary key,
		e_id int unsigned,
		p_id int unsigned,
		t1 int,
		t2 int,
		t3 int,
		t4 int,
		t5 int,
		index(e_id),
		index(p_id),
		foreign key(e_id) references exam(id),
		foreign key(p_id) references paper(id)
		');
	Createtable('exam_read','
		id int unsigned AUTO_INCREMENT primary key,
		e_id int unsigned,
		p_id int unsigned,
		user varchar(40),
		timeuse int,
		fen int unsigned,
		c_rate float,
		z_fen int unsigned,
		ft1 int unsigned,
		ft2 int unsigned,
		time datetime,
		pingjia varchar(500),
		index(e_id),
		index(p_id),
		index(user),
		foreign key(e_id) references exam(id),
		foreign key(p_id) references paper(id),
		foreign key(user) references user_infor(user_num)
		');
?>
	<br>...Done.
</body>
</html>
