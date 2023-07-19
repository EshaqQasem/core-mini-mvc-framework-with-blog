<?php

namespace myframework\View;

interface IView
{
    public function getOutput():string;

    public function __toString(): string;
}