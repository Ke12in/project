<?php
function generateReferralCode($length = 8) {
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

$user_referral_code = generateReferralCode();
?>
