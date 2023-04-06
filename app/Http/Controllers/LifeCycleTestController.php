<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{

    public function showServiceProviderTest()
    {
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');

        $sample = app()->make('serviceProviderTest');


        dd($sample,$password,$encrypt->decrypt($password));
    }

    // サービスコンテナのテスト
    public function showServiceContainerTest()
    {
        app()->bind('lifeCycleTest', function () {
            return 'ライフサイクルのテスト';
        });


        $test = app()->make('lifeCycleTest');

        // サービスコンテナ無しの場合
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();

        // サービスコンテナapp()ありの場合
        app()->bind('sample', Sample::class);
        $sample = app()->make('sample');
        $sample->run();


        dd($test, app());
    }
}


// 複数のclassの依存関係を解決
class Sample
{

    public $message;
    // DI...引数の中にclassを指定すると自動でインスタンスを生成
    public function __construct(Message $message)
    {

        $this->message = $message;

    }

    public function run()
    {
        $this->message->send();
    }

}

class Message
{
    public function send()
    {
        echo 'メッセージ表示';
    }
}
