<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __toString()
    {
        return $this->username.'('.$this->email.')';
    }

    /**
     * @var ChatRoom[] $chatRooms
     *
     * @ORM\ManyToMany(targetEntity=ChatRoom::class, mappedBy="users")
     */
    private $chatRooms;

    /**
     * Add chatRoom
     *
     * @param ChatRoom $chatRoom
     *
     * @return User
     */
    public function addChatRoom(ChatRoom $chatRoom)
    {
        $this->chatRooms[] = $chatRoom;

        return $this;
    }

    /**
     * Remove chatRoom
     *
     * @param ChatRoom $chatRoom
     */
    public function removeChatRoom(ChatRoom $chatRoom)
    {
        $this->chatRooms->removeElement($chatRoom);
    }

    /**
     * Get chatRooms
     *
     * @return Collection|ChatRoom[]
     */
    public function getChatRooms()
    {
        return $this->chatRooms;
    }
}
