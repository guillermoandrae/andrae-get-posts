<?php

namespace GuillermoandraeTest;

use Guillermoandrae\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testGetCreatedAt()
    {
        $dateTime = new \DateTime(null, new \DateTimeZone('EDT'));
        $data = [ 'createdAt' => $dateTime->getTimestamp() ];
        $this->assertSame($dateTime->format(DATE_ATOM), (new Post($data))->getCreatedAt());
    }
}
