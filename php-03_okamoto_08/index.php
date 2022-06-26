<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>書籍登録</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <nav class="area_nav_header">
                <ul class="list_nav_header">
                <a class="item_nav_header" href="index.php"><li>書籍登録</li></a>
                <a class="item_nav_header" href="select.php"><li>書籍一覧</li></a>
                </ul>
            </nav>
        </header>
        <main>
            <form method="post" action="insert.php">
                <table class="table_form">
                    <tr class="item_form">
                        <th>書籍名</th>
                        <td><input class="input_box" type="text" name="book_name" placeholder="Title of the book" maxlength="64" required></td>
                    </tr>
                    <tr class="item_form">
                        <th>書籍URL</th>
                        <td><input class="input_box" type="url" name="book_url" placeholder="URL of the book" required></td>
                    </tr>
                    <tr class="item_form">
                        <th>書籍コメント</th>
                        <td><textarea name="book_comment" placeholder="add your comment"></textarea></td>
                    </tr>
                </table>
                <input type="submit" value="送信">
            </form>
        </main>
        <footer>
        </footer>
    </div>
</body>
</html>
