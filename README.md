<p align="center">
  <img src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" alt="seven logo" />
</p>

<h1 align="center">seven SMS for Contao Notification Center</h1>

<p align="center">
  Adds seven as an SMS gateway for the <a href="https://github.com/terminal42/contao-notification_center">Contao Notification Center</a>.
</p>

<p align="center">
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-teal.svg" alt="MIT License" /></a>
  <img src="https://img.shields.io/badge/Contao-4.x-blue" alt="Contao 4.x" />
  <img src="https://img.shields.io/badge/status-DEPRECATED-red" alt="Deprecated" />
</p>

> **DEPRECATED:** This plugin is no longer actively maintained. Please consider switching to a maintained Contao SMS gateway or [contact us](https://www.seven.io/en/company/contact/) for guidance.

---

## Features

- **Contao Notification Center Gateway** - Adds *SMS (seven)* as a selectable gateway type
- **Composer-Installable** - Standard Contao bundle install via Composer

## Prerequisites

- [Contao 4](https://contao.org/)
- [Notification Center](https://github.com/terminal42/contao-notification_center) installed
- A [seven account](https://www.seven.io/) with API key ([How to get your API key](https://help.seven.io/en/developer/where-do-i-find-my-api-key))

## Installation

1. Install via the Contao Manager **or** Composer:

   ```bash
   composer require seven.io/contao-notification_center
   ```

2. Run a database update via the Contao install tool or:

   ```bash
   vendor/bin/contao-console contao:migrate
   ```

3. Create a `SMS (seven)` gateway in the Notification Center.

## Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact/) or [open an issue](https://github.com/seven-io/contao-notification_center/issues).

## License

[MIT](LICENSE)
