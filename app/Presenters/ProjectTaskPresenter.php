<?php
/**
 * Created by PhpStorm.
 * User: Felipe
 * Date: 06/10/2016
 * Time: 10:43
 */

namespace ControleProjetos\Presenters;

use ControleProjetos\Transformers\ProjectTaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ProjectTaskPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new ProjectTaskTransformer();
    }
}