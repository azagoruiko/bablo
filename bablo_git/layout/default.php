<html>
    <head>
        <title>Здесь будет много баблища!!!!111</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="js/main.js"></script>
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="">Главная</a></li>
                        <li><a href="?action=showUser">Юзер</a></li>
                        <li><a href="?action=addIncome">Добавить бабла</a></li>
                        <li><a href="?action=login">Войти</a></li>
                        <li><a href="?action=incomes">Бабло</a></li>
                        <li><a href="?action=expences">Траты</a></li>
                        <li><a href="?action=balance">Баланс</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="jumbotron">
                <header>
                    <h1>Страница с баблом</h1>
                </header>
                <?php $this->view() ?> 
                <footer>мыло, контакты и прочее...</footer>
            </div>
        </div>
    </body>
</html>

