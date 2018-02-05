<?php

/*
 * This file is part of SocialFeedCore.
 *
 * Copyright (c) 2018 Eridan Domoratskiy
 */

namespace SocialFeedCore\SocialSources;

use SocialFeedCore\SocialSource;
use SocialFeedCore\SocialSourceTrait;
use SocialFeedCore\Utils\Post;
use SocialFeedCore\SocialSources\Exceptions\VKSocialSourceException;

/**
 * SocialSource implementation for VK social network
 *
 * Requires global "access_token" setting
 * for VK API access token and
 * id of source (profile, group)
 *
 * @author ProgMiner
 */
class VKSocialSource extends SocialSource {

    use SocialSourceTrait;

    /**
     * Requests VK API method
     *
     * @param string $method API method name
     * @param array $params Request parameters
     * @param type $accessToken Access token for request
     * @param bool $checkError If true check if result contains error and throw exception
     *
     * @return mixed Response object if $checkError = true, full result object otherwise
     *
     * @throws VKSocialSourceException
     */
    public static function api(string $method, array $params = [],
                               $accessToken = null, bool $checkError = true) {
        static::init();

        if (is_null($accessToken)) {
            if (!isset(static::$global['access_token'])) {
                throw new \LogicException('Access token is undefined');
            }

            $accessToken = static::$global['access_token'];
        }

        $request_params = array_merge(static::$global['default_api_params'],
                                      ['access_token' => $accessToken], $params);

        $get_params = http_build_query($request_params);

        $result = json_decode(file_get_contents("https://api.vk.com/method/{$method}?" . $get_params));

        if (!$checkError) {
            return $result;
        }

        if (!isset($result->error)) {
            return $result->response;
        }

        throw new VKSocialSourceException($result->error);
    }

    /**
     * Returns id by screen name
     *
     * @param string $screenName Screen name
     *
     * @return array Array with id and object type
     */
    public static function getIdByScreenName(string $screenName): array {
        $response = static::api('utils.resolveScreenName',
                                ['screen_name' => $screenName]);

        if ($response->type === 'group') {
            $response->object_id *= -1;
        }

        return [
            $response->object_id,
            $response->type
        ];
    }

    private static function makePost($post, $author): Post {
        $post = (array) $post;

        $post['content'] = $post['text'];
        unset($post['text']);

        $post['likes'] = $post['likes']->count;
        $post['reposts'] = $post['reposts']->count;
        $post['comments'] = $post['comments']->count;

        if (isset($post['views'])) {
            $post['views'] = $post['views']->count;
        }

        $post['author'] = $author;

        return new Post($post);
    }

    public static function getSocialName(): string {
        return "VK.com";
    }

    private static function _init() {
        static::$global['default_api_params'] = [
            'v' => '5.69'
        ];
    }

    /**
     * @param int|string $id Id of source
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($id) {
        if (is_string($id)) {
            $id = static::getIdByScreenName($id)[0];
        }

        if (is_int($id)) {
            $this['id'] = $id;
            return;
        }

        throw new \InvalidArgumentException("Id must be a string or an integer");
    }

    public function getPost(int $id): Post {
        $result = static::api('wall.getById',
                              ['posts' => "{$this['id']}_{$id}"],
                              $this['access_token']);

        return static::makePost($result);
    }

    public function getPosts(array $options = []): array {
        $options['owner_id'] = $this['id'];
        $options['extended'] = 1;

        if (isset($options['fields'])) {
            $options['fields'] .= ', domain, photo_max';
        }

        $result = static::api('wall.get', $options, $this['access_token']);

        $authors = [];
        foreach ($result->profiles as $profile) {
            $profile->full_name = "{$profile->first_name} {$profile->last_name}";
            $profile->avatar = $profile->photo_max;
            $profile->url = "https://vk.com/{$profile->domain}";

            $authors[$profile->id] = $profile;
        }

        /*
        foreach ($result->groups as $group) {
            $group->full_name = $profile->first_name = $profile->name;
            $group->avatar = $profile->photo_200;
            $group->url = "https://vk.com/{$profile->screen_name}";

            $authors[$group->id] = $group;
        }
        */

        $result = $result->items;

        $posts = [];
        foreach ($result as $post) {
            $posts[] = static::makePost($post, $authors[$post->from_id]);
        }

        return Post::sortPostsByDate($posts);
    }

    public function getLastPosts(int $count, array $options = []): array {
        if ($count > 100) {
            $count = 100;
        }

        $options['count'] = $count;

        return $this->getPosts($options);
    }

    public function getNewPosts(\DateTime $after, array $options = []): array {
        $posts = [];
        $_postsTmp = [];

        for ($offset = 0;
                    $offset == 0 || $posts[count($posts) - 1]->date > $after;
                    $offset += count($_postsTmp)) {
            $options['offset'] = $offset;
            $_postsTmp = $this->getPosts($options);
            $posts = array_merge($posts, $_postsTmp);
        }

        for ($i = count($posts) - 1; count($posts) > 0; --$i) {
            if ($posts[$i]->date < $after) {
                unset($posts[$i]);
            } else {
                break;
            }
        }

        return Post::sortPostsByDate(array_values($posts));
    }

}
