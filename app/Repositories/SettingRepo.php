<?php
namespace App\Repositories;

use App\Models\Setting;

class SettingRepo extends BaseRepository
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all settings.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\Setting>
     */
    public function getFirstData()
    {
        return $this->model->first();
    }



}
