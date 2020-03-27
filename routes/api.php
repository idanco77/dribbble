<?php

Route::get('/', function () {
    return response()->json(['message' => 'hello world'], 200);
});
