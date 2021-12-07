<?php

$age = 19;
if ($age < 7) {
    echo "Вы дошкольник";
} else if (($age > 6) and ($age < 19)) {
    echo "Вы в школе";
} else {
    echo "Закончили школу";
}