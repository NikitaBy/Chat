<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Message
 * @ORM\Entity()
 * @ORM\Table(name="message")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User $user
     * @ORM\OneToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @var ChatRoom $chatRoom
     * @ORM\ManyToOne(targetEntity=ChatRoom::class)
     */
    private $chatRoom;

    /**
     * @var string $text
     * @ORM\Column(nullable=false)
     * @Assert\NotBlank()
     */
    private $text;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Message
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Message
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set chatRoom
     *
     * @param \AppBundle\Entity\ChatRoom $chatRoom
     *
     * @return Message
     */
    public function setChatRoom(\AppBundle\Entity\ChatRoom $chatRoom = null)
    {
        $this->chatRoom = $chatRoom;

        return $this;
    }

    /**
     * Get chatRoom
     *
     * @return \AppBundle\Entity\ChatRoom
     */
    public function getChatRoom()
    {
        return $this->chatRoom;
    }
}
