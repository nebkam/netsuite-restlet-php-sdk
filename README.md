# Setup
PHP ^7.2 compatible

For PHP ^5.6 compatibility, see [`v1` branch](https://github.com/nebkam/netsuite-restlet-php-sdk/tree/v1)

## Symfony 3.4+
- Run `composer require infostud/netsuite-sdk:^2.1`
- Add a JSON [config file](sample.config.json)
- Add the path to the config file to your `.env.local`
- Register the service definition in your `services.yml`
```yaml
Infostud\NetSuiteSdk\ApiService:
    arguments:
        - '%env(NETSUITE_CONFIG_PATH)%'
```
