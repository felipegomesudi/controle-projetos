<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 06/10/2016
 * Time: 10:27
 */

namespace ControleProjetos\Transformers;

use ControleProjetos\Entities\ProjectMember;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'user'
    ];

    public function transform(ProjectMember $member)
    {
        return [
            'id' => $member->id,
            'project_id' => $member->project_id,
        ];
    }

    public function includeUser(ProjectMember $member){
        return $this->item($member->member, new MemberTransformer());
    }

}