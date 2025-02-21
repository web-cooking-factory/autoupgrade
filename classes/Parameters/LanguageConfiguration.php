<?php

namespace PrestaShop\Module\AutoUpgrade\Parameters;

use Doctrine\Common\Collections\ArrayCollection;

class LanguageConfiguration extends ArrayCollection
{
    const ISO_LANGUAGES = 'ISO_LANGUAGES';

    public function getIsoLanguages(): ?string
    {
        return $this->get(self::ISO_LANGUAGES);
    }

    /**
     * @param array<string, mixed> $array
     *
     * @return void
     */
    public function merge(array $array = []): void
    {
        foreach ($array as $key => $value) {
            $this->set($key, $value);
        }
    }
}
