<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 06/10/2016
 * Time: 10:43
 */

namespace ControleProjetos\Presenters;

use ControleProjetos\Transformers\ProjectFileTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ProjectFilePresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new ProjectFileTransformer();
    }
}