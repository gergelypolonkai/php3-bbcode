<html>
    <head>
        <title>bbCode test</title>
        <style>
            span.b {
                font-weight: bold;
            }

            span.i {
                font-style: italic;
            }

            span.u {
                text-decoration: underline;
            }

            a {
                text-decoration: none;
                font-weight: bold;
                color: green;
            }
        </style>
    </head>
    <body>
<?php
    include("class.bbcode.php");

    $bbcode = new bbcode;
    $bbcode->register_smiley(":)", "smileys/smile.gif");
    echo $bbcode->decode(file_get_contents("test.bbcode"));
?>
    </body>
</html>

