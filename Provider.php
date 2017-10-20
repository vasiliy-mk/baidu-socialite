<?php

namespace Vasiliy\Baidu;

use SocialiteProviders\Manager\OAuth2\User;
use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'BAIDU';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [];

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'http://openapi.baidu.com/oauth/2.0/authorize', $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://openapi.baidu.com/oauth/2.0/toke';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://openapi.baidu.com/rest/2.0/passport/users/getInfo', [
            'query' => [
                'access_token' => $token,
            ],
        ]);

        //return json_decode($response->getBody()->getContents(), true)['items'][0];
        return json_decode($response->getBody()->getContents(), true);

    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['userid'],
            'nickname' => $user['username'],
            'avatar'   => $this->getPortraitUrl($user['portrait']),
            'name'     => null,
            'email'    => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }

}
