<?php

namespace App\Providers;
use App\Models\BagItemType;
use App\Models\Experiment;
use App\User;
use App\Models\GameParameter;
use App\Models\GameInstance;
use App\Models\Game;

use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['game_badges.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['reward_day_items.fields'], function ($view) {
            $bag_item_typeItems = BagItemType::pluck('name','id')->toArray();
            $view->with('bag_item_typeItems', $bag_item_typeItems);
        });
        View::composer(['bag_item_types.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['reward_items.fields'], function ($view) {
            $experimentItems = Experiment::pluck('name','id')->toArray();
            $view->with('experimentItems', $experimentItems);
        });
        View::composer(['experiment_entrypoints.fields'], function ($view) {
            $experimentItems = Experiment::pluck('name','id')->toArray();
            $view->with('experimentItems', $experimentItems);
        });
        View::composer(['user_entrypoints.fields'], function ($view) {
            $experimentItems = Experiment::pluck('name','id')->toArray();
            $view->with('experimentItems', $experimentItems);
        });
        View::composer(['user_experiments.fields'], function ($view) {
            $experimentItems = Experiment::pluck('name','id')->toArray();
            $view->with('experimentItems', $experimentItems);
        });
        View::composer(['user_experiments.fields'], function ($view) {
            $userItems = User::pluck('name','id')->toArray();
            $view->with('userItems', $userItems);
        });
        View::composer(['user_experiments.fields'], function ($view) {
            $experimentItems = Experiment::pluck('name','id')->toArray();
            $view->with('experimentItems', $experimentItems);
        });
        View::composer(['user_experiments.fields'], function ($view) {
            $userItems = User::pluck('name','id')->toArray();
            $view->with('userItems', $userItems);
        });
        View::composer(['user_experiments.fields'], function ($view) {
            $experimentItems = Experiment::pluck('name','id')->toArray();
            $view->with('experimentItems', $experimentItems);
        });
        View::composer(['user_experiments.fields'], function ($view) {
            $userItems = User::pluck('name','id')->toArray();
            $view->with('userItems', $userItems);
        });
        View::composer(['user_experiments.fields'], function ($view) {
            $experimentItems = Experiment::pluck('name','id')->toArray();
            $view->with('experimentItems', $experimentItems);
        });
        View::composer(['user_experiments.fields'], function ($view) {
            $userItems = User::pluck('name','id')->toArray();
            $view->with('userItems', $userItems);
        });
        View::composer(['game_instance_parameters.fields'], function ($view) {
            $game_parameterItems = GameParameter::pluck('name','id')->toArray();
            $view->with('game_parameterItems', $game_parameterItems);
        });
        View::composer(['game_instance_parameters.fields'], function ($view) {
            $game_instanceItems = GameInstance::pluck('name','id')->toArray();
            $view->with('game_instanceItems', $game_instanceItems);
        });
        View::composer(['game_parameters.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['game_instances.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['game_instances.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['game_instances.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['game_instances.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['game_instances.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['game_instances.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['games.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['games.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        View::composer(['game_instances.fields'], function ($view) {
            $gameItems = Game::pluck('name','id')->toArray();
            $view->with('gameItems', $gameItems);
        });
        //
    }
}