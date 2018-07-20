<?php

namespace App\Entity;

class Banner implements \JsonSerializable
{
    private $id;
    private $url;
    private $timeRange;
    private $priority;

    /**
     * @param mixed $id
     * @return Banner
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $url
     * @return Banner
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param mixed $timeRange
     * @return Banner
     */
    public function setTimeRange($timeRange)
    {
        $this->timeRange = $timeRange;

        return $this;
    }

    /**
     * @param mixed $priority
     * @return Banner
     */
    public function setPriority($priority)
    {
        $this->priority = (int)$priority;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getTimeRange()
    {
        return $this->timeRange;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'url' => $this->getUrl(),
        ];
    }
}
