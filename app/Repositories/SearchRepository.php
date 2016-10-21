<?php namespace JobApis\JobsToMail\Repositories;

use JobApis\JobsToMail\Models\Search;

class SearchRepository implements Contracts\SearchRepositoryInterface
{
    /**
     * @var Search model
     */
    public $searches;

    /**
     * SearchRepository constructor.
     *
     * @param Search $model
     */
    public function __construct(Search $searches)
    {
        $this->searches = $searches;
    }

    /**
     * Create a single search for a user
     *
     * @param string $userId
     * @param array $data
     *
     * @return Search
     */
    public function create($userId = null, $data = [])
    {
        return $this->searches->create(
            array_merge(['user_id' => $userId], $data)
        );
    }

    /**
     * Delete a search by ID
     *
     * @param string $id
     *
     * @return boolean
     */
    public function delete($id = null)
    {
        return $this->searches->where('id', $id)
            ->first()
            ->delete();
    }

    /**
     * Get all active searches from confirmed users
     *
     * @param null | string $userEmail
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActive($userEmail = null)
    {
        $query = $this->searches->active();
        if ($userEmail) {
            $query = $query->whereUserEmail($userEmail);
        }
        return $query->get();
    }
}
