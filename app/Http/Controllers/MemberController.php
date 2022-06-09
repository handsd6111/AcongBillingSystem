<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Throwable;

class MemberController extends Controller
{
    public static function createMember(string $name, string $email, string $phone, string $hashed_password)
    {
        try {
            $id = self::memberIdSerialize();
            $member = Member::firstOrNew([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => $hashed_password,
            ]);
            DB::transaction(function () use ($member) {
                $member->save();
            });
        } catch (Throwable $ex) {
            throw $ex;
        }
    }

    private static function memberIdSerialize()
    {
        date_default_timezone_set("Asia/Taipei"); //設定時區
        $prevMember = Member::orderByDesc('created_at')->first(); //抓到
        $date = substr(date('YzGi'), 1);
        $id = "M$date";
        if (!empty($prevMember)) {
            $hasPrefix = Member::where('id', 'like', "$id%")->count();
            if ($hasPrefix > 0) {
                $prevNumber = substr($prevMember->id, strlen($prevMember->id) - 3, 3);
                $nowNumber = sprintf("%'.03d", intval($prevNumber) + 1);
                $id .= $nowNumber;
            } else {
                $id .= '001';
            }
        } else {
            $id .= '001';
        }
        return $id;
    }
}
