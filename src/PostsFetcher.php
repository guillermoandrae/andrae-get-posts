<?php declare(strict_types=1);

namespace Guillermoandrae;

use Aws\Sdk;
use Aws\S3\S3Client;
use Aws\DynamoDb\Marshaler;
use Aws\DynamoDb\DynamoDbClient;
use Guillermoandrae\Common\Collection;
use Aws\DynamoDb\Exception\DynamoDbException;
use Guillermoandrae\Common\CollectionInterface;

final class PostsFetcher
{
    /**
     * @var Sdk
     */
    private $sdk;

    /**
     * @var S3Client
     */
    private $s3;

    /**
     * @var DynamoDbClient
     */
    private $dynamoDb;

    /**
     * @var Marshaler
     */
    private $marshaler;

    /**
     * @var string
     */
    private $tableName = 'social-media-posts';
    
    /**
     * Registers the SDK and Marshaler with this object.
     *
     * @param Sdk $sdk
     * @param Marshaler $marshaler
     */
    public function __construct(Sdk $sdk, Marshaler $marshaler)
    {
        $this->sdk = $sdk;
        $this->s3 = $sdk->createS3();
        $this->dynamodb = $sdk->createDynamoDb();
        $this->marshaler = $marshaler;
    }

    /**
     * Returns the most recent post.
     *
     * @return PostInterface|null  The most recent post (if one exists)
     */
    public function fetchOne(): PostInterface
    {
        return $this->fetchAll()->first();
    }

    public function fetchAll(int $offset = 0, int $limit = 25): CollectionInterface
    {
        $result = $this->dynamodb->query([
            'TableName' => $this->tableName,
        ]);
        $posts = [];
        foreach ($result['Items'] as $item) {
            $posts[] = $this->populate($item);
        }
        $collection = Collection::make($posts);
        return $collection->limit($offset, $limit);
    }

    private function populate(array $item): PostInterface
    {
        $postData = [];
        foreach ($item as $key => $value) {
            $postData[$key] = $value['S'];
        }
        return new Post($postData);
    }
}
