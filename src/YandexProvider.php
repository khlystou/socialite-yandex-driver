<?php

declare(strict_types=1);

namespace Khlystou\SocialiteYandexDriver;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;
use Laravel\Socialite\Contracts\Provider as ProviderContract;

class YandexProvider extends AbstractProvider implements ProviderContract
{
    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://oauth.yandex.ru/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://oauth.yandex.ru/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://login.yandex.ru/info', [
            RequestOptions::HEADERS => [
                'Authorization' => sprintf('Bearer %s', $token),
            ],
            RequestOptions::QUERY => [
                'format' => 'json',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'nickname' => $user['login'],
            'name' => Arr::get($user, 'real_name'),
            'email' => Arr::get($user, 'default_email'),
            'avatar' => sprintf('https://avatars.yandex.net/get-yapic/%s/islands-200', Arr::get($user, 'default_avatar_id'))
        ]);
    }
}