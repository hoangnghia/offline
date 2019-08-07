<?php

namespace App\Shop\Employees\Repositories;

use App\Shop\Campaigns\Campaign;
use App\Shop\Campaigns\Repositories\Interfaces\CampaignRepositoryInterface;
use App\Shop\Employees\Exceptions\CampaignNotFoundException;
use Jsdecena\Baserepo\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CampaignRepository extends BaseRepository implements CampaignRepositoryInterface
{
    /**
     * CampaignRepository constructor.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        parent::__construct($campaign);
        $this->model = $campaign;
    }

    /**
     * List all the campaign
     *
     * @param string $order
     * @param string $sort
     *
     * @return Collection
     */
    public function listCampaign(string $order = 'id', string $sort = 'desc'): Collection
    {
        return $this->all(['*'], $order, $sort);
    }

    /**
     * Create the campaign
     *
     * @param array $data
     *
     * @return Campaign
     */
    public function createCampaign(array $data): Campaign
    {
        $data['password'] = Hash::make($data['password']);
        return $this->create($data);
    }

    /**
     * Find the campaign by id
     *
     * @param int $id
     *
     * @return Campaign
     */
    public function findCampaignById(int $id): Campaign
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CampaignNotFoundException();
        }
    }

    /**
     * Update campaign
     *
     * @param array $params
     *
     * @return bool
     */
    public function updateCampaign(array $params): bool
    {
        if (isset($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }

        return $this->update($params);
    }

    /**
     * @param array $roleIds
     */
    public function syncRoles(array $roleIds)
    {
        $this->model->roles()->sync($roleIds);
    }

    /**
     * @return Collection
     */
    public function listRoles(): Collection
    {
        return $this->model->roles()->get();
    }

    /**
     * @param string $roleName
     *
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->model->hasRole($roleName);
    }

    /**
     * @param Campaign $campaign
     *
     * @return bool
     */
    public function isAuthUser(Campaign $campaign): bool
    {
        $isAuthUser = false;
        if (Auth::guard('campaign')->user()->id == $campaign->id) {
            $isAuthUser = true;
        }
        return $isAuthUser;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCampaign(): bool
    {
        return $this->delete();
    }
}
