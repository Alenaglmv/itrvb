<?php

namespace Galim\Itrvb\Blog;

class Comment {
    public function __construct(private UUID $uuid, private UUID $authorUuid, private UUID $articleUuid, private string $texts) {

    }

    public function __toString()
    {
        return
            "UUID : " . $this->getUuid() . "<br>" .
            "UUID автора: " . $this->getAuthorUuid() ."<br>".
            "UUID статьи: " . $this->getArticleUuid() . "<br>" .
            "Текст : " . $this->getTexts() . "<br>";
    }

    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    public function getAuthorUuid(): UUID
    {
        return $this->authorUuid;
    }

    public function getArticleUuid(): UUID
    {
        return $this->articleUuid;
    }

    public function getTexts(): string
    {
        return $this->texts;
    }
}
