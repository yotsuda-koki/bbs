<?php

require_once('../../App/config.php');

unset($_SESSION['msg']);

?>
<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エラーページ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="error-page text-center my-3">
        <div class="error-content">
            <div class="error-message">
                <h2 class="text-danger">申し訳ありません、何か問題が発生しました。</h2>
                <p>申し訳ありませんが、リクエストの処理中に問題が発生しました。</p>
                <p>後でもう一度お試しください。</p>
            </div>
        </div>
        <div class="error-action">
            <a href="../top/index.php" class="btn btn-outline-primary">戻る</a>
        </div>
    </div>
</body>

</html>