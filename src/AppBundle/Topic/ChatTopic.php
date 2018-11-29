<?php

namespace AppBundle\Topic;


use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class ChatTopic implements TopicInterface
{

    /**
     * @param  ConnectionInterface $connection
     * @param  \Ratchet\Wamp\Topic $topic
     * @param WampRequest $request
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $room = $request->getAttributes()->get('room');
        $userId = $request->getAttributes()->get('user_id');

        //this will broadcast the message to ALL subscribers of this topic.
        $topic->broadcast(['msg' => 'Новый пользователь зашел в комнату ' . $room . ' в личку к пользователю ' . $userId]);
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
//        $room = $request->getAttributes()->get('room');
//        $userId = $request->getAttributes()->get('user_id');
//
//        $topic->broadcast([
//            'msg' => 'В комнату ' . $room . 'пользователю ' . $userId . ' поступило сообщение: ' . $event,
//        ]);
        $this->sendMessage($topic, $event);
    }

    public function sendMessage(Topic $topic, $event)
    {
        $message = $event['msg'];
        $user = $event['user'];
        $topic->broadcast([
            'msg' => $message,
            'user' => $user,
        ]);

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app.topic.chat';
    }
}
