# SamJUK_MediaProxy

[![Supported Magento Versions](https://img.shields.io/badge/magento-2.4.3%E2%80%932.4.7-orange.svg?logo=magento)](https://github.com/SamJUK/m2-module-media-proxy/actions/workflows/ci.yml)
[![CI Workflow Status](https://github.com/samjuk/m2-module-media-proxy/actions/workflows/ci.yml/badge.svg)](https://github.com/SamJUK/m2-module-media-proxy/actions/workflows/ci.yml)
[![GitHub Release](https://img.shields.io/github/v/release/SamJUK/m2-module-media-proxy?label=Latest%20Release&logo=github)](https://github.com/SamJUK/m2-module-media-proxy/releases)

This module enables you to proxy/download missing images from an upstream source, weather that is a staging or production site. 

Especially useful when working on multiple large projects, by keeping the local media footprint slim. And providing a zero touch approach for new developers to get started working on local projects.

It can either proxy missing media to the upstream, which is the best approach for maximizing disk space. Or it can cache the proxied media, which will improve TTFB for missing images whilst sacrificing some disk space savings. And improve compatibility with third party image related extensions.

The intent of this module is to be run on development & integration environments, specifically when working with multiple large installations.

Alternatives approaches to achieve similar functionality on a infrastructure level can be found over on my [Documentation Site](https://docs.sdj.pw/magento/media-management.html)

## Installation

Whilst the default configuration of this module does nothing. I strongly suggest enabling & configuring this module via your `env.php`.

```sh
composer require samjuk/m2-module-media-proxy
php bin/magento module:enable SamJUK_MediaProxy && php bin/magento cache:flush
```

## Configuration
Configuration can be handled via System configuration, from within the Media Proxy menu of the SamJUK Tab.

Or can be set via the CLI
```sh
php bin/magento config:set --lock-env samjuk_media_proxy/general/enabled 1
php bin/magento config:set --lock-env samjuk_media_proxy/general/mode 'proxy'
php bin/magento config:set --lock-env samjuk_media_proxy/general/upstream_host 'https://www.example.com'
```

Option | Config Path | Default | Description
--- | --- | --- | ---
Enabled | `samjuk_media_proxy/general/enabled` | `0` | Feature flag to toggle functionality of the module
Mode | `samjuk_media_proxy/general/mode` | `proxy` | Proxy (302 redirect) requests to the upstream, or download the files on demand. Options are: `proxy` | `cache`.
Upstream Host | `samjuk_media_proxy/general/upstream_host` | `-` | FQDN URL of the upstream host to fetch missing images from (e.g `https://www.example.com`).
