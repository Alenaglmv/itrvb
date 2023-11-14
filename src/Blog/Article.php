<?php

namespace Galim\Itrvb\Blog;

class Article {
    public function __construct(private UUID $uuid, private UUID $authorUuid, private string $title, private string $texts) {

    }

    public function __toString()
    {
        return
            "UUID : " . $this->getUuid() . "<br>" .
            "UUID автора: " . $this->getAuthorUuid() ."<br>".
            "Заголовок : " . $this->getTitle() . "<br>" .
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTexts(): string
    {
        return $this->texts;
    }
}
