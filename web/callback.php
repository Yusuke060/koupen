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


if($type == 'join') {
    $response_format_text = array(
        array(
            'type'     => 'template',
            'altText'  => 'ようこそ',
            'template' => array(
                'type'    => 'confirm',
                'text'   => 'ご存知ですか？',
                'actions' => array(
                    array(
                        'type'  => 'postback',
                        'label' => '知ってる！',
                        'data'  => 'shitteru'
                    ),
                    array(
                        'type'  => 'postback',
                        'label' => 'しらない',
                        'data'  => 'hatsumimi'
                    )
                )
            )
        )
    );
}
    
if($type == 'message') {
    
    // メッセージオブジェクト（今回は4種類のみ）
    // text（テキストを受け取った時）
    // sticker（スタンプを受け取った時）
    // image（画像を受け取った時）
    // location（位置情報を受け取った時）
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
        }
        
        
        
        
        
        
        
        else if ($text == 'スタンプ') {
            $response_format_text = array(
                array(
                    'type'      => 'sticker',
                    'packageId' => 1,
                    'stickerId' => 1
                )
            );
        } else if ($text == '写真') {
            $response_format_text = array(
                array(
                    'type'      => 'image',
                    'originalContentUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/img1.jpg',
                    'previewImageUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/img2-3.jpg'
                )
            );
        } else if ($text == '動画') {
            $response_format_text = array(
                array(
                    'type'               => 'video',
                    'originalContentUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/kourin.mp4',
                    'previewImageUrl'    => 'https://' . $_SERVER['SERVER_NAME'] . '/kourin.jpg'
                )
            );
        } else if ($text == 'ボタン') {
            $response_format_text = array(
                array(
                    'type'     => 'template',
                    'altText'  => 'ボタンテスト',
                    'template' => array(
                        'type'    => 'buttons',
                        'thumbnailImageUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/kourin.jpg',
                        'title'   => 'ボタンタイトル' ,
                        'text'    => 'テキストメッセージ。タイトルがないときは最大160文字、タイトルがあるときは最大60文字',
                        'actions' => array(
                            array(
                                'type'  => 'message',
                                'label' => 'ラベル1',
                                'text'  => 'アクションメッセージ1'
                            ),
                            array(
                                'type'  => 'uri',
                                'uri' => 'https://' . $_SERVER['SERVER_NAME'] . '/',
                                'label'  => 'ホームページ'
                            ),
                            array(
                                'type'  => 'datetimepicker',
                                'label' => '日時',
                                'data'  => 'datetemp',
                                'mode'  => 'date'
                            )
                        )
                    )
                )
            );
        } else if ($text == '確認') {
            $response_format_text = array(
                array(
                    'type'     => 'template',
                    'altText'  => '確認テスト',
                    'template' => array(
                        'type'    => 'confirm',
                        'text'   => '確認タイトル',
                        'actions' => array(
                            array(
                                'type'  => 'postback',
                                'label' => '参加',
                                'data'  => 'sanka'
                            ),
                            array(
                                'type'  => 'postback',
                                'label' => '不参加',
                                'data'  => 'fusanka'
                            )
                        )
                    )
                )
            );
        } else if ($text == 'カルーセル') {
            $response_format_text = array(
                array(
                    'type'     => 'template',
                    'altText'  => 'カルーセルテスト',
                    'template' => array(
                        'type'    => 'carousel',
                        'columns' => array(
                            array(
                                'thumbnailImageUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/kourin.jpg',
                                'title'   => 'カルーセルタイトル1',
                                'text'    => 'タイトルか画像がある場合は最大60文字、どちらもない場合は最大120文字',
                                'actions' => array(
                                    array(
                                        'type'  => 'uri',
                                        'uri' => 'https://line.me/R/nv/profile',
                                        'label'  => 'プロフィール'
                                    )
                                )
                            ),
                            array(
                                'thumbnailImageUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/kourin.jpg',
                                'title'   => 'カルーセルタイトル2',
                                'text'    => 'タイトルか画像がある場合は最大60文字、どちらもない場合は最大120文字',
                                'actions' => array(
                                    array(
                                        'type' => 'message',
                                        'label' => 'ラベルです',
                                        'text' => 'メッセージ'
                                    )
                                )
                            )
                        )
                    )
                )
            );
        } else if ($text == '画像カルーセル') {
            $response_format_text = array(
                array(
                    'type'     => 'template',
                    'altText'  => '画像カルーセルテスト',
                    'template' => array(
                        'type'    => 'image_carousel',
                        'columns' => array(
                            array(
                                'imageUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/kourin.jpg',
                                'action' => array(
                                    'type' => 'message',
                                    'label' => 'ラベル1',
                                    'text' => 'メッセージ1'
                                )
                            ),
                            array(
                                'imageUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/kourin.jpg',
                                'action' => array(
                                    'type' => 'message',
                                    'label' => 'ラベル2',
                                    'text' => 'メッセージ2'
                                )
                            )
                        )
                    )
                )
            );
        } else {
            $response_format_text = array(
                array(
                    'type' => 'text',
                    'text' => 'こうぺんちゃんのスタンプを送ってみてね！'
                ),
                array(
                    'type' => 'text',
                    'text' => '持ってなかったらぜひ買ってね！！'
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

}else if($type == 'postback') {
    // 送られたデータ
    $postback = $jsonObj->{'events'}[0]->{'postback'}->{'data'};
    
    $response_format_text = array(
        array(
            'type' => 'text',
            'text' => 'こんにちは！'
        )
    );
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
