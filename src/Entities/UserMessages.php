<?php

namespace WeBid;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserMessages
 *
 * @ORM\Table(name="user_messages")
 * @ORM\Entity
 */
class UserMessages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_message_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userMessageId;

    /**
     * @var integer
     *
     * @ORM\Column(name="sender_user_id", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(name="sender_user_id", referencedColumnName="user_id")
     */
    private $senderUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="receiver_user_id", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(name="receiver_user_id", referencedColumnName="user_id")
     */
    private $receiverUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="fromemail", type="string", length=255, nullable=true)
     */
    private $fromemail;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_read", type="boolean", nullable=false)
     */
    private $isRead = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=false)
     */
    private $subject = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="replied", type="boolean", nullable=false)
     */
    private $replied = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="reply_of", type="integer", nullable=true)
     */
    private $replyOf;

    /**
     * @var integer
     *
     * @ORM\Column(name="auction_id", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="Auctions")
     * @ORM\JoinColumn(name="auction_id", referencedColumnName="auction_id")
     */
    private $auctionId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=false)
     */
    private $isPublic = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getUserMessageId()
    {
        return $this->userMessageId;
    }

    /**
     * @return int
     */
    public function getSenderUserId()
    {
        return $this->senderUserId;
    }

    /**
     * @param int $senderUserId
     */
    public function setSenderUserId($senderUserId)
    {
        $this->senderUserId = $senderUserId;
    }

    /**
     * @return int
     */
    public function getReceiverUserId()
    {
        return $this->receiverUserId;
    }

    /**
     * @param int $receiverUserId
     */
    public function setReceiverUserId($receiverUserId)
    {
        $this->receiverUserId = $receiverUserId;
    }

    /**
     * @return string
     */
    public function getFromemail()
    {
        return $this->fromemail;
    }

    /**
     * @param string $fromemail
     */
    public function setFromemail($fromemail)
    {
        $this->fromemail = $fromemail;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isRead()
    {
        return $this->isRead;
    }

    /**
     * @param bool $isRead
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return bool
     */
    public function isReplied()
    {
        return $this->replied;
    }

    /**
     * @param bool $replied
     */
    public function setReplied($replied)
    {
        $this->replied = $replied;
    }

    /**
     * @return int
     */
    public function getReplyOf()
    {
        return $this->replyOf;
    }

    /**
     * @param int $replyOf
     */
    public function setReplyOf($replyOf)
    {
        $this->replyOf = $replyOf;
    }

    /**
     * @return int
     */
    public function getAuctionId()
    {
        return $this->auctionId;
    }

    /**
     * @param int $auctionId
     */
    public function setAuctionId($auctionId)
    {
        $this->auctionId = $auctionId;
    }

    /**
     * @return bool
     */
    public function isPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param bool $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


}

