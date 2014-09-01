# BigMergely
**An online diff/merge application**

Mergely is an online diff/merge editor and Javascript library that highlights changes in similar texts.

It can be used within your own web application to compare files, text, C, C++, Java, HTML, XML, CSS,, Javascript and PHP files.

This project was forked from wickedst/Mergely

**diffy.php**

diffy.php allows you to compare and merge large groups of PHP files and write the merged files to another directory. 

This script looks for comparable files in the default/ and custom/ folders, then checks to see if there is a filesize difference for each file. If there are two comparable files of different sizes, the script adds them to an array in groups of 10. You can access each group by including a get var at the end of the uri. example: diffy.php?group=2

** It is recommended you only run diffy.php on a non-production local site **
