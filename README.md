A functional disease predictor website that predicts diseases based on user inputs (upto 8) with 97% accuracy using KNN. Complete with a login and registration page coded in PHP, HTML, CSS and JavaScript using MySQL for storage on local. Technologies used in the project: HTML, CSS, JavaScript, PHP, MySQL, Python, Machine Learning and Flask.

- To view the website without login, go to index.html, change the line "/login" to "/home" in:

        <script> function SameTab() { window.location.href = "/login"; } </script>

- To experience the login system, you must have XAMPP with PHP and MySQL support, create a database and table in phpMyAdmin and modify the code in db.php to the credentials and table name you have set up in your MySQL.
- You must also change the path to db.php in login.php and register.php to the current folder where db.php is present in the "include() statement".
