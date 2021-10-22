<?php namespace Codecycler\Passport\Classes\Extend\RainLab\User;

use Laravel\Passport\Client;
use RainLab\User\Controllers\Users;
use Illuminate\Container\Container;
use Codecycler\Passport\Models\Token;
use RainLab\User\Models\User as UserModel;
use Codecycler\Extend\Classes\PluginExtender;
use Laravel\Passport\PersonalAccessTokenFactory;

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

    public function hasMany()
    {
        return [
            'clients' => [
                Client::class,
                'key' => 'user_id',
            ],
            'tokens' => [
                Token::class,
                'key' => 'user_id',
            ],
        ];
    }

    public function properties()
    {
        return [
            'accessToken' => [$this, 'accessToken'],
        ];
    }

    public function methods()
    {
        return [
            'can' => [$this, 'can'],
            'token' => [$this, 'token'],
            'order' => [$this, 'orderBy'],
            'tokenCan' => [$this, 'tokenCan'],
            'scopeOrder' => [$this, 'orderBy'],
            'createToken' => [$this, 'createToken'],
            'withAccessToken' => [$this, 'withAccessToken'],
        ];
    }

    public function addTabFields()
    {
        return [
            'tokens' => [
                'label' => '',
                'tab' => 'Tokens',
                'type' => 'partial',
                'path' => '$/codecycler/passport/partials/tab_tokens.htm',
            ],
        ];
    }

    public function addRelationConfig()
    {
        return [
            'tokens' => [
                'label' => 'token',
                'manage' => [
                    'form' => '$/codecycler/passport/models/token/fields.yaml',
                ],
                'view' => [
                    'showSearch' => true,
                    'list' => '$/codecycler/passport/models/token/columns.yaml',
                    'toolbarButtons' => 'delete',
                    'recordsPerPage' => 10,
                ],
            ],
        ];
    }

    public function orderBy($query)
    {
        $query->orderBy('created_at', 'desc');
    }

    public function token()
    {
        return $this->modelObj->accessToken;
    }

    public function tokenCan($scope)
    {
        return $this->modelObj->can($scope);
    }

    public function createToken($name, array $scopes = [])
    {
        return Container::getInstance()
            ->make(PersonalAccessTokenFactory::class)
            ->make($this->modelObj->getKey(), $name, $scopes);
    }

    public function accessToken()
    {
        return null;
    }

    public function withAccessToken($accessToken)
    {
        $this->modelObj->accessToken = $accessToken;

        $accessToken->last_used = \Carbon\Carbon::now();
        $accessToken->save();

        return $this->modelObj;
    }

    public function can($scope)
    {
        $groups = $this->modelObj->groups()
            ->pluck('code')
            ->toArray();

        if (str_contains($scope, 'group-')) {
            // Check if user is in the group
            return in_array(str_replace('group-', '', $scope), $groups);
        }

        return false;
    }
}
