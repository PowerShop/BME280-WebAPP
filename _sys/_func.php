<?php

function rdr($page, $time)
{
    echo "<script type=\"text/javascript\">
            setTimeout(function() {
            location.href = \"$page\";   
            }, $time);
        </script>";
}

function query($sql, $array = array())
{
    global $api;
    $q = $api->sql->prepare($sql);
    $q->execute($array);
    return $q;
}

function encode($password)
{
    $en = hash('sha256', $password);
    return $en;
}

function alert($text)
{
    echo "<script type=\"text/javascript\">
            alert(\"$text\");
        </script>";
}

// Sweet alert 2 function
function swal($title, $text, $icon, $button, $timer = 0, $url = null)
{
    echo "<script type=\"text/javascript\">
            Swal.fire({
                title: '$title',
                text: '$text',
                icon: '$icon',
                confirmButtonText: '$button'

            }).then((result) => {
                if (result.isConfirmed) {
                    if ('$url' !== null) {
                        setTimeout(function() {
                            location.href = '$url';
                        }, $timer);
                    } else {
                        location.reload();
                    }
                }
            });
        </script>";
}

function runEveryMinute($callback)
{
    $callback();
    sleep(60);
}





