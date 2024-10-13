<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $captcha = curl_init("https://marvinmc.dev/captcha/json");
    curl_setopt($captcha, CURLOPT_RETURNTRANSFER, true);
    $captcha = json_decode(curl_exec($captcha), true);

    echo '<form method="POST">
            <input name="captcha-id" value="' . $captcha["id"] . '" hidden/>
            <input name="captcha-code" type="text" placeholder="000000" required />
            <img src="'.$captcha["images"]['png'].'" />
            <button type="submit">Send</button>
          </form>';
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $captchaId = $_POST["captcha-id"];
    $captchaCode = $_POST["captcha-code"];
    $captchaCurl = curl_init("https://marvinmc.dev/captcha/verify/json?id=$captchaId&code=$captchaCode");
    curl_setopt($captchaCurl, CURLOPT_RETURNTRANSFER, true);
    $captcha = json_decode(curl_exec($captchaCurl), true);
    curl_close($captchaCurl);
    if (!$captcha["solved"]) {
        exit("wrong captcha");
    }
    echo "Your code if captcha is solved";
}
?>
