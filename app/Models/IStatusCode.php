<?php

namespace App\Models;

interface IStatusCode {
    const OK = 200; //請求成功。
    const Created = 201; //成功建立一筆資料。
    const Bad_Request = 400; //使用者輸入錯誤或不合法的要求。
    const Unauthorized = 401; //表示無法存取此資源，Jwt過期也包含在內。
    const Forbidden = 403; //禁止訪問，知道使用者是誰，但他無權存取這個資源。
    const Interal_Server_Error = 500; //伺服器內部錯誤。
    const Message = [
        200 => 'Your request was successful.',
        201 => 'You created a data successfully.',
        400 => 'Your input is illegal or wrong.',
        401 => "Your token has expired or empty.",
        403 => "You don't have permission to access.",
        500 => 'This Server has some error.',
    ];
}