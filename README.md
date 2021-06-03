[![Tests](https://github.com/nebkam/netsuite-restlet-php-sdk/actions/workflows/tests.yml/badge.svg)](https://github.com/nebkam/netsuite-restlet-php-sdk/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/infostud/netsuite-sdk/v)](//packagist.org/packages/infostud/netsuite-sdk)

# Setup
PHP ^7.2 compatible

For PHP ^5.6 compatibility, see [`v1` branch](https://github.com/nebkam/netsuite-restlet-php-sdk/tree/v1)

## Symfony 3.4+
- Run `composer require infostud/netsuite-sdk:^2`
- Add a JSON config file based on [sample](sample.config.json)
- Set the path to that file in `NETSUITE_CONFIG_PATH` environment variable
- Register the service definition in your `services.yml`
```yaml
Infostud\NetSuiteSdk\ApiService:
    arguments:
        - '%env(NETSUITE_CONFIG_PATH)%'
```
