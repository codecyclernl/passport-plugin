<?php namespace Codecycler\Passport\Behaviors;

use Laravel\Passport\Token;
use Laravel\Passport\Client;
use Illuminate\Container\Container;
use October\Rain\Extension\ExtensionBase;
use Laravel\Passport\PersonalAccessTokenFactory;

class HasApiTokens extends ExtensionBase
{
    protected $parent;

    protected $accessToken;

    public function __construct($parent)
    {
        $this->parent = $parent;

        $this->parent->hasMany['clients'] = [
            Client::class,
            'key' => 'user_id',
        ];

        $this->parent->hasMany['tokens'] = [
            Token::class,
            'key' => 'user_id',
            'scope' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
        ];
    }

    public function token()
    {
        return $this->accessToken;
    }

    public function tokenCan($scope)
    {
        return $this->parent->can($scope);
    }

    public function createToken($name, array $scopes = [])
    {
        return Container::getInstance()->make(PersonalAccessTokenFactory::class)->make(
            $this->parent->getKey(), $name, $scopes
        );
    }

    public function withAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this->parent;
    }
}
