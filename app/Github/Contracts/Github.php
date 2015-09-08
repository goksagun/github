<?php

namespace Github\Contracts;


interface Github
{
    /**
     * Get a single user
     * -----------------------------------------------------------
     * - GET /users/:username
     *
     * Response;
     * Note: The returned email is the user’s publicly visible email
     * address (or null if the user has not specified a public email
     * address in their profile).
     *
     * @param string $username
     * @return mixed
     */
    public function users($username);

    /**
     * Get the authenticated user
     * -----------------------------------------------------------
     * - GET /user
     *
     * @return mixed
     */
    public function user();

    /**
     * Get all users
     * -----------------------------------------------------------
     * - GET /users
     *
     * Lists all users, in the order that they signed up on GitHub.
     *
     * Note: Pagination is powered exclusively by the since parameter.
     * Use the Link header to get the URL for the next page of users.
     *
     * Parameters;
     * since:    string    The integer ID of the last User that you’ve
     * seen.
     *
     * @param null $since
     * @return mixed
     */
    public function allUsers($since = null);

    /**
     * List your repositories
     * -----------------------------------------------------------
     * - GET /user/repos
     *
     * List repositories that are accessible to the authenticated user.
     *
     * This includes repositories owned by the authenticated user,
     * repositories where the authenticated user is a collaborator, and
     * repositories that the authenticated user has access to through
     * an organization membership.
     *
     * Parameters;
     * visibility:        string    Can be one of all, public, or private. Default: all
     * affiliation:       string    Comma-separated list of values. Can include:
     * - owner: Repositories that are owned by the authenticated user.
     * - collaborator: Repositories that the user has been added to as a collaborator.
     * - organization_member: Repositories that the user has access to through being a
     * member of an organization. This includes every repository on every team that
     * the user is on. Default: owner,collaborator,organization_member
     * type:            string    Can be one of all, owner, public, private, member. Default: all
     * Will cause a 422 error if used in the same request as visibility or affiliation.
     * sort:            string    Can be one of created, updated, pushed, full_name. Default: full_name
     * direction:       string    Can be one of asc or desc. Default: when using full_name: asc; otherwise desc
     *
     * @param array $params
     * @return mixed
     */
    public function userRepos($params = []);

    /**
     * List user repositories
     * -----------------------------------------------------------
     * - GET /users/:username/repos
     *
     * List public repositories for the specified user.
     *
     * Parameters;
     * type:    	string	Can be one of all, owner, member. Default: owner
     * sort:       	string	Can be one of created, updated, pushed, full_name. Default: full_name
     * direction:	string	Can be one of asc or desc. Default: when using full_name: asc, otherwise desc
     *
     * @param $username
     * @param array $params
     * @return mixed
     */
    public function usersRepos($username, $params = []);

    /**
     * List organization repositories
     * -----------------------------------------------------------
     * - GET /orgs/:org/repos
     *
     * List repositories for the specified org.
     *
     * Parameters;
     * type:    string    Can be one of all, public, private, forks, sources, member. Default: all
     *
     * @param $organization
     * @param array $params
     * @return mixed
     */
    public function orgsRepos($organization, $params = []);

    /**
     * List all public repositories
     * -----------------------------------------------------------
     * - GET /repositories
     *
     * This provides a dump of every public repository, in the order that they were created.
     *
     * Parameters;
     * since:    string    The integer ID of the last Repository that you’ve seen
     *
     * Note: Pagination is powered exclusively by the since parameter.
     * Use the Link header to get the URL for the next page of repositories.
     *
     * @param array $params
     * @return mixed
     */
    public function publicRepos($params = []);

    /**
     * Get
     * -----------------------------------------------------------
     * - GET /repos/:owner/:repo
     *
     * Response;
     * The parent and source objects are present when the repository is a fork.
     * parent is the repository this repository was forked from, source is the ultimate source for the network.
     *
     * @param $owner
     * @param $repo
     * @return mixed
     */
    public function ownerRepo($owner, $repo);

    /**
     * Search repositories
     * -----------------------------------------------------------
     * - GET /search/repositories
     *
     * Find repositories via various criteria. This method returns up to 100 results per page.
     *
     * Parameters;
     * q:    string    The search keywords, as well as any qualifiers.
     * sort:    string    The sort field. One of stars, forks, or updated. Default: results are sorted by best match.
     * order:    string    The sort order if sort parameter is provided. One of asc or desc. Default: desc
     *
     * @param $params
     * @return mixed
     */
    public function search($params);
}