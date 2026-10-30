1. 환경 설치

    javascript:alert(document.cookie);
	download xampp
	download visual code

    localhost/generate.php

how secure


$id = admin
$pass = abcd

select * from users where id='admin' and pass='abcd';


$id = xxx' or 2>1 limit 1, 1 -- 
$pass = abcd
select * from users where id='xxx' or 2>1 -- ' and pass='abcd';

download burp
a.php
a.php%20.jpg
XSS : Cross Site Scripting

X : DX, AX : trans
X : Cross
X : windows XP = Expert

IP Address

1.2.3.4 = 4B

A class
0000 0000
0111 1111 , 0~127

30.*.*.* : 1600만개
10.*.*.* : 사설아이피 (공유기)
127.0.0.1

B class
1000 0000 ~ 1011 1111 : 128~191
150.12.*.* : 6만5천

150.12.1~10.* 컴퓨
172.16.*.*

C class
1100 0000 ~ 1101 1111 : 192~221
200.17.37~40.*
192.168.0.0~255


   IPv4 주소 . . . . . . . . . : 192.168.103.27
   서브넷 마스크 . . . . . . . : 255.255.255.0
   기본 게이트웨이 . . . . . . : 192.168.103.1

   1.2.3.4

   0001 0010 0011 0100
   1111 1111 1111 0000
   0001 0010 0011 0000 = 1.2.3.0

   0001 0010 0011 0101
   1111 1111 1111 0000
   0001 0010 0011 0000 = 1.2.3.0

   0001 0010 0111 0101
   1111 1111 1111 0000
   0001 0010 0111 0000 = 1.2.7.0

   256 - 16 = 240

   255.255.255.240

   http://daum.net
   ftp://daum
   
   https://www.daum.net/

    net craft webserver




2. xampp control panel
	Apache,  MySQL  실행

	localhost
    localhost/phpmyadmin

	http://localhost/phpmyadmin/

	새로운 -> 사용자계정 -> 사용자 추가

	id/db : secure
		pass : 1111

		v : 동명의 데이터베이스 ..
		v : Grant all priv ... 
		v : 모두 체크

    테스트용 로그 데이터 삭제

    delete from log;

    [abc]

    ls *.[ch]

    [abc]{2}

    ab, cc, cb, bd(x)

    [abc]{2,4}  2~4ghl

    ac, ccc

    [abcdefg....xyz]{4,10}

    [a-zA-Z0-9]{4,6}

    test, tester, secure


    010-[0-9]{4}-[0-9]{4}


    ^[가-힣]{2,4}$

    https://github.com/nadopro/kpc2607

    https://www.security.org/how-secure-is-my-password/

    https://w3schools.com


1. 무차별 대입 공격(Brute Force Attack)

  로그인 및 정보 저장 방법

  session vs. cookie vs. localStorage

  javascript:alert(document.cookie)

  a. session 관리 주체 = 서버
  b. cookie 관리 주체 = client
  c. localStorage 관리 주체 = client


2. SQL Injection

    $id : test
    pass : 1111

    $sql = 
    "select * from users where id='$id' and pass='$pass' ";

      select * from users where id='xxx' or 2>1 -- ' and pass='$pass' 


      id = xxx' or 2>1 limit 2, 1 -- 
      pass = dsafdsa


Q1.

다음 조건을 만족하는 index.php 파일을 만들어 줘.
HTML5와 Bootstrap5를 이용해서 반응형 홈페이지를 만들거야.
상단에는 Navbar를 이용해서 메뉴를 구성할거야.
메뉴에는 menu1, menu2, menu3이 있어.
각각의 메뉴는 Dropdown 으로 구성할거야.
menu1에는 menu1-1, menu1-2, menu1-3,
menu2에는 menu2-1, menu2-2,
menu3에는 menu3-1, menu3-2 로 구성되어 있어.

내용에는 "KPC 보안 프로그래밍 과정"이라고만 써줘.
하단에는 사이트 정보가 있는데,
"한국 생산성본부(KPC)
정보보호책임자: 홍길동(help@kpc.or.kr")

만약에 내용이 너무 적더라도 하단의 사이트 정보는 항상 화면의
맨 아래에 배치되도록 구성해 줘.


2. MySQL을 사용해서 users 테이블 스키마를 만들고 싶어.

  idx auto_increment primary key,
  id varchar(20) unique,
  name varchar(30),
  pass varchar(50),
  level int(3) default '1'


CREATE TABLE users (
    idx INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(30) NOT NULL,
    pass VARCHAR(50) NOT NULL,
    level INT(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO users (id, name, pass, level)
VALUES ('admin', '관리자', '1234', 9);

INSERT INTO users (id, name, pass, level)
VALUES ('test', '테스트', '1234', 1);

INSERT INTO users (id, name, pass, level)
VALUES ('test', '테스트', '1234', 1);


Q2. db.php을 하나 만들고 싶어.

$conn = connectDB();
함수를 만들고 싶어.

dbName : secure
dbUser : secure
dbPass : 1111

mysqli()를 이용해서 함수화 하고 싶어.

closeDB($conn)도 같이 만들어 줘.




connectDB();

for(;;)
{
  insert into ...()
}

closeDB()




for(;;)
{
  connectDB();
  insert into ...()
  closeDB()  
}

GET/POST의 차이

GET : 주소창에 파라미터를 전달
  예) test.php?name=test&pass=1234&age=10
  https://newsstand.naver.com/?list&pcode=117

POST : Request Body 속에 파라미터를 전달


javascript:alert(document.cookie)


Q3. 현재 index.php 파일이 다음과 같이 되어 있어.
이때 index.php?cmd=test와 같이 GET 방식으로 cmd값을 찾으려고 해.
즉, cmd = $_GET['cmd']; 와 같이 처리할 거야.
만약에 cmd가 없으면 init를 default로 해 줘.
바디 부분은 include "$cmd.php"; 와 같이 처리할 거야.
예를 들어서
index.php?cmd=login 으로 되어 있으면
body에서 include "login.php"; 와 같이 처리하고 싶어.


<?php
    session_save_path("./sess");
    session_start();
    
    include "db.php";

    $conn = connectDB();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KPC 보안 프로그래밍 과정</title>

  <!-- Bootstrap5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">KPC</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              취약점 확인
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">SQL Injection</a></li>
              <li><a class="dropdown-item" href="#">SQL Injection(Secure)</a></li>
              <li><a class="dropdown-item" href="#">menu1-3</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              menu2
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">menu2-1</a></li>
              <li><a class="dropdown-item" href="#">menu2-2</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              menu3
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">menu3-1</a></li>
              <li><a class="dropdown-item" href="#">menu3-2</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <main class="container flex-grow-1 d-flex align-items-center justify-content-center">
    <h1>KPC 보안 프로그래밍 과정</h1>
  </main>

  <!-- Footer -->
  <footer class="bg-light border-top py-3 mt-auto">
    <div class="container text-center">
      한국 생산성본부(KPC)<br>
      정보보호책임자: 홍길동(help@kpc.or.kr)
    </div>
  </footer>

  <!-- Bootstrap5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

Q4.

이와 같이 index.php을 모두 거치도록 구조가 결정되었어.
index.php?cmd=injection을 링크로 만들었어.
즉 injection.php을 include하면 되는 상황이야.
이 파일은 sql injection을 연습해보고 싶어.
로그인 창을 만들고, id, pass를 입력받아.
CREATE TABLE users (
    idx INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(30) NOT NULL,
    pass VARCHAR(50) NOT NULL,
    level INT(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


이 테이블에 암호화하지 말고, 단순하게 id, pass검사하는 코드를 만들어줘.

index.php에서 이미 DB연결은 끝나고 $conn로 사용이 가능해.

mysqli_query()와 mysqli_fetch_array()를 이용해 줘.


Q5.

현재 코드가 다음과 같은데, 여기에 세션처리까지 해서,
로그인 기록을 남겨줘.

<?php
// injection.php
?>

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card">
            <div class="card-header bg-danger text-white">
                SQL Injection 실습 (취약한 로그인)
            </div>

            <div class="card-body">

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id   = $_POST['id'];
    $pass = $_POST['pass'];

    // -------------------------------
    // 취약한 SQL (실습용)
    // -------------------------------
    $sql = "SELECT * FROM users
            WHERE id='$id'
            AND pass='$pass'";

    echo "<div class='alert alert-secondary'>";
    echo "<b>실행된 SQL</b><br>";
    //echo htmlspecialchars($sql);
    echo "</div>";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_array($result)) {

        echo "<div class='alert alert-success'>";
        echo "로그인 성공<br>";
        echo "이름 : {$row['name']}<br>";
        echo "권한 : {$row['level']}";
        echo "</div>";

    } else {

        echo "<div class='alert alert-danger'>";
        echo "로그인 실패";
        echo "</div>";

    }

}

?>

<form method="post">

    <div class="mb-3">
        <label class="form-label">ID</label>
        <input type="text"
               name="id"
               class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password"
               name="pass"
               class="form-control">
    </div>

    <button class="btn btn-danger">
        Login
    </button>

</form>

            </div>
        </div>

    </div>
</div>


Q6. 현재 로그인 창 아래에 로그인 버튼만 있는데,

로그인된 경우에는 "로그아웃" index.php?cmd=logout
로그인이 안된 경우는 지금처럼 동작하면 돼.




select * from users where id='xxx' or 2>1 -- ' and pass='$pass'
                              xxx' or 2>1 -- 


===============================================
Day 2
===============================================
웹 서버 점유율

https://www.netcraft.com/blog/june-2026-web-server-survey


IP : 1.2.3.4
      0001 0010  0011 0100
      1111 1111  1111 0000
    & 0001 0010  0011 0000 = 1.2.3.0  
    
    
IP Address

  0000 0000
  0111 1111 0~127

A class : 0XX
  Special Purpose Address : 10.*.*.* / 127.*.*.*

B class : 1000 0000 ~ 1011 1111 : 128~191

  SPA : 172.16.*.*

Q7. 

아래 코드를 변경해서 injection3.php 파일을 만들어줘.
입력창의 ID, Password 앞에 체크박스와 "저장"이라는 텍스트를 출력해.
각 체크박스의 이름은 save_id, save_pass로 하고 싶어.
체크박스가 설정된 경우에는 id, pass를 각각 localStorage에 저장하고,
다음번에 이 창이 호출되었을 때, 체크된 저장된 id, pass를 자동으로
가져오도록 변경해 줘.

<?php
// injection.php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id   = $_POST['id'];
    $pass = $_POST['pass'];

    // -------------------------------
    // SQL Injection 취약 코드 (실습용)
    // -------------------------------

    $id = str_replace("--", "", $id);
    $id = str_replace("'", "", $id);
    $id = str_replace('"', "", $id);

    $pass = str_replace("--", "", $pass);
    $pass = str_replace("'", "", $pass);
    $pass = str_replace('"', "", $pass);


    $sql = "SELECT * FROM users WHERE id='$id' AND pass='$pass'";

    $result = mysqli_query($conn, $sql);


    if ($row = mysqli_fetch_array($result)) {

        echo "idx = $row[idx]<br>";
        $_SESSION['login'] = true;
        $_SESSION['idx']   = $row['idx'];
        $_SESSION['id']    = $row['id'];
        $_SESSION['name']  = $row['name'];
        $_SESSION['level'] = $row['level'];

        $msg = "<div class='alert alert-success'>
                    로그인 성공
                </div>";

    } else {

        $msg = "<div class='alert alert-danger'>
                    로그인 실패
                </div>";

    }
}
?>

<div class="row justify-content-center">

    <div class="col-md-5">

        <div class="card">

            <div class="card-header bg-danger text-white">
                SQL Injection 실습 (취약한 로그인)
            </div>

            <div class="card-body">

                <?php
                if (isset($msg)) {
                    echo $msg;
                }
                ?>

                <?php
                if (isset($_SESSION['login']) && $_SESSION['login']) {
                ?>

                    <div class="alert alert-info">

                        <b>현재 로그인 상태</b><br><br>

                        ID : <?= $_SESSION['id'] ?><br>
                        이름 : <?= $_SESSION['name'] ?><br>
                        권한 : <?= $_SESSION['level'] ?>

                    </div>

                    <div class="d-grid">

                        <a href="index.php?cmd=logout"
                           class="btn btn-secondary">
                            로그아웃
                        </a>

                    </div>

                <?php
                } else {
                ?>

                    <form method="post">

                        <div class="mb-3">
                            <label class="form-label">ID</label>

                            <input
                                type="text"
                                name="id"
                                class="form-control">
                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="pass"
                                class="form-control">

                        </div>

                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-danger">

                                Login

                            </button>

                        </div>

                    </form>

                <?php
                }
                ?>

            </div>

        </div>

    </div>

</div>

Q8.

지금 만들어진 코드가 잘 동작하고 있어.
이 코드를 개선하고 싶어.
비밀번호가 저장될때 localStorage에서 노출되는 문제가 있어.
암호화해서 저장하고,
입력창에 가져올때는 복호화해서 ****으로 보여주고 싶어.
또, 로그인을 실행할때, 패킷을 Web Proxy로 검사하면
raw 데이터가 노출되는 문제가 있어.
패킷으로 날라갈때는 다시 암호화(인코딩)하고,
DB와 검사할 때는 복호화해서 검사하도록 로직을 변경해 줘.

localhost/phpmyadmin

update users set pass='abcd';

INSERT INTO users (id, name, pass, level)
VALUES ('tester', '테스터', 'bcdef', 1);
INSERT INTO users (id, name, pass, level)
VALUES ('hong', '홍길동', 'bcdef', 1);
INSERT INTO users (id, name, pass, level)
VALUES ('sslee', '이순신', 'cdef', 1);
INSERT INTO users (id, name, pass, level)
VALUES ('auth', '암호화', password('abcd'), 1);
INSERT INTO users (id, name, pass, level)
VALUES ('auth2', '암호화', password('abcd2'), 1);

Q9. brute Force

index.php?cmd=brute와 같이 접속할거야.
index.php에서는 DB 접속을 이미 끝내고 $conn에 접속정보를 가지고 있어.
index.php에서는 brute.php를 include하는 형태로 사용해.

영문으로 된 텍스트를 찾는 원리를 코드로 만들고 싶어.
예를 들어, aaaa, aaab, aaac....zzzz까지 검사하는 코드야.
users 테이블의 비밀번호와 이 텍스트가 같은지 비교하는 코드를 작성할거야.
만약에 하나라도 찾으면, 동일한 비밀번호를 갖는 아이디를 모두
출력하고 프로그램을 종료해 줘.
만약 반복문을 사용하는 경우에, 반복문이 1000회 수행될 때마다, 화면에 횟수를 출력해.
최종적으로 몇 번만에 찾았는지도 출력해 줘.

Q10. 

지금 만들어진 코드를 수정해서 brute2.php를 만들고 싶어.
사용자의 입력을 받아서 min, max를 입력받아.
만약에 min=4, max=6이라면 영문으로 된 4글자~6글자를 순차적으로
검사하는 코드로 변경하고 싶어.

Q11.

shell.php 을 같은 방법으로 만들고 싶어.
사용자입력으로 command를 입력받아. 실행버튼을 누르면 
하단에 명령을 수행하도록 해 줘.
만약 화면에 출력하는 과정에서 한글이 깨지는 현상이 없도록
인코딩 처리도 해 줘.


flush

main()
{
  a(); printf("A\n");
  b(); printf("B\n");
  c(); printf("C\n");
  fflush(stdout);
  d(); printf("D\n");
  fflush(stdout);
  e(); printf("E\n");
}

A 
B 

void print(char *ptr)
{
  char buf[100];
  bzero(buf, sizeof(buf)); // memset(buf, 0x0, size..)
  strcpy(buf, ptr);
  printf("%s", buf);
  printf(buf);
}
./test hello
./test "hello world"
./test `python print("A"*200)`
int main(int argc, char **argv)
{
  print(argv[1])
  return 0;
}


Q12.

다음과 같은 MySQL 스키마를 만들고 싶어.
table name : log
필드 정보
  idx : integer, auto_increment, primary key
  ip : IP Address 저장 예: 1.2.3.4
  id : 사용자의 아이디를 저장
  work : varchar(255)
  time : datetime

  2026-06-30 12:34:56


  CREATE TABLE log (
    idx INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(45) NOT NULL,
    id VARCHAR(20) NOT NULL,
    work VARCHAR(255) NOT NULL,
    time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

Q13.

다음과 같은 MySQL 스키마를 정의해 줘.

table name : iot 
필드 :
  idx : integer, auto_increment, primary key,
  temp : float,
  hum : float,
  time : datetime


CREATE TABLE iot (
    idx INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    temp FLOAT NOT NULL,
    hum FLOAT NOT NULL,
    time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


Q14.

gen.php 파일을 만들고 싶어.
index.php?cmd=gen 으로 접속을 하고, index.php에서 이미
$conn에 DB접속까지 마친상태야.

랜덤하게 25-26도 사이의 온도(temp), 50-55 사이의 습도(hum)을
발생한 후, 직전에 만든 iot 테이블에 넣는 작업을 할거야.
자바스크립트로 3초마다 setTimeout()을 활용해서 반복적인 작업을 하고 싶어.


===============================================
Day 3
===============================================


JSON : JavaScript Object Notation

  <img src="a.jpg" width=100>

  src:"a.jpg",
  width: 1000

  key : value

  {} : 객체
  [] : 리스트


  {
    "name" : "홍길동", 
    "age":12, 
    "company":"KPC"
  }

  {
    "name" : "홍길동", 
    "age":12, 
    "company": {
      "name": "KPC",
      "tel" : "02-1111-2222",
      "url" : "https://kpc.or.kr"
    }
  }

  {
    "person" : {
      "name" : "홍길동", 
      "age":12, 
     },
    
    "company": {
      "name": "KPC",
      "tel" : "02-1111-2222",
      "url" : "https://kpc.or.kr"
    }
  }

  {
    "직원" : [
      {
        "name" : "홍길동", 
        "age":12, 
      },
      {
        "name" : "이순신", 
        "age":12, 
      },
    ],
    
    "company": {
      "name": "KPC",
      "tel" : "02-1111-2222",
      "url" : "https://kpc.or.kr"
    }
  }
Q15. 
인물관계를 JSON으로 표시하고 싶어.
노드와 링크로 구성되어 있어.
노드는 인물, 링크는 관계야.

신사임당의 아들 : 이율곡,
홍대감의 아들 : 홍길동
이율곡의 친구 : 홍길동
이순신의 친구 : 유성룡
이순신의 선생님 : 이율곡



{
  "nodes": [
    { "id": "신사임당", "type": "person" },
    { "id": "이율곡", "type": "person" },
    { "id": "홍대감", "type": "person" },
    { "id": "홍길동", "type": "person" },
    { "id": "이순신", "type": "person" },
    { "id": "유성룡", "type": "person" }
  ],
  "links": [
    { "source": "신사임당", "target": "이율곡", "relation": "아들" },
    { "source": "홍대감", "target": "홍길동", "relation": "아들" },
    { "source": "이율곡", "target": "홍길동", "relation": "친구" },
    { "source": "이순신", "target": "유성룡", "relation": "친구" },
    { "source": "이순신", "target": "이율곡", "relation": "선생님" }
  ]
}

Q16.

이 데이터를 이용해서, HTML5와 D3JS를 이용해서 네트워크 다이어그램으로 그리고 싶어.
노드는 원으로 표시하고, 안에 텍스트로 이름을 적어줘.
관계는 직선으로 표시하는데,
부모-자식 관계 : 빨간색
친구 관계 : 파란색
사제 관계 : 검정색 점선

선의 두께는 4px 정도로 그려줘.
이때, 마우스 휠의 동작에 따라 확대/축소하고 싶어.
만약 오른쪽마우스를 누르면 이동을 하고 싶어.

선에다가 마우스를 올리면 둘 사이의 관계를 텍스트로 확인할 수 있도록 해줘.


execCommand, wysiwyg 

int myfunc(int a)
{
  char *msg;
  if(a <0)
  {
    msg = "Parameter Error";
    goto Error;
  }

  return 0;

Error:
  printf("%s", msg);
  // log

}


Q17.

간단 게시판을 만들고 싶어.
먼저 Mysql Schema를 만들어야 해.
table name : board
대략적으로 이런 형태면 돼.

create table board(
  idx integer auto_increment primary key,
  id  varchar(30),
  name varchar(30),
  title varchar(100),
  html mediumtext,
  nread integer default '0',
  file  varchar(30),
  time datetime,
  ip  varchar(20)

);

스키마를 만들어주고, 글 3개를 입력해 줘.
작성자 : admin, 이름 : 관리자.
제목 : 테스트 제목 1, 테스트 제목 2, ..
내용 : 테스트 내용 1, 테스트 내용 2, ..




CREATE TABLE board (
    idx INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id VARCHAR(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    title VARCHAR(100) NOT NULL,
    html MEDIUMTEXT NOT NULL,
    nread INT NOT NULL DEFAULT 0,
    file VARCHAR(255) DEFAULT NULL,
    time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

INSERT INTO board (id, name, title, html)
VALUES
(
    'admin',
    '관리자',
    '테스트 제목 1',
    '테스트 내용 1'
),
(
    'admin',
    '관리자',
    '테스트 제목 2',
    '테스트 내용 2'
),
(
    'admin',
    '관리자',
    '테스트 제목 3',
    '테스트 내용 3'
);


Q18.

board.php는 index.php?cmd=board로 호출할거야.
GET으로 mode를 보고 동작을 결정해.
mode 없는 경우 기본적으로 mode = "list"
mode에는 

글목록보기(list), 글쓰기(write), 글쓰기 처리(do_write),
글보기 (show), 삭제하기(delete) 가 있어.
검색이나, 수정, 댓글달기 등은 기능에서 제외해.

반응형 홈페이지이기 때문에 이미 index.php에서 bootstrap5를 사용하도록
라이브러리가 추가 되었어.

글목록 보기인 경우,
PC에서는 글번호(idx), 글제목(title), 작성자(name), 작성일(time)
이 표현되고, Mobile인 경우에는 글제목과 작성자만 있으면 돼.

글 삭제하는 경우는 글내용 보기에서 관리자나, 작성자만 사용할 수 있어.

board.php 파일을 작성해 줘.
로그인 정보에서 세션 정보는 다음을 참고해.
ID : <?= $_SESSION['id'] ?><br>
이름 : <?= $_SESSION['name'] ?><br>
권한 : <?= $_SESSION['level'] ?>

Q19.
WYSIWYG 게시판에서 글쓰기 하는 부분을 예제로 만들고 싶어.
index.php?cmd=editor

상단에는 제목, 버튼입력부, 글쓰기부, 글등록 버튼 있어.
버튼입력에는 Bold, Underline, Italic 버튼만 있어.
각각 material-icons를 이용해서 만들어줘.
예제를 하나 만들어 줘


Q20. 
현재구조에서 index.php?cmd=slow, cmd=attack 두 링크를 만들었어.
slow.php는 단순하게 프로그램 시작하면서 sleep(1) 후 전체 수행 시간을 출력하는
코드로 만들거야.
attack.php에서는 공격 PC개수와, 공격회수를 입력받아서
자바스크립트로 fetch()를 반복적으로 수행하려고 해.
index.php?cmd=slow를 호출하는 거지.

이렇게 해서 DDoS 공격이 성능에 미치는 영향을 측정하는 방법이
절차상으로 옳은 방법인가?

21. 

slow.php 파일을 만들어.
시작할때, 시간을 측정하고 sleep(1) 후, 끝나는 시간을 측정해.
화면에 측정된 시간을 초 단위와 ms 단위로 각각 출력해 주는 코드를 만들어줘.

Q22.

그러면 attack.php를 만들어줘.


Q23. 

다음과 같은 코드가 있는데, 상단에 탭메뉴 형태로 만들고 싶어.
GET으로 sub가 있가 없으면 기본 값이 1이야.
index.php?cmd=log&sub=1

sub=1일 때는 아래 코드를 그대로 사용하고,
sub=2일 때는 최근 log 데이터를 desc 순으로 50개만 가져오도록 바꿔줘.
sub=2일때 하단에 페이지별로 볼 수 있도록 수정해 줘.

    <?php
        $today = Date('Y-m-d'); // 2026-07-01 12:34:56
    ?>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['시간', '클릭수'],

          <?php
            for($i=0; $i<=23; $i++)
            {
                $sql = "select count(*) as cnt from log where time >= '$today $i:00:00' and time <='$today $i:59:59' ";
                $result = mysqli_query($conn, $sql);
                $data = mysqli_fetch_array($result);

                if($data)
                    $cnt = $data['cnt'];
                else
                    $cnt = 0;

                echo "['$i:00', $cnt], ";
            }

          ?>

         
        ]);

        var options = {
          title: '로그 관리',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);

      }
    </script>

 
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
  

    <script>
    setTimeout(function () {
        location.href = "index.php?cmd=log";
    }, 10000);
    </script>


404

enum ErrorCode { 
      Trying = 100, Ringing = 180,
      OK = 200,
      BadRequest = 400,
      AuthError, Forbidden, NotFound, MethodNotAllowed, ...
  }

enum

tElephoneNUM

========================================
Day 4
========================================


IP 주소 정보 웹으로 얻어오기 (마지막에 IP 주소 입력)
http://ip-api.com/json/1.2.3.4

struct, thread, racing condition, 경로조작, Endian,
TCP Header, DDoS --> CPU/Memory 사용율 변화

struct my_struct {
  int   a;
  char  b;
  int   c;
  char  d;
};

typedef unsigned int uint32;
typedef unsigned short uint16;
typedef unsigned char uint8;

gcc -DLE my.c -o my

strcut TCP_H {

#ifdef LE

  uint16 src_port; // 2
  uint16 dst_port; // 2
#else
  uint16 dst_port; // 2
  uint16 src_port; // 2

  uint16 src_port; // 2
#endif

  uint32 seq;     // 4
#ifdef LE
  uint16  offset:4;
  uint16  rsv:6;
  uint16  urg:1;
  unit16  ack:1;
  uint16  push:4;
  uint16 window;
#else
  uint16 window;


#endif

};

0xABCD1234

0x3412CDAB

static int g_couter = 0;
static int flag = 0;

main()
{
  print("%d\n", g_counter);
  plus_thread();
  minus_thread();
  print("%d\n", g_counter);
}


a.jpg

a.jpg%E2php


http://ip-api.com

Q24.

gps.php 파일을 하나 만들고 싶어.
상단에 ip 주소를 입력받는 입력창(type=text)이 있고, 옆에
실행 버튼이 있어.
입력창에 ip주소를 입력하고 실행 하면
http://ip-api.com/json/입력한IP 주소
와 같이 curl로 요청해서 결과를 받아오고 싶어.
가져온 결과가 성공일 때는
화면 하단에 <textarea>를 놓고, 그 안에 가져온 JSON 결과값을
PRETTY 처리해 줘.
index.php?cmd=gps와 같이 실행되서 이미 bootstrap5를 사용 가능한 형태가 되어있어.


google.com/maps?q=36.123,127.123



Q25

이 코드가 정상적으로 잘 동작하고 있어.
예를 들어 1.2.3.4를 입력하는 경우 다음과 같이 JSON을 가져오고 있어.
{
    "status": "success",
    "country": "Australia",
    "countryCode": "AU",
    "region": "QLD",
    "regionName": "Queensland",
    "city": "South Brisbane",
    "zip": "4101",
    "lat": -27.4767,
    "lon": 153.017,
    "timezone": "Australia\/Brisbane",
    "isp": "Resource Quality Assurance",
    "org": "Resource Quality Assurance",
    "as": "",
    "query": "1.2.3.4"
}

이 JSON 데이터를 파싱해서
status, country, lat, lon을 각각 분리해서 변수로 넣고 싶어.
$position = "$lat,$long"; 이렇게 분리도 하고 싶어.

현재코드의 하단에 추가적으로 
표 형태로 파싱된 결과를 출력해 줘.

status : success
county : Australia
위치 : $position <버튼>
버튼을 클릭하면 

google.com/maps?q=$position
을 팝업창으로 띄워.

Q25.

index.php?cmd=log2로 사용할 log2.php 파일을 만들고 싶다.
버튼 하나를 만들고, "시각화"라고 출력해.
이 버튼을 누르면 visual.php 파일을 Full Screen으로 띄우고 싶어.

Q26.

visual.php 파일을 만들거야.
맨 앞은 다음과 같이 DB연결하는 코드가 필요해.

include "db.php";
$conn = connectDB();

log 테이블에서 ip, time정보를 가져오고 싶어.
D3JS의 네트워크 다이어그램을 이용해서 접속한 컴퓨터를 시각화하고 싶어.
즉, 노드와 링크정보가 필요한데,
IP 대역별로 구분하고 싶어.

1.2.3.4, 1.2.3.5 이 있다면
1.2.3 노드가 있고, 1.2.3.4, 1.2.3.5는 1.2.3 노드에 연결하고 싶어.
1.2.3 노드는 Server 라는 노드에 연결하고 싶어.

이렇게 동작하는 data.json 파일을 만들고 싶어.
만약에 data.json 파일이 있으면, 이 파일을 지우고, 다시 만들어줘.

그런데 네트워크 다이그램으로 시각화할때 노드의 크기나 색을 조정하기 위해
ip별로 접속한 회수도 저장해야 돼.
나중에 브러시를 이해해서 시간별 시계열로 그래프를 그릴 거기 때문에
접속 시간 정보가 필요한데, 
맨처음 접속한 시간과 맨 마지막 접속한 시간을 함께 노드에 적어야,
시계열로 확장할 수 있어.

즉, data.json 파일을 만드는 작업을 하도록 하고,
이 작업이 끝나면, D3JS로 data.json파일을 로딩한 후에
네트워크 다이어그램으로 그려줘.
마우스 휠로 확대, 축소를 할 수 있어야 하고,
접속한 횟수가 많아지면, 색을 빨간색으로 하고 싶어.
1~30회까지는 흰색~빨간색으로 스케일링하고, 30회 이상은 모두 빨간색 노드로 
배경을 칠하고 싶어.

화면 하단에는 시간 브러시를 두고, 처음부터 끝까지를 선택한 구간에 맞춰서
데이터를 시각화하고 싶어.
만약 사용자가 시간을 조절하면 해당 구간에 대해서만 시각화해 줘.
기본 시간은 오늘 0시부터 현재까지를 기본 시간으로 해서 화면에 출력해 줘.

Q27. 앞의 코드에서 네트워크 대역별로 1개의 컴퓨터만 있는 경우는
json 파일을 만들때 제외해 줘.

Q28.

첨부한 visual2.php 파일을 이용해서, 코드를 변경하고 싶어.
네트워크 다이어그램으로 그린 결과를 Collapsible tree 형태로 바꿔서 
그릴 수 있도록 코드를 변경해 줘.

Q29.

블랙리스트 관리를 위해 black_table 스키마를 만들고 싶어.
idx (primary key, int, auto_increment),
ip,
time,
rejects int default '0'

이때 rejects는 목록에 추가된 후, 차단되는 회수를 추가할 목적이야.



alter table board add ip char(20) default "10.20.30.40";

CREATE TABLE black_table (
    idx INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(45) UNIQUE NOT NULL,
    time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rejects INT NOT NULL DEFAULT 0,

    UNIQUE KEY uk_ip (ip)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

Q30.

board 테이블에 
alter table board add ip char(20) default "10.20.30.40";
이렇게 ip 필드를 추가했어.

첨부한 board.php파일에서 목록보기를 변경하고 싶어.
만약에 관리자인 경우에는 "블랙리스트 등록" 버튼을 추가해 줘.
이 버튼을 클릭하면,
"블랙리스트로 등록하시겠습니까?"라고 묻고, 확인 하는 경우는

black_table에 추가하고 싶어.
해당 ip와 현재시간을 추가해서 이 테이블에 등록해 줘.
추가된 ip 정보를 처리하는 코드까지 개선해 줘.


Q31.

회원가입 입력하는 join.php 를 만들고 싶어.
index.php?cmd=join처럼 접속해.
현재 users 테이블은 다음과 같이 구성되어 있어.

CREATE TABLE users (
    idx INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(30) NOT NULL,
    pass VARCHAR(50) NOT NULL,
    level INT(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


여기서는 id를 입력했을 때, 4글자 이상이고, 현재 사용 가능 여부를
ajax로 물어보고 싶어.

id에 onKeyUp 이벤트가 발생할 때, 입력한 id를 ajax_check_id.php한테 물어보고 싶어.
4글자 미만이면, "아이디는 4글자 이상입니다."라고 <div>영역 잡아서
출력하고,
사용 가능한 아이디이면, text-success로 "사용 가능합니다."
사용 불가능한 아이디(이미 가입된 아이디)이면 text-danager로 "사용 중인 아이디입니다."라고
출력하고 싶어.

이때, join.php와 ajax_check_id.php 파일을 각각 만들어줘.

Q32. 

dice.php 를 같은 방법으로 만들고 싶어.

사용자의 입력값의 주사위 던지는 회수를 입력받아.
기본값으로는 60을 사용할거야. 실행 버튼을 누르면,
주사위 1~6사이의 랜덤값을 저장해.

dice[1] = 10
dice[2] = 11
dice[3] = 9
..
dice[6] = 11

이와 같은 형태로 배열로 넣으면 갯수를 셀수 있어.
결과가 끝나면 표 형태로 출력해 줘.
주사위 번호, 출현회숫, 비율 형태로 출력해 줘.


=============================================
Day 5
=============================================
jQuery를 위한 라이브러리 추가 되었음.

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

DOM

Q33.

첨부된 log.php 파일의 목록보기에서 페이지네이션으로 보이는데,
전체 페이지가 수 백 페이지를 넘어가니까,
모든 페이지를 출력하고 있어.

각각의 페이지를 그룹으로 나누서
1 2 3 4 5 Next last 

와 같은 형태로 묶고 싶어.
하나의 그룹당 10개씩 묶어서 처리되도록 수정한 후,
다운로드 받을 수 있게 해 줘.

얼굴인식

프로그래밍

main()
{
  int data_i;
  double data_d;
  ip_t  ip_header;

  if(test("hello", pointer) < 0)
  {
    printf("Error\n");

  }

}

int test(char *str, int *ptr)
{
  if(!str)
  {
    printf("Error...");
    return -1;
  }


  ....

  return 1;
}

PHP로 작업을 하고 있는데,
windows11에서 xampp 환경이야.
그런데 CPU, Memory 사용유를 검사하는 resource.php 파일을 만들고 싶어.
필요한 경우에는 파워쉘을 이용해서 수행하고 싶어.

이 파일은 index.php/cmd=resource
이렇게 접속하고, 3초마다 새로고침하고 싶어.
