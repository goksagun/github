<?php

namespace Github\Contracts;


interface Pager
{
    public function render();

    public function raw();
}