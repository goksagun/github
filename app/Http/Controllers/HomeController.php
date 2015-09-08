<?php

namespace App\Http\Controllers;


use Github\Client;
use Github\Pagination;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    private $client;

    private $token;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->token = session('github.token')[0];

        $this->client->auth($this->token);
    }

    /**
     * Display a listing of the public and private repos.
     *
     * @return Response
     */
    public function getIndex()
    {
        $repositories = $this->client->userRepos()->toArray();

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
