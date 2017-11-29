<?php
/**
 * @author a.boukhanfra <a.boukhanfra@paritel.fr>
 * @date 2017-11-28
 */
namespace Test\Model;

/**
 * Class Task
 * @package Test\Model
 */
class Task
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $creationDate;

    /**
     * @var string
     */
    private $status;

    /**
     * @var User
     */
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Task
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     * @return Task
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Task
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $creationDate = '';
        if (!is_null($this->creationDate)) {
            $creationDate = $this->creationDate->format('d/m/Y H:i:s');
        }
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'creationDate' => $creationDate,
            'status' => $this->status,
            'user' => $this->user->toArray()
        );
    }
}
