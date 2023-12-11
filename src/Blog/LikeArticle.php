<?php

namespace Galim\Itrvb\Blog;

class LikeArticle {
    public function __construct(private UUID $uuid, private UUID $articleUuid, private UUID $userUuid) {

    }

    public function __toString()
    {
        return
            "UUID : " . $this->getUuid() . "<br>" .
            "UUID статьи: " . $this->getArticleUuid() ."<br>".
            "UUID пользователя: " . $this->getUserUuid() ."<br>";
    }

    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    public function getArticleUuid(): UUID
    {
        return $this->articleUuid;
    }

    public function getUserUuid(): UUID
    {
        return $this->userUuid;
    }
}