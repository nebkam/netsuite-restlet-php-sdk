# Setup
## Symfony 3.4+
- Run `composer require infostud/netsuite-sdk`
- Add a JSON [config file](sample.config.json)
- Add the path to the config file to your `.env.local`
- Register the service definition in your `services.yml`
```yaml
Infostud\NetSuiteSdk\ApiService:
    arguments:
        - '%env(NETSUITE_CONFIG_PATH)%'
```
