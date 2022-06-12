<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Review - post</title>
</head>
<body>
    <div class="container">
        <header></header>
        <main>
            <form action="write.php" method="post">
                <table class="table_form">
                    <tr class="item_form">
                        <th>名前</th>
                        <td><input class="input_box" type="text" name="name" placeholder="your name"></td>
                    </tr>
                    <tr class="item_form">
                        <th>Email</th>
                        <td><input class="input_box" type="text" name="mail" placeholder="email address"></td>
                    </tr>
                    <tr class="item_form">
                        <th>映画のタイトル</th>
                        <td><input class="input_box" type="text" name="film_title" placeholder="film title"></td>
                    </tr>
                    <tr class="item_form">
                        <th>映画の評価</th>
                        <td>
                            <select name="film_review">
                                <option value="1">1: 最悪</option>
                                <option value="2">2: イマイチ</option>
                                <option value="3">3: 普通</option>
                                <option value="4">4: 良い</option>
                                <option value="5">5: 最高</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="item_form">
                        <th>コメント</th>
                        <td><textarea name="comment"></textarea></td>
                    </tr>
                    <tr class="item_form">
                        <th></th>
                        <td><input type="submit" value="送信"></td>
                    </tr>
                </table>
            </form>
            <ul>
                <li><a href="index.php">Back to main page...</a></li>
            </ul>
        </main>
        <footer></footer>
    </div>
</body>
</html>