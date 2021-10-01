<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Job Checker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <br>
    <img src="https://img-guru.com/20210930.1/images/Guru-logo2.png">
    <br><br>
    <div class="item-container">

    </div>
</div>

<script>
    Notification.requestPermission();
    let first_title = '';

    function perform_check() {
        $.ajax({
            url: "functions.php",
            method: "POST",
            data: {first_title: first_title},
            success: function(result) {
                if (!result) return;

                let item_container = $('.item-container');
                item_container.html('');
                result = JSON.parse(result);

                for (let i=0; i<result.length; i++) {
                    let item_html = '<div class="item">'
                        + '<h4><a href="' + result[i].link + '" target="_blank">' + result[i].title + '</a></h4>'
                        + '<h6>' + result[i].pubDate + '</h6>'
                        + '<p>' + result[i].description + '</p></div>';

                    item_container.append(item_html);

                    if (i === 0 && result[i].title !== first_title) {
                        if (Notification.permission === "granted") {
                            let notification = new Notification('Guru New Job',{
                                body: result[i].title,
                                icon: 'https://img-guru.com/20210930.1/images/Guru-logo2.png',
                            });
                            notification.onclick = function(event) {
                                event.preventDefault();
                                window.open(result[i].link, '_blank');
                            }
                        }

                        first_title = result[i].title;
                    }
                }
            }
        });
    }

    setInterval(perform_check, 60000);
</script>
</body>
</html>
