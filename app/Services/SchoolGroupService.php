<?php
namespace App\Services;

use App\Events\SchoolGroupCreated;

use App\Models\SchoolGroup;
use Illuminate\Support\Facades\DB;

class SchoolGroupService
{
    public function create(array $data): SchoolGroup
    {
        return DB::transaction(function () use ($data) {
            $group = SchoolGroup::create($data);

            event(new SchoolGroupCreated($group));
            return $group;
        });
    }

    public function update(SchoolGroup $group, array $data): SchoolGroup
    {
        return DB::transaction(function () use ($group, $data) {
            $group->update($data);
            return $group;
        });
    }

    public function delete(SchoolGroup $group): void
    {
        DB::transaction(function () use ($group) {
            $group->delete();
        });
    }
}
