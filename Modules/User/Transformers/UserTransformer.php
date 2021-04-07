<?php
namespace Modules\User\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\User\Entities\User;

class UserTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
}