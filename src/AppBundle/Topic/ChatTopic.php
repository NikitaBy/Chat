<?php

namespace AppBundle\Topic;


use AppBundle\Entity\User;
use Gos\Bundle\WebSocketBundle\Client\ClientManipulatorInterface;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class ChatTopic implements TopicInterface
{
    /**
     * @var ClientManipulatorInterface $clientManipulator
     */
    private $clientManipulator;

    /**
     * ChatTopic constructor.
     *
     * @param ClientManipulatorInterface $clientManipulator
     */
    public function __construct(ClientManipulatorInterface $clientManipulator)
    {
        $this->clientManipulator = $clientManipulator;
    }


    /**
     * @param  ConnectionInterface $connection
     * @param  \Ratchet\Wamp\Topic $topic
     * @param WampRequest $request
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $user = $this->clientManipulator->getClient($connection);

        //this will broadcast the message to ALL subscribers of this topic.
        $topic->broadcast(['msg' => 'Новый пользователь зашел в комнату  в личку к пользователю ' . $user]);
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  \Ratchet\Wamp\Topic $topic
     * @param WampRequest $request
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $room = $request->getAttributes()->get('room');
        $userId = $request->getAttributes()->get('user_id');
        //this will broadcast the message to ALL subscribers of this topic.
        $topic->broadcast(['msg' => 'Новый пользователь вышел из комнаты ' . $room . ' лички с пользователем ' . $userId]);
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  \Ratchet\Wamp\Topic $topic
     * @param WampRequest $request
     * @param $event
     * @param  array $exclude
     * @param  array $eligible
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        $this->sendMessage($connection, $topic, $event);
    }

    public function sendMessage(ConnectionInterface $connection, Topic $topic, $event)
    {
        $message = $event['msg'];
//        $user = $event['user'];
        /** @var User $user */
        $user = $this->clientManipulator->getClient($connection);
        $topic->broadcast(
            [
                'msg' => $message,
                'usr' => $user->getUsername(),
            ],
            [],
            []
        );

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app.topic.chat';
    }
}
