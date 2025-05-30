# SERC 2025

A Wordpress theme for the Systems Engineering Research Center (SERC).

### Server Requirements

- PHP 8.2
- Node v23.8.0
- NPM v10.9.2

### Deployment

Depending on the build process (Github actions or some other CD pipeline), the following steps need to take place to successfully publish the site to a live environment:

- Setup global variables in wp-config.php

```
define('OPENSEARCH_BASE_URI', 'https://url.to.amazonaws.com');
define('OPENSEARCH_AUTH_USER', 'user');
define('OPENSEARCH_AUTH_PASS', 'password');
define('ENVIRONMENT', 'dev' | 'staging' | 'production' );
```

- Install composer dependencies: `composer install`
- Build static assets (_with proper Node version. See /.nvmrc_): `npm run build`
- Push the following directories and files to the live server:
  - /**wp-content**
  - /composer.json
  - /composer.lock
