<?php

namespace Guillermoandrae;

use Guillermoandrae\Common\AbstractAggregate;

final class Post extends AbstractAggregate implements PostInterface
{
    /**
     * Returns a formatted date.
     *
     * @param string $format  OPTIONAL The date format
     * @return string
     */
    public function getCreatedAt(string $format = DATE_ATOM): string
    {
        $dateTime = (new \DateTime(null, new \DateTimeZone('EDT')))
            ->setTimestamp($this->get('createdAt'));
        return $dateTime->format($format);
    }
}
