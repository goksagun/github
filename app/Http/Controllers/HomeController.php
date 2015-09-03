<?php

namespace App\Http\Controllers;

use Github\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

        $this->client->authenticate(null, $this->token, Client::AUTH_URL_TOKEN);
    }

    /**
     * Display a listing of the public and private repos.
     *
     * @return Response
     */
    public function getIndex()
    {
        $repositories = $this->client->api('user')->repositories($this->username);

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
        $page = $request->input('p', 1);

        $pagination = $this->setPager($page, $query);

        $repositories = [];

        if ($query) {
            $repositories = $this->client->api('repo')->find($query, array('start_page' => $page));
            $repositories = $repositories['repositories'];
        }

        return view('search', compact('repositories', 'query', 'pagination'));
    }

    /**
     * For testing only not used app.
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getGit()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->get('https://api.github.com/search/repositories?q=symfony&sort=stars&order=desc&page=1&per_page=10');

        return $res->getBody();
    }

    /**
     * Set pager for search results.
     *
     * @param int $page
     * @param string $query
     * @param int $pagerCount
     * @return array
     */
    protected function setPager($page = 1, $query = '', $pagerCount = 5)
    {
        $previousPage = $page - 1;
        $nextPage = $page + $pagerCount;

        for ($i = $page; $i < $nextPage; $i++) {
            $links[] = [
                'active' => ($page == $i),
                'page' => $i,
                'url' => '/search?' . http_build_query(['q' => $query, 'p' => $i])
            ];
        }

        if ($previousPage == 0) {
            $previous = http_build_query(['q' => $query]);
        } else {
            $previous = http_build_query(['q' => $query, 'p' => $previousPage]);
        }
        $next = http_build_query(['q' => $query, 'p' => $nextPage]);

        $pagination = [
            'previous' => [
                'disabled' => ($previousPage == 0),
                'url' => '/search?' . $previous
            ],
            'links' => $links,
            'next' => [
                'disabled' => ($nextPage == 0),
                'url' => '/search?' . $next
            ],
            'current' => $page
        ];
        return $pagination;
    }
}
