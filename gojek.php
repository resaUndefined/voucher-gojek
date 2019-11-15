<?php

error_reporting(0);
if (!file_exists('token')) {
    mkdir('token', 0777, true);
}

include ("curl.php");
echo "\n";
echo "\e[94m          Voucher Claim Gojek           \n";
echo "\e[91m FORMAT NOMOR HP : INDONESIA '62***' , US='1***'\n";
echo "\e[93m SCRIPT GOJEK AUTO REGISTER + AUTO CLAIM VOUCHER\n";
echo "\e[93m findMe : http://resa.aijogja.com/\n";
echo "\e[93m Github: resaUndefined \n";
echo "\n";
echo "\e[96m[?] Masukkan Nomor HP Anda (62/1) : ";
$nope = trim(fgets(STDIN));
$register = register($nope);
if (!$register){
    echo "\e[91m[x] Nomor Telah Terdaftar\n";
}else{
    otp:
    echo "\e[96m[!] Masukkan Kode Verifikasi (OTP) : ";
    $otp = trim(fgets(STDIN));
    $verif = verif($otp, $register);
    if (!$verif){
        echo "\e[91m[x] Kode Verifikasi Salah\n";
        goto otp;
    }else{
        file_put_contents("token/".$verif['data']['customer']['name'].".txt", $verif['data']['access_token']);
        echo "\e[93m[!] Mencoba untuk meredeem Voucher : GOFOODBOBA07 !\n";
        sleep(3);
        $claim = claim($verif);
        if (!$claim){
            echo "\e[92m[!]".$voucher."\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : GOFOODBOBA10 !\n";
            sleep(3);
            goto next;
        }else{
            echo "\e[92m[+] ".$claim."\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : COBAINGOJEK !\n";
            sleep(3);
            goto ride;
        }
        next:
        $claim = claim1($verif);
        if (!$claim) {
            echo "\e[92m[!]".$claim['errors'][0]['message']."\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : GOFOODBOBA19 !\n";
            sleep(3);
            goto next1;
        }else{
            echo "\e[92m[+] ".$claim."\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : COBAINGOJEK !\n";
            sleep(3);
            goto ride;
        }
        next1:
        $claim = claim2($verif);
        if (!$claim) {
            echo "\e[92m[!]".$claim['errors'][0]['message']."\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : COBAINGOJEK !\n";
            sleep(3);
            goto next2;
        }else{
            echo "\e[92m[+] ".$claim . "\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : COBAINGOJEK !\n";
            sleep(3);
            goto ride;
        }
        next2:
        $claim = claim3($verif);
        if (!$claim) {
            echo "\e[92m[!]".$claim['errors'][0]['message']."\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : gofoodsantai19 !\n";
            sleep(3);
            goto ride;
        }else{
            echo "\e[92m[+] ".$claim . "\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : COBAINGOJEK !\n";
            sleep(3);
            goto ride;
        }
        ride:
        $claim = ride($verif);
        if (!$claim) {
            echo "\e[92m[!]".$claim['errors'][0]['message']."\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : AYOCOBAGOJEK !\n";
            sleep(3);
        }else{
            echo "\e[92m[+] ".$claim."\n";
            sleep(3);
            echo "\e[93m[!] Mencoba untuk meredeem Voucher : AYOCOBAGOJEK !\n";
            sleep(3);
            goto pengen;
        }
        pengen:
        $claim = cekvocer($verif);
        if (!$claim) {
            echo "\033VOUCHER TIDAK VALID/REDEEM GAGAL\n";
        }else{
            echo "\e[92m[+] ".$claim."\n";
        }
    }
}
?>
