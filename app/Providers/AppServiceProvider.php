<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\UserObserver;
use App\Observers\TopicObserver;
use App\Observers\ReplyObserver;
use App\Observers\LinkObserver;
use App\Models\User;
use App\Models\Topic;
use App\Models\Reply;
use App\Models\Link;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);//设置mysql版本低的
        \Carbon\Carbon::setLocale('zh');
        //为User模型注册观察者
         \App\Models\User::observe(\App\Observers\UserObserver::class);
        Topic::observe(TopicObserver::class);
        Reply::observe(ReplyObserver::class);
        Link::observe(LinkObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
    }
}
