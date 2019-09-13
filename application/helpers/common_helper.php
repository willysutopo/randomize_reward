<?php
if (!function_exists('helper_get_rewards'))
{
    function helper_get_rewards($from, $to, $multiplier)
    {
        $minReward = rand($from, $to);
        $maxReward = rand($minReward, $to);
        $actualReward = rand($minReward, $maxReward);
        return [
            'min' => $minReward * $multiplier,
            'max' => $maxReward * $multiplier,
            'reward' => $actualReward * $multiplier
        ];
    }
}

if (!function_exists('helper_check_date_format'))
{
    function helper_check_date_format($date) {
        if (preg_match("/[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3(0|1))/", $date)) {
            if (checkdate(substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4)))
                return true;
        }
        return false;
    }
}
?>
