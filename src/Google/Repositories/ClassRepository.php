<?php declare(strict_types=1);

namespace Chiiya\Passes\Google\Repositories;

use Chiiya\Passes\Common\Component;
use Chiiya\Passes\Google\Components\Common\Message;
use Chiiya\Passes\Google\Passes\AbstractClass;

abstract class ClassRepository extends BaseRepository implements ClassRepositoryInterface
{
    /**
     * Get a list of all instances, filtered by issuer id.
     */
    final public function index(string $issuerId, array $parameters = []): Component
    {
        $url = $this->buildResourceUrl().'?'.http_build_query(array_merge([
            'issuerId' => $issuerId,
        ], $parameters));
        /** @var Component $class */
        $class = $this->getResponseClass();
        $response = $this->client->get($url);

        return $class::decode($response);
    }

    /**
     * Add a message to a passes class.
     */
    final public function addMessage(AbstractClass $instance, Message $message): Component
    {
        /** @var Component $class */
        $class = $this->getInstanceClass();
        $response = $this->client->put($this->buildEntityUrl($instance->id).'/addMessage', $message);

        return $class::decode($response);
    }
}
