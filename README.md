# pico-matomo

Untested Alpha Version! Do not use it in productive environments.

This Plugin will let you enjoy the power of Matomo web analytics for all your [Pico CMS](http://picocms.org) pages.

## Installation

Clone directly from Github

    cd plugins
    git clone https://github.com/maloja/pico-matomo
    
Or, if you installed Pico CMS with composer

    composer require maloja/pico-matomo

## Settings

This plugin needs to be configured in the Pico CMS main configuration  in `config/config.yml`

    matomo:
        id: [matomo-id]
        server: [matomo servername]
        lang: [language tag]

The `matomo-id` as well as the `matomo servername` can be looked up in the matomo configutarion from your web analytics server. For `language tag` you can use the standard tags like en, fr, de

## Embedding an OPT-OUT iFrame

Your users should always have a way to decline web tracking. Therefore Matomo uses an OPT-OUT Code which can be embed into a webpage. With this pluging this you can be achieve this adding the keyword `(% matomo %)` in your content pages at the appropriate place.    
