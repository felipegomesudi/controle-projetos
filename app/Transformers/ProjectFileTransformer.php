<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 06/10/2016
 * Time: 10:27
 */

namespace ControleProjetos\Transformers;

use ControleProjetos\Entities\ProjectFile;
use League\Fractal\TransformerAbstract;

class ProjectFileTransformer extends TransformerAbstract
{

    public function transform(ProjectFile $projectFile)
    {
        return [
            'id' => $projectFile->id,
            'name' => $projectFile->name,
            'extension' => $projectFile->extension,
            'description' => $projectFile->description,
        ];
    }

}