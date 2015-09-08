<?php

namespace App\Http\Controllers;

use Github\Client;
use Github\Pagination;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    private $client;

    private $token;
    private $username;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->token = session('github.token')[0];
        $this->username = session('github.username')[0];

//        $this->client->authenticate($this->username, $this->token, Client::AUTH_URL_TOKEN);
//        $this->client->authenticate($this->token, null, Client::AUTH_URL_TOKEN);
//        dd(Client::AUTH_HTTP_TOKEN);
//        $this->client->authenticate(null, $this->token, Client::AUTH_HTTP_TOKEN);
    }

    /**
     * Display a listing of the public and private repos.
     *
     * @return Response
     */
    public function getIndex()
    {

        $this->client->auth($this->token);

//        $repositories = $this->client->user();
//        $repositories = $this->client->users($this->username);
//        $repositories = $this->client->allUsers(30);
        $repositories = $this->client->userRepos();
//        $repositories = $this->client->usersRepos($this->username);
//        $repositories = $this->client->orgsRepos('twitter', ['type' => 'private']);
//        $repositories = $this->client->publicRepos(['since' => 30]);
//        $repositories = $this->client->ownerRepo('goksagun', 'bayes');

        $repositories = $repositories->toArray();

        return view('home', compact('repositories'));
    }

    /**
     * Search all repos.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getSearch(Request $request)
    {
        $query = $request->input('q', '');
        $page = intval($request->input('p', 1));
        $perPage = intval($request->input('pp', 30));

        $repositories = [];

        if ($query) {
            $repositories = $this->client->search(['q' => $query, 'page' => $page, 'per_page' => $perPage])->toArray();

            $total = $repositories['total_count'];

            $pagination = new Pagination($page, $query, $total, $perPage);
        }

        return view('search', compact('repositories', 'query', 'pagination'));
    }
}
