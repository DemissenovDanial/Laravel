<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\IndexController as MainIndexController;
use App\Http\Controllers\Post\IndexController as PostIndexController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Main\IndexController as AdminMainIndexController;
use App\Http\Controllers\Admin\Tag\TagController;
use App\Http\Controllers\Admin\Post\PostController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Personal\Main\IndexController as PersonalIndexController;
use App\Http\Controllers\Post\Main\IndexController as CommentsController;
use App\Http\Controllers\Post\Like\IndexController as LikeIndexController;

Route::group([], function(){
    Route::get('/', [MainIndexController::class, 'index'])->name('main');
});

Route::group(['prefix'=>'posts'], function(){
    Route::get('/', [PostIndexController::class, 'index'])->name('post.index');
    Route::get('/{post}', [PostIndexController::class, 'show'])->name('post.show');

    Route::group(['prefix'=>'{post}/comments'], function(){
        Route::post('/', [CommentsController::class, 'store'])->name('post.comment.store');
    });

    Route::group(['prefix'=>'{post}/likes'], function(){
        Route::post('/', [LikeIndexController::class, 'store'])->name('post.like.store');
    });
});

Route::group(['prefix' => 'personal', 'middleware' => 'verified'], function(){
    Route::get('/', [PersonalIndexController::class, 'index'])->name('personal');
    Route::get('/liked', [PersonalIndexController::class, 'liked'])->name('liked');
    Route::delete('/{post}', [PersonalIndexController::class, 'delete'])->name('delete');
    Route::group(['prefix' => 'comments'], function(){
        Route::get('/', [PersonalIndexController::class, 'comment'])->name('comment');
        Route::get('/{comment}/edit', [PersonalIndexController::class, 'editComment'])->name('personal.comment.edit');
        Route::patch('/{comment}', [PersonalIndexController::class, 'updateComment'])->name('personal.comment.update');
        Route::delete('/{comment}', [PersonalIndexController::class, 'deleteComment'])->name('personal.comment.delete');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'verified'], function(){
    Route::get('/', [AdminMainIndexController::class, 'index'])->name('admin');

    Route::prefix('posts')->group(function() {
        Route::get('/', [PostController::class, 'index'])->name('admin.post.index');
        Route::get('/create', [PostController::class, 'create'])->name('admin.post.create');
        Route::post('/', [PostController::class, 'store'])->name('admin.post.store');
        Route::get('/{post}', [PostController::class, 'show'])->name('admin.post.show');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('admin.post.edit');
        Route::patch('/{post}', [PostController::class, 'update'])->name('admin.post.update');
        Route::delete('/{post}', [PostController::class, 'delete'])->name('admin.post.delete');
    });

    Route::prefix('categories')->group(function() {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('admin.category.show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::patch('/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/{category}', [CategoryController::class, 'delete'])->name('admin.category.delete');
    });

    Route::prefix('tags')->group(function() {
        Route::get('/', [TagController::class, 'index'])->name('admin.tag.index');
        Route::get('/create', [TagController::class, 'create'])->name('admin.tag.create');
        Route::post('/', [TagController::class, 'store'])->name('admin.tag.store');
        Route::get('/{tag}', [TagController::class, 'show'])->name('admin.tag.show');
        Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('admin.tag.edit');
        Route::patch('/{tag}', [TagController::class, 'update'])->name('admin.tag.update');
        Route::delete('/{tag}', [TagController::class, 'delete'])->name('admin.tag.delete');
    });

    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('admin.user.show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::patch('/{user}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/{user}', [UserController::class, 'delete'])->name('admin.user.delete');
    });
});

Auth::routes(['verify' => true]);
