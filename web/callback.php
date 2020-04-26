<?php
$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');


//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);

//ReplyToken取得
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

// イベント種別（今回は2種類のみ）
// message（メッセージが送信されると発生）
// postback（ポストバックオプションに返事されると送信）
// join (グループに参加)
$type = $jsonObj->{"events"}[0]->{"type"};
        
//userId
$userId = $jsonObj->{"events"}[0]->{"source"}->{"userId"};

    
if($type == 'message') {
    
    // メッセージオブジェクト
    // text（テキストを受け取った時）
    // sticker（スタンプを受け取った時）
    $msg_obj = $jsonObj->{"events"}[0]->{"message"}->{"type"};
    
    //メッセージ取得
    $text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
    
    //スタンプID取得
    $packageId = $jsonObj->{"events"}[0]->{"message"}->{"packageId"};
    
    if($msg_obj == "text"){
        if ($text == 'こうぺんちゃん'){
            $response_format_text = array(
                array(
                    'type' => 'text',
                    'text' => 'こうぺんちゃんかわいいよね〜'
                )
            );
        } else {
            $response_format_text = array(
                array(
                    'type'     => 'template',
                    'altText'  => '使い方',
                    'template' => array(
                        'type'    => 'buttons',
                        'title'   => '使い方' ,
                        'text'    => '以下のボタンを押してみてください',
                        'actions' => array(
                            array(
                                'type'  => 'message',
                                'label' => 'こうぺんちゃん',
                                'text'  => 'こうぺんちゃん'
                            ),
                            array(
                                'type'  => 'uri',
                                'uri' => 'http://www.koupenchan-store.jp/',
                                'label'  => 'ホームページ'
                            ),
                            array(
                                'type'  => 'uri',
                                'uri' => 'https://twitter.com/k_r_r_l_l_',
                                'label'  => 'Twitter'
                            )
                        )
                    )
                )
            );
        }
    } else if($msg_obj == "sticker"){
        if ($packageId == 3379511) {
            $response_format_text = array(
                array(
                    'type' => 'text',
                    'text' => 'こうぺんちゃんかわいい〜'
                )
            );
        } else if (in_array($packageId ,array(1477082,1494952,1507867,1716722,4100278))) {
            $response_format_text = array(
                array(
                    'type' => 'text',
                    'text' => 'いいスタンプ持ってますね！'
                )
            );
        } else {
            $response_format_text = array(
                array(
                    'type' => 'text',
                    'text' => 'こうぺんちゃんのスタンプを送ってみてね！'
                ),
                array(
                    'type'     => 'template',
                    'altText'  => 'スタンプ例',
                    'template' => array(
                        'type'    => 'buttons',
                        'thumbnailImageUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/main.png',
                        'text'    => 'こんなのがあります',
                        'actions' => array(
                            array(
                                'type'  => 'uri',
                                'uri' => 'https://line.me/R/shop/sticker/detail/3379511',
                                'label'  => 'なかよし！コウペンちゃん'
                            ),
                            array(
                                'type'  => 'uri',
                                'uri' => 'https://line.me/R/shop/sticker/detail/9823',
                                'label'  => 'うごく！コウペンちゃん'
                            ),
                            array(
                                'type'  => 'uri',
                                'uri' => 'https://line.me/R/shop/sticker/detail/7824781',
                                'label'  => '夏とコウペンちゃん'
                            )
                        )
                    )
                )
            );
        }
    } else {
        exit;
    }

}

$post_data = array(
	"replyToken" => $replyToken,
	"messages" => $response_format_text
);

$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
    ));
$result = curl_exec($ch);
curl_close($ch);
