<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <nav class="area_nav_header">
                <ul class="list_nav_header">
                </ul>
            </nav>
        </header>
        <main>
            <form method="post" action="login_act.php">
                <table class="table_form">
                    <tr class="item_form">
                        <th>ID</th>
                        <td><input class="input_box" type="text" name="lid" maxlength="64" required></td>
                    </tr>
                    <tr class="item_form">
                        <th>PW</th>
                        <td><input class="input_box" type="password" name="lpw" required></td>
                    </tr>
                </table>
                <input type="submit" value="LOGIN">
            </form>
        </main>
        <footer>
        </footer>
    </div>
</body>
</html>