<?php

namespace Guillermoandrae;

interface PostInterface
{
    public function getCreatedAt(string $format = DATE_ATOM): string;
}
