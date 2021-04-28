<?php namespace Codecycler\Passport\Classes\Extend\RainLab\User;

use RainLab\User\Controllers\Users;
use RainLab\User\Models\User as UserModel;
use Codecycler\Extend\Classes\PluginExtender;
use Codecycler\Passport\Behaviors\HasApiTokens;

class User extends PluginExtender
{
    public function model()
    {
        return UserModel::class;
    }

    public function controller()
    {
        return Users::class;
    }

    public function extendSubscribe()
    {
        UserModel::extend(function ($model) {
            $implements = $model->implements;
            $implements[] = HasApiTokens::class;
            $model->implement = $implements;
        });
    }
}
