<?php
function parsePage(int $page) {
    $link = "https://www.rond.ir/SearchSimSale?page=" . $page;
    $data = file_get_contents($link);
    // $data = file_get_contents("cache-page1.html");
    // print $data;

    $pattern = '/<tr class=(evendTr|odTr)>(.*?)<\/tr>/si';
    preg_match_all($pattern, $data, $matches);
    // print_r($matches[2]);
    foreach ($matches[2] as $row_item) {
        // print $row_item;

        $pattern = '/>([0-9 ]+)<\/a>/si';
        preg_match($pattern, $row_item, $phone_match);
        // print_r($phone_match);

        $pattern = '/<span>([0-9,]+)<\/span>/si';
        preg_match($pattern, $row_item, $price_match);
        // print_r($price_match);

        if (isset($phone_match[1])) {
            $phone = str_replace(" ", "", $phone_match[1]);

            $price = null;
            if (isset($price_match[1])) {
                $price = str_replace(",", "", $price_match[1]);
            }

            print "$phone\t$price\n";
        } else {
            continue;
        }
        // break;
    }
}

// Main
for ($i = 1; $i <= 8; $i++) {
    parsePage($i);
    // break;
}
