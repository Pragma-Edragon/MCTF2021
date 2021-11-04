<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<style>
    body {
        background: #111;
        color: #127E32;
        font-family: Consolas, Courier, monospace;
        font-size: 60px;
        text-shadow: 0 0 15px #127E32;
        height: 100%;
    }

    .glow {
        color: #02C83E;
        text-shadow: 0px 0px 10px #02D943;
    }

    span {
        display: inline-block;
        padding: 0 10px;
    }
</style>

<div class="container" style="display: flex; justify-content: center; align-items: center; height: 100vh">
    Hello, <div id="loading"> {{ $name  }}</div>  and welcome...
</div>

<script>
    alphabet = new Array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    letter_count = 0;
    el = $("#loading");
    word = el.html().trim();
    finished = false;

    el.html("");
    for (var i = 0; i < word.length; i++) {
        el.append("<span>"+word.charAt(i)+"</span>");
    }

    setTimeout(write, 75);
    incrementer = setTimeout(inc, 1000);

    function write() {
        for (var i = letter_count; i < word.length; i++) {
            var c = Math.floor(Math.random() * 36);
            $("span")[i].innerHTML = alphabet[c];
        }
        if (!finished) {
            setTimeout(write, 75);
        }
    }

    function inc() {
        $("span")[letter_count].innerHTML = word[letter_count];
        $("span:eq("+letter_count+")").addClass("glow");
        letter_count++;
        if (letter_count >= word.length) {
            finished = true;
            setTimeout(reset, 1500);
        } else {
            setTimeout(inc, 1000);
        }
    }

    function reset() {
        letter_count = 0;
        finished = false;
        setTimeout(inc, 1000);
        setTimeout(write, 75);
        $("span").removeClass("glow");
    }
</script>

</body>
</html>

