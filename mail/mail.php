<html>
<head>
    <meta charset="utf-8">
    <title>Ссылка</title>
    <style>
        .c {
            border: 1px solid #333; /* Рамка */
            display: inline-block;
            padding: 5px 15px; /* Поля */
            text-decoration: none; /* Убираем подчёркивание */
            color: #000; /* Цвет текста */
        }
        .c:hover {
            box-shadow: 0 0 5px rgba(0,0,0,0.3); /* Тень */
            background: linear-gradient(to bottom, #fcfff4, #e9e9ce); /* Градиент */
            color: #a00;
        }
    </style>
</head>
<body>
<h1>Welcome to examshop</h1>
<b>Hello <?php echo $user ?> welcome to examshop !</b><br>
<b>To confirm you'r password click on the button !</b><br>
<br>
<a href="http://examfinish.com/site/login?name=<?= $user?>" class="c">Confirm password</a>

</body>
</html>