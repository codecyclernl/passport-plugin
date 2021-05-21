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

            $model->addDynamicMethod('can', function ($scope) use ($model) {
                $groups = $model->groups()
                    ->pluck('code')
                    ->toArray();

                if (str_contains($scope, 'group-')) {
                    // Check if user is in the group
                    return in_array(str_replace('group-', '', $scope), $groups, true);
                }

                return false;
            });
        });
    }
}
