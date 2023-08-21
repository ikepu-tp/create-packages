<?php

use ikepu_tp\AccessLogger\app\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;
use ikepu_tp\LaravelAdmin\app\Http\Controllers\UserController;
use ikepu_tp\LaravelAdmin\app\Http\Middleware\AdminMiddleware;

Route::group([
    "middleware" => [
        "web",
        "auth:" . config("laravel-admin.gurad", "web"),
        AdminMiddleware::class,
    ],
    "prefix" => config("laravel-admin.prefix", ""),
], function () {
    Route::resource("users", UserController::class)->names("laravelAdmin.user")->only(["index", "update"]);
    Route::resource("logs", LogController::class)->names("accessLogger")->only(["index",]);
});