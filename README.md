# Easyrechtssicher integration for Contao Open Source CMS

This bundle allows you to connect to the EasyRechtssicher API in order to
keep your legal sites (imprint, privacy policy, and cancellation policy) always up-to-date.
Like that, you satisfy the requirements of the DSGVO.

## Installation

Install the bundle via Composer:

```
composer require pronego/contao-easyrechtssicher
```

## Configuration

1. Once installed, insert your API key in the EasyRechtssicher section under Settings.

2. Afterwards, create a new Frontend Module inside your theme, name it and choose the type of page you want to display.

3. Finally, use the newly created module inside your article by creating a new element of type "module",
   and select the module previously created module.