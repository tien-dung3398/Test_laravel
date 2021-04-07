<?php

namespace Modules\Attribute\Repositories;

use Modules\Attribute\Entities\Attribute;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class AttributeRepository
 * @package Modules\Platform\User\Repositories
 */
class AttributeRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Attribute::class;
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return Attribute
     * @throws ValidatorException
     *
     */
    public function create(array $attributes)
    {
        return parent::create($attributes);
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return Attribute
     * @throws ValidatorException
     *
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function filter($request)
    {
        $invalid = $request->get('invalid', 0);
        $query = Attribute::query();
        if ($request->get('search')) {
            $search = $request->get('search');
            $query->where('name', 'LIKE', '%' . $search . '%');
        }
        if ($request->get('category_ids') || $invalid) {
            $categoryId = explode(',', $request->get('category_ids'));
            $query->where(function ($sql) use ($categoryId, $invalid) {
                if (!empty($categoryId)) {
                    $sql->wherehas('categories', function ($sql1) use ($categoryId) {
                        $sql1->whereIn('category_id', $categoryId);
                    });
                }
                if ($invalid) {
                    $sql->orDoesntHave('categories');
                }
            });
        }

        if ($request->get('group_ids')) {
            $groupId = explode(',', $request->get('group_ids'));
            $query->whereIn('group', $groupId);
        }

        return $query->paginate(intval($request->get('per_page')));
    }
}
