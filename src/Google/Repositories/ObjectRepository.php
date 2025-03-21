<?php declare(strict_types=1);

namespace Chiiya\Passes\Google\Repositories;

use Chiiya\Passes\Common\Component;
use Chiiya\Passes\Google\Components\Common\Message;
use Chiiya\Passes\Google\Passes\AbstractObject;

abstract class ObjectRepository extends BaseRepository implements ObjectRepositoryInterface
{
    /**
     * Get a list of all instances, filtered by class id.
     */
    final public function index(string $classId, array $parameters = []): Component
    {
        $url = $this->buildResourceUrl().'?'.http_build_query(array_merge([
            'classId' => $classId,
        ], $parameters));
        /** @var Component $class */
        $class = $this->getResponseClass();
        $response = $this->client->get($url);

        return $class::decode($response);
    }

    /**
     * Add a message to a passes object.
     */
    final public function addMessage(AbstractObject $instance, Message $message): Component
    {
        /** @var Component $class */
        $class = $this->getInstanceClass();
        $response = $this->client->put($this->buildEntityUrl($instance->id).'/addMessage', $message);

        return $class::decode($response);
    }
}
