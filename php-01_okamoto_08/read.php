<?php
$file = "data/data.csv";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Review - View All</title>
    <style>
      table {
        border-collapse: collapse;
      }
      td {
        border: solid 1px black;
        padding: 3px;
      }
    </style>
</head>
<body>
    <div class="container">
        <header></header>
        <main>
            <ul>
                <table>
                    <tr>
                        <td>登録日時</td>
                        <td>登録者名</td>
                        <td>登録者Email</td>
                        <td>映画のタイトル</td>
                        <td>映画の評価</td>
                        <td>コメント</td>
                    </tr>
                <?php
                if(($handle = fopen($file, "r")) !== FALSE){
                    while(($data = fgetcsv($handle, 1000,",",'"')) !== FALSE){
                        echo "\t<tr>\n";
                        for($i=0; $i < count($data); $i++){
                            echo"\t\t<td>{$data[$i]}</td>\n";
                        }
                        echo "\t</tr>\n";
                    }
                    fclose($handle);
                }
                ?>
                </table>
            </ul>
            <ul>
                <li><a href="index.php">Back to main page...</a></li>
            </ul>
        </main>
        <footer></footer>
    </div>
</body>
</html>