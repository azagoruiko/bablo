<html>
    <head>
        <title>Здесь будет много баблища!!!!111</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
        <script src="js/js.js"></script>
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-inverse">
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="./">Главная</a></li>
                        <li><a href="?ctrl=user&action=showUser">Юзер</a></li>
                        <li><a href="?ctrl=income&action=addIncome">Добавить бабла</a></li>
                        <li><a href="?ctrl=user&action=login">Войти</a></li>
                        <li><a href="?ctrl=income&action=incomes">Бабло</a></li>
                        <li><a href="?ctrl=expence&action=expences">Траты</a></li>
                        <li><a href="?ctrl=income&action=balance">Баланс</a></li>
                        <li><a href="?ctrl=currency&action=setRates">Курсы валют</a></li>
                        <li><a href="?ctrl=user&action=logout">Выйти</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">

            <header>
                
            </header>
            <?php $this->view() ?> 
            <footer>
                <p>&copy; 2014 - Computer Academy STEP, Donetsk</p>
            </footer>
        </div>

    </body>
</html>

